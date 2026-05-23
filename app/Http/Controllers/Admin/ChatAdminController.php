<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') abort(403);
            return $next($request);
        });
    }

    /**
     * Daftar semua konversasi user yang punya pesan.
     */
    public function index()
    {
        // Ambil user yang punya pesan untuk admin, beserta pesan terakhir & jumlah belum dibaca
        $conversations = User::whereHas('chatMessages', function($q) {
                $q->where('is_for_admin', true)->orWhere('sender', 'admin');
            })
            ->where('role', '!=', 'admin')
            ->withCount(['chatMessages as unread_count' => function ($q) {
                $q->where('sender', 'user')->where('is_for_admin', true)->where('is_read', false);
            }])
            ->with(['chatMessages' => function ($q) {
                $q->where(function($sub) {
                    $sub->where('is_for_admin', true)->orWhere('sender', 'admin');
                })->latest()->limit(1);
            }])
            ->orderByDesc('unread_count')
            ->get();

        $totalUnread = ChatMessage::where('sender', 'user')->where('is_for_admin', true)->where('is_read', false)->count();

        return view('admin.chat', compact('conversations', 'totalUnread'));
    }

    /**
     * Ambil semua pesan dari user tertentu (AJAX polling).
     */
    public function messages(Request $request, $userId)
    {
        $lastId = (int) $request->get('last_id', 0);

        $messages = ChatMessage::where('user_id', $userId)
            ->where(function($q) {
                $q->where('is_for_admin', true)->orWhere('sender', 'admin');
            })
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->get(['id', 'sender', 'message', 'created_at']);

        // Tandai pesan user sebagai sudah dibaca
        ChatMessage::where('user_id', $userId)
            ->where('sender', 'user')
            ->where('is_for_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    /**
     * Admin kirim balasan ke user.
     */
    public function reply(Request $request, $userId)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        // Pastikan user ada
        $user = User::where('id_user', $userId)->firstOrFail();

        $msg = ChatMessage::create([
            'user_id' => $user->id_user,
            'sender'  => 'admin',
            'message' => $request->message,
            'is_read' => false,
            'is_for_admin' => true,
        ]);

        return response()->json([
            'status'  => 'ok',
            'message' => $msg,
        ]);
    }

    /**
     * Jumlah pesan user yang belum dibaca (untuk badge navbar).
     */
    public function unreadCount()
    {
        $count = ChatMessage::where('sender', 'user')->where('is_for_admin', true)->where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }
}
