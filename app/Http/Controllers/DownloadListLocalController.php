<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Jobs\CreateLog;
use App\Models\cms\CmsLog;
use App\Models\cms\CmsDownloadTmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DownloadListLocalController extends Controller
{    
    public function index(Request $request, $status, $keyword, $amount, $orderby, $order)
    {
        $data_status = ['Reject' => 2, 'Approve' => 1, 'Draft' => 0];

        if(isset($request->search)){
            $status = Route::current()->parameter('status');
            $amount = Route::current()->parameter('amount');
            $orderby = Route::current()->parameter('orderby');
            $order = Route::current()->parameter('order');
            return redirect()->route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$request->search, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order]);
        }
        $file_path_list = config('global.download_file_path_list');
        $data = new CmsDownloadTmp;
        if(isset($data_status[$status])){
            $data = $data->where('tmp_status', $data_status[$status]);
        }
        if($keyword != 'all-data'){
            $data = $data->where(function($query) use ($keyword){
                    $query->where('tmp_marketing_name', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_prd_model_name', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_title', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_device', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_version', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_crc', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_os', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_packageVersion', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_osImage', 'LIKE', "%$keyword%");
                    });
        }
        $data = $data->orderby($orderby, $order)->paginate($amount);
        // dd($data);
        return view('local_download_list', compact('data', 'status', 'keyword', 'amount', 'orderby', 'order', 'file_path_list'));
    }

    public function export(Request $request, $status, $keyword, $amount, $orderby, $order)
    {
        $data_status = ['Reject' => 2, 'Approve' => 1, 'Draft' => 0];

        $data = new CmsDownloadTmp;
        if(isset($data_status[$status])){
            $data = $data->where('tmp_status', $data_status[$status]);
        }
        if($keyword != 'all-data'){
            $data = $data->where(function($query) use ($keyword){
                    $query->where('tmp_marketing_name', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_prd_model_name', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_title', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_device', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_version', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_crc', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_os', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_packageVersion', 'LIKE', "%$keyword%")
                        ->orWhere('tmp_osImage', 'LIKE', "%$keyword%");
                    });
        }
        $data = $data->orderby($orderby, $order)->paginate($amount);
        $export['title'] = 'Local-Download-List-'.date('Y-m-d_H:i:s');
        $export['head'] = ['Title', 'Marketing name', 'Model Name', 'Device', 'Version', 'Package Version', 'OS', 'OS Image', 'CRC'];
        $export['content'] = array();
        foreach($data as $td){
            array_push($export['content'], ['0'=>$td->tmp_title, '1'=>$td->tmp_marketing_name, '2'=>$td->tmp_prd_model_name, '3'=>$td->tmp_device, '4'=>$td->tmp_version, '5'=>$td->tmp_packageVersion, '6'=>$td->tmp_os, '7'=>$td->tmp_osImage, '8'=>$td->tmp_crc] );
        }

        $log= new \stdClass();
        $log->log_table = 'NB_download';
        $log->log_action = 'export local download data';
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));
        exportCSVAction($export);
    }

    public function downloadActionByBatch(Request $request)
    {
        $request->action == 'Reject' ? $status = 2: $status = 0;
        foreach($request->id as $id){
            $download = CmsDownloadTmp::where('tmp_no', $id)->first();
            $download->tmp_status = $status;
            $download->save();
            
            $log= new \stdClass();
            $log->log_table = 'NB_download';
            $log->log_action = $request->action.' '.$download->tmp_no.'. By batch';
            $log->log_ip = $request->ip();
            $this->dispatchNow(CreateLog::fromRequest($log));
        }
        return print_r($status);
    }
}
