<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Jobs\CreateLog;
use App\Models\cms\CmsLog;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class LogController extends Controller
{    
    public function index(Request $request, $date, $keyword, $amount, $orderby, $order)
    {
        //dd($request->all());
        if(isset($request->log_date)){
            $date = date('Ym', strtotime($request->log_date));
            $keyword = Route::current()->parameter('keyword');
            $amount = Route::current()->parameter('amount');
            $orderby = Route::current()->parameter('orderby');
            $order = Route::current()->parameter('order');
            return redirect()->route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order]);
        }
        if(isset($request->search)){
            $date = Route::current()->parameter('date');
            $amount = Route::current()->parameter('amount');
            $orderby = Route::current()->parameter('orderby');
            $order = Route::current()->parameter('order');
            return redirect()->route('log.show', ['date'=>$date, 'keyword'=>$request->search, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order]);
        }
        $table = 'cms_log_' . $date;
        if(Schema::hasTable($table)){
            $log = new CmsLog;
            $log->setTable($table);
            $log = $log->where('log_table', 'NB_download');
            if($keyword != 'all-data'){
                $log = $log->where(function($query) use ($keyword){
                        $query->where('log_action', 'LIKE', "%$keyword%")
                            ->orWhere('log_ip', 'LIKE', "%$keyword%")
                            ->orWhere('log_user_id', 'LIKE', "%$keyword%")
                            ->orWhere('log_create', 'LIKE', "%$keyword%");
                        });
            }
            $data = $log->with('user')->orderby($orderby, $order)->paginate($amount);
        }
        else{
            $array = [];
            $data = new Paginator($array, $amount);
        }
        return view('log_list', compact('data', 'date', 'keyword', 'amount', 'orderby', 'order'));
    }

    public function export(Request $request, $date, $keyword, $amount, $orderby, $order)
    {
        $table = 'cms_log_' . $date;
        Schema::hasTable($table) ? '' : $table -= 1;
        $log = new CmsLog;
        $log->setTable($table);
        $log = $log->where('log_table', 'NB_download');
        if($keyword != 'all-data'){
            $log = $log->where(function($query) use ($keyword){
                    $query->where('log_action', 'LIKE', "%$keyword%")
                        ->orWhere('log_ip', 'LIKE', "%$keyword%")
                        ->orWhere('log_user_id', 'LIKE', "%$keyword%")
                        ->orWhere('log_create', 'LIKE', "%$keyword%");
                    });
        }
        $data = $log->orderby($orderby, $order)->paginate($amount);
        $export['title'] = 'Log-'.date('Y-m-d_H:i:s');
        $export['head'] = ['Action', 'IP', 'User', 'Create Date'];
        $export['content'] = array();
        foreach($data as $td){
            array_push($export['content'], ['0'=>$td->log_action, '1'=>$td->log_ip, '2'=>$td->user->name.' ( '.$td->log_user_id.' )', '3'=>$td->log_create] );
        }

        $log= new \stdClass();
        $log->log_action = 'export log';
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));
        exportCSVAction($export);
    }
}
