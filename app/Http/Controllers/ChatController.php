<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Simpan pesan dari user & request ke AI, kembalikan ke frontend.
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'history' => 'nullable|array'
        ]);

        $userId = auth()->id();

        // Simpan pesan user
        ChatMessage::create([
            'user_id' => $userId,
            'sender'  => 'user',
            'message' => $request->message,
            'is_read' => false,
        ]);

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json(['reply' => 'Sistem AI sedang tidak tersedia (API Key missing).', 'status' => 'error']);
        }

        // Siapkan history untuk Gemini
        $contents = $request->history ?? [];
        $contents[] = ['role' => 'user', 'parts' => [['text' => $request->message]]];

        $systemPrompt = "Kamu adalah asisten CS LaptoPedia, toko laptop online Indonesia. Jawab singkat 2-3 kalimat dalam Bahasa Indonesia. Bantu soal laptop, rekomendasi, spesifikasi, pembelian, pengiriman, dan garansi. Ramah dan to the point.";

        try {
            // Disable verify to avoid cURL SSL errors on local Laragon
            $response = Http::withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}", [
                'system_instruction' => [
                    'parts' => [['text' => $systemPrompt]]
                ],
                'contents' => $contents
            ]);

            $replyText = 'Maaf, saya tidak mengerti. Coba pertanyaan lain?';

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $replyText = $data['candidates'][0]['content']['parts'][0]['text'];
                }
            } else {
                \Log::error("Gemini API Error: " . $response->body());
                $replyText = 'Error dari AI: ' . substr($response->body(), 0, 100);
            }

            // Format markdown bold
            $replyText = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $replyText);
            // Format markdown newline
            $replyText = str_replace("\n", "<br>", $replyText);

            // Simpan balasan AI
            ChatMessage::create([
                'user_id' => $userId,
                'sender'  => 'ai',
                'message' => $replyText,
                'is_read' => true,
            ]);

            return response()->json(['reply' => $replyText, 'status' => 'ok']);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Koneksi ke AI bermasalah, coba lagi.', 'status' => 'error']);
        }
    }

    /**
     * Ambil pesan baru (admin reply) sejak last_id yang diberikan.
     */
    public function poll(Request $request)
    {
        $lastId = (int) $request->get('last_id', 0);
        $userId = auth()->id();

        $messages = ChatMessage::where('user_id', $userId)
            ->where('sender', 'admin')
            ->where('id', '>', $lastId)
            ->where('is_read', false)
            ->orderBy('id')
            ->get(['id', 'sender', 'message', 'created_at']);

        // Tandai sudah dibaca
        if ($messages->isNotEmpty()) {
            ChatMessage::where('user_id', $userId)
                ->where('sender', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json($messages);
    }
}
