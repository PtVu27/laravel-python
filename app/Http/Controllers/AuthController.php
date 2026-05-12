<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'redirect' => auth()->user()->role === 'admin' ? route('admin.dashboard') : route('home')
                ]);
            }

            return redirect()->intended(auth()->user()->role === 'admin' ? route('admin.dashboard') : route('home'))->with('success', 'Đăng nhập thành công!');
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không đúng!'
            ], 422);
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!']);
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|confirmed',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'required|date',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'customer',
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
            ]);

            Auth::login($user);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng ký thành công!',
                    'redirect' => route('home')
                ]);
            }

            return redirect()->route('home')->with('success', 'Đăng ký thành công!');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
