@section('home-menu', 'menu-open')
@section('home-href', 'active')
@section('all_data', 'active')

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
</style>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Online Download List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Online Download List</li>
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
                <h3 class="card-title">Online Downloads</h3>
                <form class="form-inline ml-3" style="position: absolute; right: 15px; bottom: 7px;">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="search">
                        <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        </div>
                    </div>
                </form>
                <form class="form-inline ml-3" style="position: absolute; left: 15%; top: 7px;">
                    <div class="input-group input-group-sm">
                        <p>show &nbsp</p>
                        <select class="form-control" name="country" onchange="location = this.value;">
                            <option value="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => '5', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 5 ? 'selected' : ''}}>5</option>
                            <option value="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => '15', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 15 ? 'selected' : ''}}>15</option>
                            <option value="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => '50', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 50 ? 'selected' : ''}}>50</option>
                            <option value="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => '100', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 100 ? 'selected' : ''}}>100</option>
                        </select>
                        <p>&nbsp data per page</p>
                    </div>
                </form>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><a href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order == 'ASC' && $orderby == 'download_title' ? 'DESC' : 'ASC', 'page' => $page])}}">Title<i class="{{$orderby == 'download_title' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_file', 'order' => $order == 'ASC' && $orderby == 'download_file' ? 'DESC' : 'ASC', 'page' => $page])}}">File<i class="{{$orderby == 'download_file' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_size', 'order' => $order == 'ASC' && $orderby == 'download_size' ? 'DESC' : 'ASC', 'page' => $page])}}">Size<i class="{{$orderby == 'download_size' ? $order : ''}}"></i></a></th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <input type="hidden" id="csrf" value="{{csrf_token()}}">
                      @foreach($data as $list)
                          <tr>
                              <td>{{$list->download_title}}</td>
                              <td>{{$list->download_file}}</td>
                              <td>{{$list->download_size}}</td>
                              <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-{{$list->download_id}}">Edit</button></td>
                          </tr>
                          <div class="modal fade" id="modal-{{$list->download_id}}">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                          <div class="modal-header">
                                              <h4 class="modal-title">Warning</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p>File Path : </p>
                                              <p>You are about to approve <b>{{$list->download_title}}</b> to online system.</p><p> Please make sure the data is correct before confirming.</p>

                                              <div class="row">
                                                <input class="form-control search-product" type="text">
                                                <div class="col-sm-5">
                                                  <!-- Select multiple-->
                                                  <div class="form-group">
                                                    <label>Select Multiple</label>
                                                    <select multiple class="form-control" id="product_pool">
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="col-sm-2">
                                                  <div class="form-group">
                                                    <label>action</label>
                                                    <div class="form-control">
                                                      <button type="button" class="btn btn-default" id="btn-add-selected">></button>
                                                      <br>
                                                      <button type="button" class="btn btn-default" id="btn-add-all">>></button>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-sm-5">
                                                  <div class="form-group">
                                                    <label>Select Multiple</label>
                                                    <select multiple class="form-control" id="seleted_relation">
                                                      @foreach($list->has_many_product as $relation)
                                                        <option value="{{$relation['product_id']}}">{{$relation['product_title']}}</option>
                                                      @endforeach
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>
                                          <div class="modal-footer justify-content-between">
                                              <a href="denyDownload/{{$list->download_id}}"><button type="button" class="btn btn-danger" data-dismiss="modal">Deny</button></a>
                                              <a href="confirmDownload/{{$list->download_id}}"><button type="submit" class="btn btn-primary">Confirm</button></a>
                                          </div>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th><a href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order == 'ASC' && $orderby == 'download_title' ? 'DESC' : 'ASC', 'page' => $page])}}">Title<i class="{{$orderby == 'download_title' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_file', 'order' => $order == 'ASC' && $orderby == 'download_file' ? 'DESC' : 'ASC', 'page' => $page])}}">Title<i class="{{$orderby == 'download_file' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_file', 'order' => $order == 'ASC' && $orderby == 'download_file' ? 'DESC' : 'ASC', 'page' => $page])}}">Title<i class="{{$orderby == 'download_file' ? $order : ''}}"></i></a></th>
                    <th>Action</th>
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
                    <a class="page-link" href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order, 'page' => $page-1])}}" rel="prev" aria-label="@lang('pagination.first')">&laquo;</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ route('downloadList.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'download_title', 'order'=>$order, 'page'=>1]) }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}

                {{-- Array Of Links --}}
                    @for ($index = 1 ; $index <= $result['last_page']; $index++ )
                        @if ($index == $result['current_page'])
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $index }}</span></li>
                        @elseif($index != $result['current_page'] && (($index > $result['current_page'] - 4 && $index < $result['current_page'] + 4) || ($index > $result['current_page'] + 3 && $index > $result['last_page'] - 3) || ($index <  3 && $index < $result['current_page'] - 3)) )
                            <li class="page-item"><a class="page-link" href="{{route('productList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'product_title', 'order' => $order, 'page' => $index])}}">{{ $index }}</a></li>
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
                    <a class="page-link" href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order, 'page' => $page+1])}}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{route('downloadList.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order, 'page' => $result['last_page']])}}" rel="next" aria-label="@lang('pagination.last')">&raquo;</a>
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
      <script>
        $(".search-product").on('keypress',function(e) {
            if(e.which == 13) {
            $.ajax({
              type: "GET",
              url: '/api/productList/'+$(this).val(),
              data: '',
              success:function(msg){
                $("#product_pool").empty();
                msg.forEach(function(value) {
                  $("#product_pool").append('<option value='+value['product_id']+'>'+value['product_title']+'</option>');
                });
              },
              error:function(msg){
                console.log(msg);
              }
            });
            }
        });
        $("#btn-add-selected").on("click", function(){
          $('#product_pool option:selected').each(function(value){
            $("#seleted_relation").append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
            $(this).remove();
          });
        });
        $("#btn-add-all").on("click", function(){
          $('#product_pool').children().each(function(value){
            $("#seleted_relation").append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
          });
          $('#product_pool').empty();
        });
        
        $("#btn-add-selected").on("click", function(){
          $('#product_pool option:selected').each(function(value){
            $("#seleted_relation").append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
            $(this).remove();
          });
        });
        $("#btn-add-all").on("click", function(){
          $('#product_pool').children().each(function(value){
            $("#seleted_relation").append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
          });
          $('#product_pool').empty();
        });
      </script>
    </section>
@endsection