<?php

namespace App\Http\Controllers;

use App\Models\cms\CmsLog;
use App\Models\cms\CmsDownloadTmp;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $columns = [
            'tmp_marketing_name',
            'tmp_prd_model_name',
            'tmp_title',
            'tmp_device',
            'tmp_version',
            'tmp_crc',
            'tmp_os',
            'tmp_packageVersion',
            'tmp_osImage',
        ];

        if(isset($request->search)){
            $data = CmsDownloadTmp::where('tmp_marketing_name', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_marketing_name', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_prd_model_name', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_title', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_device', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_version', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_crc', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_os', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_packageVersion', 'LIKE', "%$request->search%")
                        ->orWhere('tmp_osImage', 'LIKE', "%$request->search%")
                        ->paginate(50);
        }
        else{
            $data = CmsDownloadTmp::paginate(30);
        }
        return view('download_list', compact('data'));
    }
}
