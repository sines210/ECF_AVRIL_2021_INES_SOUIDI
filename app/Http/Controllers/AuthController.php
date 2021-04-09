<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class AuthController {
    

    public function validateLogin(Request $request){
        $validated = $request->validate([
            "username" => "required",
            "password" => "required",
          ]);
          if (Auth::attempt($validated)) {
            return redirect()->intended('/');
          }
          return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
          ]);
    }

    public function validateSignup(Request $request){
        $validated = $request->validate([
            "username" => "required",
            "password" => "required",
            "password_confirmation" => "required|same:password"
          ]);
          $user = new User();
          $user->username = $validated["username"];
          $user->password = Hash::make($validated["password"]);
          $user->save();
          Auth::login($user);
        
          return redirect('/');
    }

    public function signOut(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}