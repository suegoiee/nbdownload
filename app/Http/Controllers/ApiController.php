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

        $result = retrieve_data($list, 'POST', 'https://mtc.msi.com/api/v1/nb/get_productlist');
        return $result['data'];
    }
    
}
