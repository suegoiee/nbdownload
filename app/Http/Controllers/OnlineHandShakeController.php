<?php

namespace App\Http\Controllers;

use DB;
use App\Models\cms\CmsLog;
use App\Models\cms\CmsDownloadTmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OnlineHandShakeController extends Controller
{    
    public function confirmDownload(Request $request)
    {
        dd($request->all());
        $postdata = http_build_query(
            array(
                'API_KEY' => env('API_KEY'),
                'tmp_marketing_name' => $request->tmp_marketing_name,
                'tmp_prd_model_name' => $request->tmp_prd_model_name,
                'tmp_title' => $request->tmp_title,
                'tmp_file_name' => $request->tmp_file_name,
                'tmp_device' => $request->tmp_device,
                'tmp_version' => $request->tmp_version,
                'tmp_guid' => $request->tmp_guid,
                'tmp_upgradeguid' => $request->tmp_upgradeguid,
                'tmp_deviceid' => $request->tmp_deviceid,
                'tmp_silentInstantparameter' => $request->tmp_silentInstantparameter,
                'tmp_crc' => $request->tmp_crc,
                'tmp_releasedate' => $request->tmp_releasedate,
                'tmp_os' => $request->tmp_os,
                'tmp_type' => $request->tmp_type,
                'tmp_category' => $request->tmp_category,
                'tmp_other' => $request->tmp_other,
                'tmp_packageVersion' => $request->tmp_packageVersion,
                'tmp_reboot' => $request->tmp_reboot,
                'tmp_source' => $request->tmp_source,
                'tmp_osImage' => $request->tmp_osImage,
                'tmp_status' => $request->tmp_status,
                'tmp_prd_list_no' => $request->tmp_prd_list_no,
                'tmp_file_category' => $request->tmp_file_category,
                'tmp_description' => $request->tmp_description,
            )
        );
        
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        
        $context  = stream_context_create($opts);
        $result = file_get_contents('https://mtc.msi.com/api/v1/nb/add_download', false, $context);
        dd($context);
        return redirect()->back();
    }
}
