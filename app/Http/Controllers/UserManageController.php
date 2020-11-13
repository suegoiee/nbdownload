<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use App\Jobs\CreateLog;
use App\Models\cms\CmsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserManageController extends Controller
{    
    public function show(Request $request, $keyword, $amount, $orderby, $order)
    {
        if(isset($request->search)){
            $amount = Route::current()->parameter('amount');
            $orderby = Route::current()->parameter('orderby');
            $order = Route::current()->parameter('order');
            return redirect()->route('userManage.show', ['keyword'=>$request->search, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order]);
        }
        $data = new User;
        if($keyword != 'all-data'){
            $data = $data->where(function($query) use ($keyword){
                    $query->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%");
                    });
        }
        $data = $data->orderby($orderby, $order)->paginate($amount);
        return view('user_list', compact('data', 'keyword', 'amount', 'orderby', 'order'));
    }
    
    public function changePermission(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->permission = $request->permission;
        $user->save();

        $log= new \stdClass();
        $log->log_action = 'change '.$user->name.' permission to '.config('global.permission_list')[$request->permission];
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));

        return redirect()->back();
    }

    public function export(Request $request, $keyword, $amount, $orderby, $order)
    {
        $data = new User;
        if($keyword != 'all-data'){
            $data = $data->where(function($query) use ($keyword){
                    $query->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%");
                    });
        }
        $data = $data->orderby($orderby, $order)->paginate($amount);
        $export['title'] = 'User-List-'.date('Y-m-d_H:i:s');
        $export['head'] = ['Id', 'Name', 'email', 'Permission'];
        $export['content'] = array();
        foreach($data as $td){
            array_push($export['content'], ['0'=>$td->id, '1'=>$td->name, '2'=>$td->email, '3'=>config('global.permission_list')[$td->permission]] );
        }

        $log= new \stdClass();
        $log->log_action = 'export user table';
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));
        exportCSVAction($export);
    }
}
