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
        $export['title'] = 'Local-Download-List'.date('Y-m-d_H:i:s');
        $export['head'] = ['Title', 'Marketing name', 'Model Name', 'Device', 'Version', 'Package Version', 'OS', 'OS Image', 'CRC'];
        $export['content'] = array();
        foreach($data as $td){
            array_push($export['content'], ['0'=>$td->tmp_title, '1'=>$td->tmp_marketing_name, '2'=>$td->tmp_prd_model_name, '3'=>$td->tmp_device, '4'=>$td->tmp_version, '5'=>$td->tmp_packageVersion, '6'=>$td->tmp_os, '7'=>$td->tmp_osImage, '8'=>$td->tmp_crc] );
        }
        // dd($export);
        exportCSVAction($export);
    }
    
    function exportCSVAction($request)
    {
        $fileName = $request['title'];  //這裡定義表名。簡單點的就直接  $fileName = time();

        header('Content-Type: application/vnd.ms-excel');   //header設定
        header("Content-Disposition: attachment;filename=".$fileName.".csv");
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output','a');    //開啟php檔案控制代碼，php://output表示直接輸出到PHP快取,a表示將輸出的內容追加到檔案末尾

        $head = array('工號','部門名','崗位名','學員名','報名時間','狀態','課程建議');  //表頭資訊
        foreach($request['head'] as $th){
            array_push($head, iconv("UTF-8","GBK//IGNORE",$th));
        }
        fputcsv($fp,$head);  //fputcsv() 函式將行格式$head化為 CSV 並寫入一個開啟的檔案$fp。 

        if (!empty($request['content'])) {  
            $data = [];  //要匯出的資料的順序與表頭一致；提前將最後的值準備好（比如：時間戳轉為日期等）
            foreach ($request['content'] as $tbodyKey => $tbody) {
                foreach($tbody as $tdkey => $td){  //$item為一維陣列哦
                    $data[$tdkey] = iconv("UTF-8","GBK//IGNORE",$td);  //轉為gbk的時候可能會遇到特殊字元‘-’之類的會報錯，加 ignore表示這個特殊字元直接忽略不做轉換。
                }
                fputcsv($fp,$data);
            }
            exit;  //記得加這個，不然會跳轉到某個頁面。
        }
    }
}
