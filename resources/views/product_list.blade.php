@section('home-menu', 'menu-open')
@section('home-href', 'active')
@section('products', 'active')
@section('title', 'Products')

@extends('layouts.base')

@section('content')
<style>
    .ASC {
        border: solid red;
        border-width: 0 4px 4px 0;
        display: inline-block;
        padding: 3px;
        margin-left: 5px;
        transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
    }
    .DESC {
        border: solid red;
        border-width: 0 4px 4px 0;
        display: inline-block;
        padding: 3px;
        margin-left: 5px;
        transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
    }
    .table-title{
      position: relative; 
      float: left;
      padding-left: 10px;
    }
    .table-search{
      position: relative; 
      float: right;
    }
    .table-control-button{
      position: relative; 
      float: left;
      margin-left: 30px;
    }
</style>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product List</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products</h3>
                <form class="form-inline ml-3 table-search">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <form class="form-inline ml-3 table-title" style="position: absolute; left: 15%; top: 7px;">
                    <div class="input-group input-group-sm">
                        <p>show &nbsp</p>
                        <select class="form-control" name="country" onchange="location = this.value;">
                            <option value="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>'5', 'orderby'=>$orderby, 'order'=>$order, 'page'=>'1'])}}" {{$amount == 5 ? 'selected' : ''}}>5</option>
                            <option value="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>'15', 'orderby'=>$orderby, 'order'=>$order, 'page'=>'1'])}}" {{$amount == 15 ? 'selected' : ''}}>15</option>
                            <option value="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>'50', 'orderby'=>$orderby, 'order'=>$order, 'page'=>'1'])}}" {{$amount == 50 ? 'selected' : ''}}>50</option>
                            <option value="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>'100', 'orderby'=>$orderby, 'order'=>$order, 'page'=>'1'])}}" {{$amount == 100 ? 'selected' : ''}}>100</option>
                        </select>
                        <p>&nbsp data per page</p>
                        <a href="{{route('productList.export', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order, 'page' => $page])}}"><button type="button" class="btn btn-danger table-control-button">Export CSV</button></a>
                    </div>
                </form>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><a href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'product_title', 'order'=>$order == 'ASC' && $orderby == 'product_title' ? 'DESC' : 'ASC', 'page'=>$page])}}">Title<i class="{{$orderby == 'product_title' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'product_model_name', 'order'=>$order == 'ASC' && $orderby == 'product_model_name' ? 'DESC' : 'ASC', 'page'=>$page])}}">Model Name<i class="{{$orderby == 'product_model_name' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'product_showed', 'order'=>$order == 'ASC' && $orderby == 'product_showed' ? 'DESC' : 'ASC', 'page'=>$page])}}">Status<i class="{{$orderby == 'product_showed' ? $order : ''}}"></i></a></th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($data as $list)
                          <tr>
                              <td>{{$list->product_title}}</td>
                              <td>{{$list->product_model_name}}</td>
                              <td>{{$list->product_showed}}</td>
                          </tr>
                          <div class="modal fade" id="modal-{{$list->product_id}}">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <form style="display:none" action="/confirmDownload" method="POST" id="confirmDownload-{{$list->product_id}}">
                                          @csrf
                                          <div class="modal-header">
                                              <h4 class="modal-title">Warning</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p>File Path : </p>
                                              <p>You are about to approve <b>{{$list->product_title}}</b> to online system.</p><p> Please make sure the data is correct before confirming.</p>
                                          </div>
                                          <div class="modal-footer justify-content-between">
                                              <a href="denyDownload/{{$list->product_id}}"><button type="button" class="btn btn-danger" data-dismiss="modal">Deny</button></a>
                                              <a href="confirmDownload/{{$list->product_id}}"><button type="submit" class="btn btn-primary">Confirm</button></a>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th><a href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'product_title', 'order'=>$order == 'ASC' && $orderby == 'product_title' ? 'DESC' : 'ASC', 'page'=>$page])}}">Title<i class="{{$orderby == 'product_title' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'product_model_name', 'order'=>$order == 'ASC' && $orderby == 'product_model_name' ? 'DESC' : 'ASC', 'page'=>$page])}}">Model Name<i class="{{$orderby == 'product_model_name' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'product_showed', 'order'=>$order == 'ASC' && $orderby == 'product_showed' ? 'DESC' : 'ASC', 'page'=>$page])}}">Status<i class="{{$orderby == 'product_showed' ? $order : ''}}"></i></a></th>
                  </tr>
                  </tfoot>
                </table>

    <nav style="margin-top:12px; float: right">
        <ul class="pagination">
            <li class="page-item" aria-disabled="true" aria-label="@lang('pagination.first')" style="position:absolute; left:15px;">
                <span>showing {{$result['from']}} to {{$result['to']}} of {{$result['total']}} data</span>
            </li>
            {{-- Previous & First Page Link --}}
            @if ($result['current_page'] == 1)
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>$orderby, 'order'=>$order, 'page'=>$page-1])}}" rel="prev" aria-label="@lang('pagination.first')">&laquo;</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>$orderby, 'order'=>$order, 'page'=>1]) }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}

                {{-- Array Of Links --}}
                    @for ($index = 1 ; $index <= $result['last_page']; $index++ )
                        @if ($index == $result['current_page'])
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $index }}</span></li>
                        @elseif($index != $result['current_page'] && (($index > $result['current_page'] - 4 && $index < $result['current_page'] + 4) || ($index > $result['current_page'] + 3 && $index > $result['last_page'] - 3) || ($index <  3 && $index < $result['current_page'] - 3)) )
                            <li class="page-item"><a class="page-link" href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>$orderby, 'order'=>$order, 'page'=>$index])}}">{{ $index }}</a></li>
                        @elseif($index != $result['current_page'] && ($index == $result['current_page'] + 4 && $index < $result['total'] - 3) || ($index == $result['current_page'] - 4 && $index > 2) )
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                        @endif
                    @endfor

            {{-- Next & Last Page Link --}}
            @if ($amount * $result['current_page'] >= $result['total'])
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>$orderby, 'order'=>$order, 'page'=>$page+1])}}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{route('productList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>$orderby, 'order'=>$order, 'page'=>$result['last_page']])}}" rel="next" aria-label="@lang('pagination.last')">&raquo;</a>
                </li>
                </li>
            @endif
        </ul>
    </nav>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection