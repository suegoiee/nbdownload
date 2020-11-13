@section('home-menu', 'menu-open')
@section('home-href', 'active')
@section('download_online', 'active')
@section('title', 'Online Download')

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
    .model-group{
        margin: 45px;
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
    .card-body{
        overflow:auto;
        display:block;
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
    <input type="hidden" value="{{route('api.productList')}}" id="productList-api">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Online Downloads</h3>
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
                    <form class="form-inline ml-3 table-title">
                        <div class="input-group input-group-sm">
                            <p>show &nbsp</p>
                            <select class="form-control" name="country" onchange="location = this.value;">
                                <option value="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => '5', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 5 ? 'selected' : ''}}>5</option>
                                <option value="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => '15', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 15 ? 'selected' : ''}}>15</option>
                                <option value="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => '50', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 50 ? 'selected' : ''}}>50</option>
                                <option value="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => '100', 'orderby' => $orderby, 'order' => $order, 'page' => '1'])}}" {{$amount == 100 ? 'selected' : ''}}>100</option>
                            </select>
                            <p>&nbsp data per page</p>
                            <a href="{{route('downloadListOnline.export', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order, 'page' => $page])}}"><button type="button" class="btn btn-danger table-control-button">Export CSV</button></a>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_id', 'order' => $order == 'ASC' && $orderby == 'download_id' ? 'DESC' : 'ASC', 'page' => $page])}}">ID<i class="{{$orderby == 'download_id' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order == 'ASC' && $orderby == 'download_title' ? 'DESC' : 'ASC', 'page' => $page])}}">Title<i class="{{$orderby == 'download_title' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_file', 'order' => $order == 'ASC' && $orderby == 'download_file' ? 'DESC' : 'ASC', 'page' => $page])}}">File<i class="{{$orderby == 'download_file' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_size', 'order' => $order == 'ASC' && $orderby == 'download_size' ? 'DESC' : 'ASC', 'page' => $page])}}">Size<i class="{{$orderby == 'download_size' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_version', 'order' => $order == 'ASC' && $orderby == 'download_version' ? 'DESC' : 'ASC', 'page' => $page])}}">Version<i class="{{$orderby == 'download_version' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_packageversion', 'order' => $order == 'ASC' && $orderby == 'download_packageversion' ? 'DESC' : 'ASC', 'page' => $page])}}">Package Version<i class="{{$orderby == 'download_packageversion' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_crc', 'order' => $order == 'ASC' && $orderby == 'download_crc' ? 'DESC' : 'ASC', 'page' => $page])}}">CRC<i class="{{$orderby == 'download_crc' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'os_id', 'order' => $order == 'ASC' && $orderby == 'os_id' ? 'DESC' : 'ASC', 'page' => $page])}}">OS<i class="{{$orderby == 'os_id' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_showed', 'order' => $order == 'ASC' && $orderby == 'download_showed' ? 'DESC' : 'ASC', 'page' => $page])}}">Is Show<i class="{{$orderby == 'download_showed' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_release', 'order' => $order == 'ASC' && $orderby == 'download_release' ? 'DESC' : 'ASC', 'page' => $page])}}">Release Date<i class="{{$orderby == 'download_release' ? $order : ''}}"></i></a></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" id="csrf" value="{{csrf_token()}}">
                            @foreach($data as $list)
                                <tr>
                                    <td>{{$list->download_id}}</td>
                                    <td>{{$list->download_title}}</td>
                                    <td>{{$list->download_file}}</td>
                                    <td>{{$list->download_size}}</td>
                                    <td>{{$list->download_version}}</td>
                                    <td>{{$list->download_packageversion}}</td>
                                    <td>{{$list->download_crc}}</td>
                                    <td>
                                        {{$list->os_id}}
                                        @foreach($list->has_many_download_os as $os)
                                            {{$os['os_title']}}
                                            @if(!$loop->last)
                                                <b> | </b>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$list->download_showed == 0 ? 'hide' : 'showed'}}</td>
                                    <td>{{$list->download_release}}</td>
                                    <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-{{$list->download_id}}">Edit</button></td>
                                </tr>
                                <div class="modal fade" id="modal-{{$list->download_id}}">
                                    <div class="modal-dialog modal-xl">
                                        <form id="updateOnlineData_form{{$list->download_id}}" action="{{route('onlineHandShake.updateOnlineData')}}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{$list->download_title == null ? $list->download_file : $list->download_title}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row model-group">
                                                        <div class="col-sm-10">
                                                            <input name="download_id" class="form-control" type="hidden" value="{{$list->download_id}}">
                                                            Title<input name="download_title" class="form-control" type="text" value="{{$list->download_title}}">
                                                            File Path<input name="download_file" class="form-control" type="text" value="{{$list->download_file}}">
                                                            Size<input name="download_size" class="form-control" type="text" value="{{$list->download_size}}">
                                                            OS<input name="os_id" class="form-control" type="text" value="{{$list->os_id}}">
                                                            Type
                                                            <select name="type_id" class="form-control" type="text">
                                                                @foreach($type_list as $parent_type)
                                                                    @if($parent_type->type_parent == 0)
                                                                        <option disabled style="background:#5F9EA0; color: black;"><b >{{$parent_type->type_title}}</b></option>
                                                                        <option value="{{$parent_type->type_id}},{{$parent_type->type_id}}" {{$list->type_id == $parent_type->type_id ? 'selected' : ''}}>{{$parent_type->type_title}}</option>
                                                                    @foreach($type_list as $child_type)
                                                                        @if($child_type->type_parent == $parent_type->type_id)
                                                                            <option value="{{$child_type->type_id}},{{$child_type->type_parent}}" {{$list->type_id == $child_type->type_id ? 'selected' : ''}}>{{$child_type->type_title}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            Guid<input name="download_guid" class="form-control" type="text" value="{{$list->download_guid}}">
                                                            CRC<input name="download_crc" class="form-control" type="text" value="{{$list->download_crc}}">
                                                            Device ID<input name="download_deviceid" class="form-control" type="text" value="{{$list->download_deviceid}}">
                                                            Upgrade Guid<input name="download_upgradeguid" class="form-control" type="text" value="{{$list->download_upgradeguid}}">
                                                            Package Version<input name="download_packageversion" class="form-control" type="text" value="{{$list->download_packageversion}}">
                                                            Version<input name="download_version" class="form-control" type="text" value="{{$list->download_version}}">
                                                            Description<textarea name="download_description" class="form-control" type="text">{!!$list->download_description!!}</textarea>
                                                            Description TW<textarea name="download_description_tw" class="form-control" type="text">{!!$list->download_description_tw!!}</textarea>
                                                            Description CN<textarea name="download_description_cn" class="form-control" type="text">{!!$list->download_description_cn!!}</textarea>
                                                            Note<input name="download_note" class="form-control" type="text" value="{{$list->download_note}}">
                                                            Note TW<input name="download_note_tw" class="form-control" type="text" value="{{$list->download_note_tw}}">
                                                            Note CN<input name="download_note_cn" class="form-control" type="text" value="{{$list->download_note_cn}}">
                                                            Other<input name="download_other" class="form-control" type="text" value="{{$list->download_other}}">
                                                            Reboot<input name="download_reboot" class="form-control" type="text" value="{{$list->download_reboot}}">
                                                            Release<input name="download_release" class="form-control" type="text" value="{{$list->download_release}}">
                                                            Show
                                                            <select name="download_showed" class="form-control" type="select">
                                                                <option value="{{$list->download_showed}}" {{$list->download_showed == 0 ? 'selected' : ''}}>No show</option>
                                                                <option value="{{$list->download_showed}}" {{$list->download_showed == 1 ? 'selected' : ''}}>Show</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="row model-group">
                                                        <div class="col-sm-10">
                                                        <h4 class="modal-title">Model Relation</h4>
                                                        <div class="input-group">
                                                            <input class="form-control search-product" type="search" placeholder="Search" aria-label="Search" id="{{$list->download_id}}">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-navbar" type="button" >
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="col-sm-4 ">
                                                            <!-- Select multiple-->
                                                            <div class="form-group">
                                                                <label>Products</label>
                                                                <button type="button" class="btn btn-default btn-add-all" value="{{$list->download_id}}">>></button>
                                                                <select multiple class="form-control" id="product_pool-{{$list->download_id}}" size="20"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <label>action</label>
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-default btn-add-selected" value="{{$list->download_id}}">></button>
                                                                    <br>
                                                                    <button type="button" class="btn btn-default btn-remove-selected" value="{{$list->download_id}}"><</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Product relation</label>
                                                                <button type="button" class="btn btn-default btn-remove-all" value="{{$list->download_id}}">X</button>
                                                                <select multiple class="form-control" id="seleted_relation-{{$list->download_id}}" size="20">
                                                                @foreach($list->has_many_product as $relation)
                                                                    <option value="{{$relation['product_id']}}">{{$relation['product_title']}} ( {{$relation['product_model_name']}} )</option>
                                                                @endforeach
                                                                </select>
                                                                <select style="display:none;" name="product_id[]" multiple class="form-control" id="seleted_product-{{$list->download_id}}">
                                                                @foreach($list->has_many_product as $relation)
                                                                    <option value="{{$relation['product_id']}}" selected>{{$relation['product_title']}} ( {{$relation['product_model_name']}} )</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary submit-updateOnlineData_form" value="{{$list->download_id}}">Confirm</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_id', 'order' => $order == 'ASC' && $orderby == 'download_id' ? 'DESC' : 'ASC', 'page' => $page])}}">ID<i class="{{$orderby == 'download_id' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order == 'ASC' && $orderby == 'download_title' ? 'DESC' : 'ASC', 'page' => $page])}}">Title<i class="{{$orderby == 'download_title' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_file', 'order' => $order == 'ASC' && $orderby == 'download_file' ? 'DESC' : 'ASC', 'page' => $page])}}">File<i class="{{$orderby == 'download_file' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_size', 'order' => $order == 'ASC' && $orderby == 'download_size' ? 'DESC' : 'ASC', 'page' => $page])}}">Size<i class="{{$orderby == 'download_size' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_version', 'order' => $order == 'ASC' && $orderby == 'download_version' ? 'DESC' : 'ASC', 'page' => $page])}}">Version<i class="{{$orderby == 'download_version' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_packageversion', 'order' => $order == 'ASC' && $orderby == 'download_packageversion' ? 'DESC' : 'ASC', 'page' => $page])}}">Package Version<i class="{{$orderby == 'download_packageversion' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_crc', 'order' => $order == 'ASC' && $orderby == 'download_crc' ? 'DESC' : 'ASC', 'page' => $page])}}">CRC<i class="{{$orderby == 'download_crc' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'os_id', 'order' => $order == 'ASC' && $orderby == 'os_id' ? 'DESC' : 'ASC', 'page' => $page])}}">OS<i class="{{$orderby == 'os_id' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_showed', 'order' => $order == 'ASC' && $orderby == 'download_showed' ? 'DESC' : 'ASC', 'page' => $page])}}">Is Show<i class="{{$orderby == 'download_showed' ? $order : ''}}"></i></a></th>
                                <th><a href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_release', 'order' => $order == 'ASC' && $orderby == 'download_release' ? 'DESC' : 'ASC', 'page' => $page])}}">Release Date<i class="{{$orderby == 'download_release' ? $order : ''}}"></i></a></th>
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
                                    <a class="page-link" href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'download_title', 'order' => $order, 'page' => $page-1])}}" rel="prev" aria-label="@lang('pagination.first')">&laquo;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('downloadListOnline.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>'download_title', 'order'=>$order, 'page'=>1]) }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}

                                {{-- Array Of Links --}}
                                    @for ($index = 1 ; $index <= $result['last_page']; $index++ )
                                        @if ($index == $result['current_page'])
                                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $index }}</span></li>
                                        @elseif($index != $result['current_page'] && (($index > $result['current_page'] - 4 && $index < $result['current_page'] + 4) || ($index > $result['current_page'] + 3 && $index > $result['last_page'] - 3) || ($index <  3 && $index < $result['current_page'] - 3)) )
                                            <li class="page-item"><a class="page-link" href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order, 'page' => $index])}}">{{ $index }}</a></li>
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
                                    <a class="page-link" href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>$orderby, 'order'=>$order, 'page'=>$page+1])}}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{route('downloadListOnline.show', ['keyword'=>$keyword, 'amount'=>$amount, 'orderby'=>$orderby, 'order'=>$order, 'page'=>$result['last_page']])}}" rel="next" aria-label="@lang('pagination.last')">&raquo;</a>
                                </li>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".search-product").on('keypress',function(e) {
            if(e.which == 13) {
                event.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url: $("#productList-api").val(),
                    data:{
                        keyword : $(this).val()
                    },
                    success:function(msg){
                        $("#product_pool-"+id).empty();
                        msg.forEach(function(value) {
                            $("#product_pool-"+id).append('<option value='+value['product_id']+'>'+value['product_title'] +'( '+ value['product_model_name'] +' )' +'</option>');
                        });
                    },
                    error:function(msg){
                        console.log(msg);
                    }
                });
            }
        });
        $(".btn-add-selected").on("click", function(){
            var id = $(this).val();
            $('#product_pool-'+id+' option:selected').each(function(value){
                $("#seleted_relation-"+id).append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
                $("#seleted_product-"+id).append('<option value='+$(this).val()+' selected>'+$(this).html()+'</option>');
                $(this).remove();
            });
        });
        $(".btn-add-all").on("click", function(){
            var id = $(this).val();
            $('#product_pool-'+id).children().each(function(value){
                $("#seleted_relation-"+id).append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
                $("#seleted_product-"+id).append('<option value='+$(this).val()+' selected>'+$(this).html()+'</option>');
            });
            $('#product_pool-'+id).empty();
        });
        
        $(".btn-remove-selected").on("click", function(){
            var id = $(this).val();
            $('#seleted_relation-'+id+' option:selected').each(function(value){
                var seleted_relation = $(this);
                $("#product_pool-"+id).append('<option value='+seleted_relation.val()+'>'+seleted_relation.html()+'</option>');
                $(this).remove();
                $('#seleted_product-'+id).children().each(function(seleted_value){
                    if($(this).val() == seleted_relation.val()){
                        $(this).remove();
                    }
                });
            });
        });
        $(".btn-remove-all").on("click", function(){
            var id = $(this).val();
            $('#seleted_relation-'+id).children().each(function(value){
                $("#product_pool-"+id).append('<option value='+$(this).val()+'>'+$(this).html()+'</option>');
            });
            $('#seleted_relation-'+id).empty();
            $('#seleted_product-'+id).empty();
        });
    </script>
</section>
@endsection