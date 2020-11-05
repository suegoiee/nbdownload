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

    public function export($keyword, $amount, $orderby, $order, $page)
    {
        $list = array(
            'search'=>$keyword, 
            'amount' => $amount, 
            'orderby' => $orderby, 
            'order' => $order,
            'page' => $page,
            'API_KEY' => env('API_KEY')
        );

        $result = retrieve_data($list, 'POST', 'https://mtc.msi.com/api/v1/nb/get_downloadlist');
        $export['title'] = 'Online-Download-List-'.date('Y-m-d_H:i:s');
        $export['head'] = ['Title', 'Device', 'File', 'Size', 'Version', 'Package Version', 'CRC'];
        $export['content'] = array();
        // dd($result);
        foreach($result['data'] as $td){
            array_push($export['content'], ['0'=>$td['download_title'], '1'=>$td['download_deviceid'], '2'=>$td['download_file'], '3'=>$td['download_size'], '4'=>$td['download_version'], '5'=>$td['download_packageversion'], '6'=>$td['download_crc']] );
        }
        //dd($export);
        exportCSVAction($export);
    }
    
}
