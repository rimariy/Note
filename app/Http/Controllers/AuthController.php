<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // عرض نموذج تسجيل الدخول
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // تم تسجيل الدخول بنجاح
            return redirect('/notes');
        }

        // في حالة فشل تسجيل الدخول
        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    // معالجة تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('/login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // قواعد التحقق من البيانات الواردة هنا

        // إنشاء مستخدم جديد
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // تسجيل الدخول للمستخدم الجديد (اختياري)
        Auth::login($user);

        // توجيه المستخدم إلى الصفحة المناسبة بعد التسجيل
        return redirect('/notes');
    }

}
