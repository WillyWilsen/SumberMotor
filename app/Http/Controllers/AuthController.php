<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        //check user already login
        if (Auth()->check()) {
            return redirect()->route('product.dashboard');

            $rolesToRoute = [
                'superadmin' => 'product.dashboard',
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
}
