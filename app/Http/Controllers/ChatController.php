<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Simpan pesan dari user & balasan AI ke database, kembalikan ke frontend.
     */
    public function send(Request $request)
    {
        $request->validate(['message' => 'required|string|max:2000', 'ai_reply' => 'nullable|string']);

        $userId = auth()->id();

        // Simpan pesan user
        ChatMessage::create([
            'user_id' => $userId,
            'sender'  => 'user',
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Simpan balasan AI jika ada
        if ($request->filled('ai_reply')) {
            ChatMessage::create([
                'user_id' => $userId,
                'sender'  => 'ai',
                'message' => $request->ai_reply,
                'is_read' => true,
            ]);
        }

        return response()->json(['status' => 'ok']);
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
