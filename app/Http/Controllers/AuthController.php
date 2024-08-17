<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        //check user already login
        if (Auth()->check()) {
            return redirect()->route('product.dashboard');

            $rolesToRoute = [
                'superadmin' => 'product.dashboard',
                'sales' => 'product.dashboard',
            ];
            $mainRole = Auth()->user()->getRoleNames()->first();
            return redirect()->route($rolesToRoute[$mainRole]);
        }
        return view("auth.login");
    }

    public function Login(Request $request)
    {
        //login using email and password
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $mainRole = auth()->user()->getRoleNames()[0];
            $rolesToRoute = [
                'superadmin' => 'product.dashboard',
                'sales' => 'product.dashboard',
            ];
            return redirect()->route($rolesToRoute[$mainRole]);
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function Logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function ResetPassword()
    {
        return view('auth.passwords.email');
    }

    public function SendEmailResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided email is not registered.',
            ]);
        }

        $token = Str::random(60);
        PasswordReset::updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => bcrypt($token),
                'created_at' => now()
            ]
        );
        $resetUrl = url('/password/reset', $token) . '?email=' . $user->email;
        Mail::to($user->email)->send(new ResetPasswordMail($resetUrl));
        return back()->with('success', 'Reset password link has been sent to your email');
    }

    public function VerifyResetPassword($token)
    {
        $email = request('email');
        $passwordReset = PasswordReset::where('email', $email)->first();
        if (!$passwordReset) {
            return redirect()->route('password.reset')->withErrors([
                'email' => 'The provided email or token is invalid.',
            ]);
        }
        if (!Hash::check($token, $passwordReset->token)) {
            return redirect()->route('password.reset')->withErrors([
                'email' => 'The provided email or token is invalid.',
            ]);
        }
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function ResetPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        if ($request->password != $request->password_confirmation) {
            return back()->withErrors([
                'password' => 'Password and confirm password must be same',
            ]);
        }

        $passwordReset = PasswordReset::where('email', $request->email)->first();
        if (!$passwordReset) {
            return back()->withErrors([
                'email' => 'The provided email or token is invalid.',
            ]);
        }
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors([
                'email' => 'The provided email or token is invalid.',
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        PasswordReset::where('email', $request->email)->delete();
        return redirect()->route('login')->with('success', 'Password has been changed');
    }
}
