<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ExportController extends Controller
{    
    public function exportCsv(Request $request)
    {
        dd($request->all());
        $list = array(
            'search'=>$keyword, 
            'amount' => 50000, 
            'orderby' => 'product_id', 
            'order' => 'desc',
            'page' => 1,
            'API_KEY' => env('API_KEY')
        );

        $result = retrieve_data($list, 'POST', 'https://mtc.msi.com/api/v1/nb/get_productlist');
        // $data= new \stdClass();
        // foreach ($result['data'] as $key => $value)
        // {
        //     $data->$key = (object)$value;
        // }
        return $result['data'];
    }
    
}
