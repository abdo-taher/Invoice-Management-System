<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // استخدم نموذج User بدلاً من Admin
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // تحديد الحقل المستخدم لتسجيل الدخول (البريد الإلكتروني أو اسم المستخدم)
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // محاولة العثور على المستخدم باستخدام البريد الإلكتروني أو اسم المستخدم في جدول users
        $user = User::where($loginType, $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // تعيين الدور والصلاحية بعد التحقق من بيانات تسجيل الدخول
//            if (!$user->hasRole('admin')) {
//                $user->assignRole('admin'); // تعيين دور admin
//            }
//
//            if (!$user->hasPermissionTo('manage users')) {
//                $user->givePermissionTo('manage users'); // تعيين صلاحية manage users
//            }

            // تسجيل الدخول الناجح
            Auth::login($user); // تسجيل دخول المستخدم
            return redirect()->route('dashboard');
        } else {
            // إذا كانت بيانات تسجيل الدخول غير صحيحة
            return redirect()->back()->withErrors(['login_error' => 'بيانات تسجيل الدخول غير صحيحة.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
