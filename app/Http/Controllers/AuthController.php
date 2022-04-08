<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // register page view
    public function register() {
        return view('auth.register', ['title' => 'Register Page']);
    }

    // login page view
    public function login() {
        if (session()->get('user')) {
            return redirect()->route('product.index');
        } else {
            return view('auth.login', ['title' => 'Login Page']);
        }
    }

    // Register post
    public function customRegister(Request $request) {

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $users = User::query();
        $users->create($request->all()); 
        return redirect()->route('auth.login');
    }

    // Login post
    public function customLogin(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $users = User::query();
        $user = $users->where(['email' => $request->email, 'password' => $request->password])->get();
        if ($user->isEmpty()) {
         
           return redirect()->back()->with('error', 'Email or Password requried');
        } else {
            $request->session()->put('user', $user);
            return redirect()->route('product.index');
        }
    }

    // Logout method
    public function logout() {
        session()->forget('user');
        return redirect()->route('auth.login');
    }
}
