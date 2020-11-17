<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiController extends Controller
{    
    public function productList(Request $request)
    {
        $list = array(
            'search'=>$request->keyword, 
            'amount' => 50000, 
            'orderby' => 'product_id', 
            'order' => 'desc',
            'page' => 1,
            'API_KEY' => env('API_KEY')
        );

        $result = retrieve_by_curl($list, 'POST', 'https://internal-cms.msi.com.tw/api/v1/nb/get_productlist');
        return $result['data'];
    }
    
    public function downloadOnlineList(Request $request)
    {
        $list = array(
            'API_KEY' => env('API_KEY'),
            'search'=>$request->keyword, 
            'amount' => 50000, 
            'orderby' => 'download_id', 
            'order' => 'desc',
            'page' => 1,
        );
        $result = retrieve_by_curl($list, 'POST', 'https://internal-cms.msi.com.tw/api/v1/nb/get_downloadlist');
        return $result['data'];
    }
    
}
