<?php

namespace App\Http\Controllers;

use DB;
use App\Models\cms\CmsLog;
use App\Models\cms\CmsDownloadTmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DownloadListLocalController extends Controller
{    
    public function index(Request $request, $status, $keyword, $amount, $orderby, $order)
    {
        $data_status = ['NCND' => 2, 'confirmed' => 1, 'denied' => 0];

        if(isset($request->search)){
            $status = Route::current()->parameter('status');
            $amount = Route::current()->parameter('amount');
            $orderby = Route::current()->parameter('orderby');
            $order = Route::current()->parameter('order');
            return redirect()->route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$request->search, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order]);
        }

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
        // dd($data = $data->orderby($orderby, $order)->first());
        $data = $data->orderby($orderby, $order)->paginate($amount);
        return view('local_download_list', compact('data', 'status', 'keyword', 'amount', 'orderby', 'order'));
    }

    public function export(Request $request, $status, $keyword, $amount, $orderby, $order)
    {
        $data_status = ['NCND' => 2, 'confirmed' => 1, 'denied' => 0];

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
        exportCSVAction($export);
    }

    public function downloadActionByBatch(Request $request)
    {
        $request->action == 'deny' ? $status = 0: $status = 2;
        foreach($request->id as $id){
            $download = CmsDownloadTmp::where('tmp_no', $id)->first();
            $download->tmp_status = $status;
            $download->save();
        }
        return print_r($request->all());
    }
}
