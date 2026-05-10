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

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userId = auth()->user()->getKey();

        ChatMessage::create([
            'user_id' => $userId,
            'sender'  => 'user',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'status'  => 'ok',
            'message' => 'Pesan terkirim.',
        ]);
    }

    public function poll(Request $request)
    {
        $lastId = (int) $request->get('last_id', 0);
        $userId = auth()->user()->getKey();

        $messages = ChatMessage::where('user_id', $userId)
            ->where('sender', 'admin')
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->get(['id', 'sender', 'message', 'created_at']);

        if ($messages->isNotEmpty()) {
            ChatMessage::where('user_id', $userId)
                ->whereIn('id', $messages->pluck('id'))
                ->update(['is_read' => true]);
        }

        return response()->json($messages);
    }
}