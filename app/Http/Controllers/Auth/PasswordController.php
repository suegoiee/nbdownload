<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{    
    public function update(Request $request)
    {
        if (! Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.']
            ]);
        }

        Validator::make($request->all(), [
            'password' => 'required|string|confirmed'
        ])->validate();

        $user = User::find(Auth::user()->id);

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return redirect()->back();
    }
}
