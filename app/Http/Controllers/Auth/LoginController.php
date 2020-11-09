<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home.index');
        }
    }
    
    // public function show_signup_form()
    // {
    //     return view('backend.register');
    // }

    // public function process_signup(Request $request)
    // {   
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);
 
    //     $user = User::create([
    //         'name' => trim($request->input('name')),
    //         'email' => strtolower($request->input('email')),
    //         'password' => bcrypt($request->input('password')),
    //     ]);
       
    //     return redirect()->back();
    // }
}