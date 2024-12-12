<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->account != 'ENQUETEUR'){
                return response()->json(['message' => 'Connexion réussie', 'status' => 'success']);
            }else{
                Auth::logout();
                return response()->json(['message' => 'Espace interdit aux enquêteurs', 'status' => 'error'], 401);
            }
        } else {
            return response()->json(['message' => 'Identifiants invalides', 'status' => 'error'], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
