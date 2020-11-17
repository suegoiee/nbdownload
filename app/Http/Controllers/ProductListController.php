<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;

class ProductListController extends Controller
{    
    public function __construct()
    {
        $this->moduleName='product_list';
    }

    public function show(Request $request, $keyword, $amount, $orderby, $order, $page)
    {
        if(isset($request->search)){
            $amount = Route::current()->parameter('amount');
            $orderby = Route::current()->parameter('orderby');
            $order = Route::current()->parameter('order');
            return redirect()->route('productList.show', ['keyword'=>$request->search, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order, 'page' => '1']);
        }

        $list = array(
            'API_KEY' => env('API_KEY'),
            'search'=>$keyword, 
            'amount' => $amount, 
            'orderby' => $orderby, 
            'order' => $order,
            'page' => $page,
        );

        $result = retrieve_by_curl($list, 'POST', 'https://internal-cms.msi.com.tw/api/v1/nb/get_productlist');
        // dd($result);
        $tmp = (object) $result['data'];
        $data= new \stdClass();
        foreach ($tmp as $key => $value)
        {
            $data->$key = (object)$value;
        }
        //$data = new Paginator($data, $amount);
        $data = [
            'module_name'=> $this->moduleName,
            'data'=>$data,
            'result'=>$result,
            'keyword'=>$keyword, 
            'amount'=>$amount, 
            'orderby'=>$orderby, 
            'order'=>$order,
            'page'=>$page
        ];
        return view('product_list', $data);
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

        $result = retrieve_by_curl($list, 'POST', 'https://internal-cms.msi.com.tw/api/v1/nb/get_productlist');
        $export['title'] = 'Product-List-'.date('Y-m-d_H:i:s');
        $export['head'] = ['Title', 'Model Name', 'Status'];
        $export['content'] = array();
        foreach($result['data'] as $td){
            if($td['product_showed'] != 2){
                $td['product_showed'] == 1 ? $td['product_showed'] = 'Showed' : $td['product_showed'] = 'hide';
                array_push($export['content'], ['0'=>$td['product_title'], '1'=>$td['product_model_name'], '2'=>$td['product_showed']] );
            }
        }
        exportCSVAction($export);
    }
    
}
