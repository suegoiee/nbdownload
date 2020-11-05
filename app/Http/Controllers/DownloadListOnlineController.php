<?php

namespace App\Http\Controllers;

use App\Models\cms\CmsDownloadTmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DownloadListOnlineController extends Controller
{    
    public function show(Request $request, $keyword, $amount, $orderby, $order, $page)
    {
        if(isset($request->search)){
            $amount = Route::current()->parameter('amount');
            $orderby = Route::current()->parameter('orderby');
            $order = Route::current()->parameter('order');
            return redirect()->route('downloadListOnline.show', ['keyword'=>$request->search, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order, 'page' => '1']);
        }
        $list = array(
            'search'=>$keyword, 
            'amount' => $amount, 
            'orderby' => $orderby, 
            'order' => $order,
            'page' => $page,
            'API_KEY' => env('API_KEY')
        );
        $result = retrieve_data($list, 'POST', 'https://mtc.msi.com/api/v1/nb/get_downloadlist');
        //dd($result);
        $tmp = (object) $result['data'];
        $data= new \stdClass();
        foreach ($tmp as $key => $value)
        {
            $data->$key = (object)$value;
        }
        // dd($data);
        return view('online_download_list', compact('data', 'result', 'keyword', 'amount', 'orderby', 'order', 'page'));
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
