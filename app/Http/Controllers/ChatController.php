<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ==========================================
    // CUSTOMER LIVE CHAT ENDPOINTS
    // ==========================================

    /**
     * Ambil riwayat chat untuk customer yang sedang login
     */
    public function getMessages()
    {
        if (!Auth::guard('web')->check()) {
            return response()->json([
                'authenticated' => false,
                'messages' => [],
            ]);
        }

        $userId = Auth::guard('web')->id();
        $user = Auth::guard('web')->user();

        // Tandai pesan dari admin sebagai sudah dibaca oleh customer
        ChatMessage::where('user_id', $userId)
            ->where('sender_type', 'admin')
            ->where('is_read_by_customer', false)
            ->update(['is_read_by_customer' => true]);

        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_type' => $msg->sender_type,
                    'message' => e($msg->message),
                    'time' => $msg->created_at->format('H:i'),
                    'date' => $msg->created_at->format('d M Y'),
                ];
            });

        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Customer mengirim pesan ke admin
     */
    public function sendMessage(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userId = Auth::guard('web')->id();

        $chat = ChatMessage::create([
            'user_id' => $userId,
            'sender_type' => 'customer',
            'sender_id' => $userId,
            'message' => trim($request->input('message')),
            'is_read_by_customer' => true,
            'is_read_by_admin' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $chat->id,
                'sender_type' => 'customer',
                'message' => e($chat->message),
                'time' => $chat->created_at->format('H:i'),
                'date' => $chat->created_at->format('d M Y'),
            ],
        ]);
    }

    /**
     * Hitung pesan baru yang belum dibaca customer
     */
    public function getUnreadCount()
    {
        if (!Auth::guard('web')->check()) {
            return response()->json(['unread' => 0]);
        }

        $count = ChatMessage::where('user_id', Auth::guard('web')->id())
            ->where('sender_type', 'admin')
            ->where('is_read_by_customer', false)
            ->count();

        return response()->json(['unread' => $count]);
    }

    // ==========================================
    // ADMIN LIVE CHAT ENDPOINTS
    // ==========================================

    /**
     * Tampilan halaman Live Chat di Admin Panel
     */
    public function adminIndex(Request $request)
    {
        $selectedUserId = $request->input('user_id');
        return view('admin.chat.index', compact('selectedUserId'));
    }

    /**
     * Mengambil daftar percakapan semua customer untuk panel admin
     */
    public function adminGetConversations()
    {
        try {
            // Ambil ID semua customer yang pernah mengirim atau menerima pesan
            $customerIds = ChatMessage::select('user_id')
                ->distinct()
                ->pluck('user_id');

            $users = User::whereIn('id', $customerIds)
                ->withCount(['chatMessages as unread_count' => function ($q) {
                    $q->where('sender_type', 'customer')->where('is_read_by_admin', false);
                }])
                ->get();

            $conversations = [];
            foreach ($users as $user) {
                $lastMsg = ChatMessage::where('user_id', $user->id)->latest()->first();
                $conversations[] = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '-',
                    'last_message' => $lastMsg ? $lastMsg->message : '',
                    'last_time' => $lastMsg ? $lastMsg->created_at->diffForHumans() : '',
                    'last_created_at' => $lastMsg ? $lastMsg->created_at->timestamp : 0,
                    'unread_count' => $user->unread_count,
                ];
            }

            // Urutkan dari percakapan paling terbaru
            usort($conversations, function ($a, $b) {
                return $b['last_created_at'] <=> $a['last_created_at'];
            });

            $totalUnread = ChatMessage::where('sender_type', 'customer')
                ->where('is_read_by_admin', false)
                ->count();

            return response()->json([
                'success' => true,
                'conversations' => $conversations,
                'total_unread' => $totalUnread,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'conversations' => [],
                'total_unread' => 0,
                'error' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Admin mengambil percakapan dengan customer tertentu
     */
    public function adminGetMessages(int $userId)
    {
        $customer = User::withCount('orders')->findOrFail($userId);

        // Tandai pesan dari customer sebagai terbaca oleh admin
        ChatMessage::where('user_id', $userId)
            ->where('sender_type', 'customer')
            ->where('is_read_by_admin', false)
            ->update(['is_read_by_admin' => true]);

        $messages = ChatMessage::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_type' => $msg->sender_type,
                    'message' => e($msg->message),
                    'time' => $msg->created_at->format('H:i'),
                    'date' => $msg->created_at->format('d M Y'),
                ];
            });

        return response()->json([
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone ?? 'Belum ada nomor HP',
                'orders_count' => $customer->orders_count,
                'total_spent' => 'Rp ' . number_format($customer->total_spent, 0, ',', '.'),
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Admin mengirim balasan pesan ke customer
     */
    public function adminSendMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:2000',
        ]);

        $userId = (int) $request->input('user_id');

        $chat = ChatMessage::create([
            'user_id' => $userId,
            'sender_type' => 'admin',
            'sender_id' => Auth::guard('admin')->id(),
            'message' => trim($request->input('message')),
            'is_read_by_customer' => false,
            'is_read_by_admin' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $chat->id,
                'sender_type' => 'admin',
                'message' => e($chat->message),
                'time' => $chat->created_at->format('H:i'),
                'date' => $chat->created_at->format('d M Y'),
            ],
        ]);
    }
}

