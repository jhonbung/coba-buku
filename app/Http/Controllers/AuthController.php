<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Silakan masukkan username atau email administrator.',
            'password.required' => 'Silakan masukkan kata sandi administrator.',
        ]);

        $loginInput = trim($request->input('login'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Check if login input is email or username
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Deteksi apakah akun ini sebenarnya akun customer biasa
        $userCheck = \App\Models\User::where($fieldType, $loginInput)->first();
        if ($userCheck && !$userCheck->is_admin) {
            return back()->withInput($request->only('login', 'remember'))->withErrors([
                'login' => 'Akun "' . $loginInput . '" terdaftar sebagai Akun Customer/Pembaca, BUKAN Administrator. Silakan masuk melalui Halaman Login Pembaca di /login.',
            ]);
        }

        $credentials = [
            $fieldType => $loginInput,
            'password' => $password,
            'is_admin' => true,
        ];

        // Login murni ke guard 'admin' yang terisolasi dari guard customer 'web'
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.index'))->with('success', 'Selamat datang kembali di Control Center, Administrator Bianca Veana!');
        }

        return back()->withInput($request->only('login', 'remember'))->withErrors([
            'login' => 'Kredensial login administrator tidak cocok.',
        ]);
    }

    public function logout(Request $request)
    {
        // Hanya logout sesi backend admin tanpa menghapus sesi belanja customer jika ada
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar dari sistem administrator.');
    }
}
