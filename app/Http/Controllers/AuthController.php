<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Check if login input is email or username
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $password,
            'is_admin' => true,
        ];

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.index'))->with('success', 'Selamat datang kembali, Administrator Bianca Veana!');
        }

        return back()->withInput($request->only('login', 'remember'))->withErrors([
            'login' => 'Kredensial login tidak cocok atau Anda tidak memiliki hak akses administrator.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar dari sistem administrator.');
    }
}
