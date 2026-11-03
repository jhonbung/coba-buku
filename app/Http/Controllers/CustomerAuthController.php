<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->intended(route('home'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Silakan masukkan alamat email Anda.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Silakan masukkan kata sandi Anda.',
        ]);

        $emailInput = strtolower(trim($request->input('email')));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Jika akun ini adalah administrator, tolak login di portal pembaca agar tidak bentrok
        $adminCheck = User::where('email', $emailInput)->first();
        if ($adminCheck && $adminCheck->is_admin) {
            return back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => 'Akun ini terdaftar sebagai Administrator Toko. Silakan masuk melalui Portal Admin di /admin/login.',
            ]);
        }

        $credentials = [
            'email' => $emailInput,
            'password' => $password,
        ];

        // Autentikasi khusus ke guard 'web' (customer) tanpa mengganggu sesi guard 'admin'
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $user = Auth::guard('web')->user();

            // Sinkronisasi session cart ke database keranjang user
            $this->syncSessionCartToDatabase($user->id);

            return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'Alamat email atau kata sandi yang Anda masukkan tidak sesuai.',
        ]);
    }

    public function showRegisterForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:25',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email sudah terdaftar. Silakan login.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi untuk konfirmasi pengiriman.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => strtolower(trim($request->input('email'))),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => false,
        ]);

        Auth::guard('web')->login($user);

        // Sinkronisasi session cart jika ada
        $this->syncSessionCartToDatabase($user->id);

        return redirect()->intended(route('home'))->with('success', 'Akun berhasil dibuat! Selamat datang di Bianca Veana Universe, ' . $user->name . '.');
    }

    public function logout(Request $request)
    {
        // Hanya logout sesi customer tanpa mematikan sesi admin backend jika sedang aktif di tab lain
        Auth::guard('web')->logout();
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar dari akun pembaca.');
    }

    public function profile()
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $recentOrders = Order::where('customer_email', $user->email)
            ->orWhere('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('auth.profile', compact('user', 'recentOrders'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        return back()->with('success', 'Informasi profil akun Anda berhasil diperbarui!');
    }

    public function orders()
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Otomatis batalkan pesanan pending yang sudah lewat batas waktu (real-time auto-cancel)
        Order::cancelAllExpired();

        $orders = Order::with('items.product')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->latest()
            ->paginate(10);

        return view('auth.orders', compact('user', 'orders'));
    }

    /**
     * Batalkan pesanan oleh customer (khusus pesanan belum bayar / pending)
     */
    public function cancelOrder(Request $request, string $order_number)
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $order = Order::with('items.product')
            ->where('order_number', $order_number)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_email', $user->email);
            })
            ->firstOrFail();

        // Hanya pesanan yang belum dibayar / masih pending yang bisa dibatalkan oleh customer
        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Pesanan yang sudah lunas tidak dapat dibatalkan secara otomatis. Silakan hubungi admin / customer care kami.');
        }

        if ($order->order_status === 'cancelled' || in_array($order->payment_status, ['cancelled', 'expired'])) {
            return back()->with('info', 'Pesanan ini sudah dibatalkan atau kedaluwarsa.');
        }

        if (in_array($order->order_status, ['shipped', 'completed'])) {
            return back()->with('error', 'Pesanan yang sudah dikirim atau selesai tidak dapat dibatalkan.');
        }

        $order->cancelOrder('customer');

        return back()->with('success', "Pesanan #{$order->order_number} berhasil dibatalkan.");
    }

    /**
     * Sinkronisasi session cart ke database saat login/register
     */
    private function syncSessionCartToDatabase(int $userId): void
    {
        $sessionCart = session()->get('cart', []);
        if (!empty($sessionCart)) {
            foreach ($sessionCart as $productId => $item) {
                $cartItem = CartItem::firstOrNew([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
                $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + ($item['quantity'] ?? 1);
                $cartItem->save();
            }
            session()->forget('cart');
        }
    }
}

