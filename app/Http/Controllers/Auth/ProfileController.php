<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Jobs\CreateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{    
    public function show(Request $request)
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->save();

        $log= new \stdClass();
        $log->log_action = Auth::user()->id. ' has change name to '.$request->name;
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));
        
        return redirect()->route('profile.show');
    }
}
