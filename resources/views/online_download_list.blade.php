@section('home-menu', 'menu-open')
@section('home-href', 'active')
@section('download_online', 'active')
@section('title', 'Online Download')

@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{asset('storage/css/'.$module_name.'/'.$module_name.'.css')}}">
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
    <input type="hidden" value="{{route('api.downloadOnlineList')}}" id="downloadOnlineList-api">
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
                            @can('super')
                                <button type="button" class="btn btn-primary table-control-button" data-toggle="modal" data-target="#modal-create-manual">Create Manual</button>
                            @endcan
                        </div>
                    </form>
                    <div class="modal fade" id="modal-create-manual">
                        <div class="modal-dialog modal-xl">
                            <form id="modal-create-manual" action="{{route('onlineHandShake.createOnlineData')}}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Create Online Data Manually</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row model-group">
                                            <div class="col-sm-12">
                                                <input name="action" type="hidden" value="insert">
                                                Title<input name="download_title" class="form-control" type="text">
                                                Category
                                                <select name="download_category" class="form-control" type="select">
                                                    <option value="Driver">BIOS</option>
                                                    <option value="Driver">EC</option>
                                                    <option value="Driver">VBIOS</option>
                                                </select>
                                                File Path<input name="download_file" class="form-control" type="text">
                                                Size<input name="download_size" class="form-control" type="text">
                                                OS
                                                <select name="os_id" class="form-control" type="text">
                                                    @foreach($os_list as $os)
                                                        <option value="{{$os->os_id}}">{{$os->os_title}}</option>
                                                    @endforeach
                                                </select>
                                                Type
                                                <select name="type_id" class="form-control" type="text">
                                                    @foreach($type_list as $parent_type)
                                                        @if($parent_type->type_parent == 0)
                                                            <option disabled style="background:#5F9EA0; color: black;"><b >{{$parent_type->type_title}}</b></option>
                                                            <option value="{{$parent_type->type_id}},{{$parent_type->type_id}}">{{$parent_type->type_title}}</option>
                                                        @foreach($type_list as $child_type)
                                                            @if($child_type->type_parent == $parent_type->type_id)
                                                                <option value="{{$child_type->type_id}},{{$child_type->type_parent}}">{{$child_type->type_title}}</option>
                                                            @endif
                                                        @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                Guid<input name="download_guid" class="form-control" type="text">
                                                CRC<input name="download_crc" class="form-control" type="text">
                                                Device ID<input name="download_deviceid" class="form-control" type="text">
                                                Upgrade Guid<input name="download_upgradeguid" class="form-control" type="text">
                                                Package Version<input name="download_packageversion" class="form-control" type="text">
                                                Version<input name="download_version" class="form-control" type="text">
                                                Description<textarea name="download_description" class="form-control" type="text"></textarea>
                                                Description TW<textarea name="download_description_tw" class="form-control" type="text"></textarea>
                                                Description CN<textarea name="download_description_cn" class="form-control" type="text"></textarea>
                                                Note<input name="download_note" class="form-control" type="text">
                                                Note TW<input name="download_note_tw" class="form-control" type="text">
                                                Note CN<input name="download_note_cn" class="form-control" type="text">
                                                Other<input name="download_other" class="form-control" type="text">
                                                Reboot<input name="download_reboot" class="form-control" type="text">
                                                Release<input name="download_release" class="form-control" type="text">
                                                Show
                                                <select name="download_showed" class="form-control" type="select">
                                                    <option value="0">No show</option>
                                                    <option value="1">Show</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="relation-group">
                                            <div class="row model-group">
                                                <div class="col-sm-12">
                                                    <b><h2 class="modal-group-title">Model Relation</h2></b>
                                                </div>
                                                <div class="col-sm-3">
                                                    <h5 class="modal-title">Search Model</h5>
                                                    <div class="input-group">
                                                        <input class="form-control search-model" type="search" placeholder="Search" aria-label="Search" model-id="create_search">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-navbar" type="button" >
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h5 class="modal-title">Search Product</h5>
                                                    <div class="input-group">
                                                        <input class="form-control search-product" type="search" placeholder="Search" aria-label="Search" model-id="create_search">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-navbar" type="button" >
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row model-group">
                                                <div class="col-sm-3 relation-action">
                                                    <!-- Select multiple-->
                                                    <div class="form-group">
                                                        <label>Models</label>
                                                        <button type="button" class="form-control btn btn-default btn-add-model-product" value="create_search">+</button>
                                                        <select class="form-control" id="model_pool-create_search" size="20"></select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 relation-action">
                                                    <!-- Select multiple-->
                                                    <div class="form-group">
                                                        <label>Products</label>
                                                        <button type="button" class="form-control btn btn-default btn-add-all" value="create_search">>></button>
                                                        <select multiple class="form-control" id="product_pool-create_search" size="20"></select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                        <div class="form-group relation-action">
                                                            <label>action</label>
                                                            <button type="button" class="form-control btn btn-default btn-add-selected btn-relation-action" value="create_search">></button>
                                                            <br>
                                                            <button type="button" class="form-control btn btn-default btn-remove-selected btn-relation-action" value="create_search"><</button>
                                                        </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group relation-action">
                                                        <label>Product relation</label>
                                                        <button type="button" class="form-control btn btn-default btn-remove-all" value="create_search">X</button>
                                                        <select multiple class="form-control" id="seleted_relation-create_search" size="20"></select>
                                                        <select style="display:none;" name="product_id[]" multiple class="form-control" id="seleted_product-create_search"></select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                                        <div class="col-sm-12">
                                                            <input name="action" type="hidden" value="update">
                                                            <input name="download_id" class="form-control" type="hidden" value="{{$list->download_id}}">
                                                            Title<input name="download_title" class="form-control" type="text" value="{{$list->download_title}}">
                                                            File Path<input name="download_file" class="form-control" type="text" value="{{$list->download_file}}">
                                                            Size<input name="download_size" class="form-control" type="text" value="{{$list->download_size}}">
                                                            OS
                                                            <select name="os_id" class="form-control" type="text">
                                                                @foreach($os_list as $os)
                                                                    <option value="{{$os->os_id}}" {{$os->os_id == $list->os_id ? 'selected' : ''}}>{{$os->os_title}}</option>
                                                                @endforeach
                                                            </select>
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
                                                            Release<input name="download_release" class="form-control" type="datetime-local" value="{{date('Y-m-d\TH:i', strtotime($list->download_release))}}">
                                                            Show
                                                            <select name="download_showed" class="form-control" type="select">
                                                                <option value="{{$list->download_showed}}" {{$list->download_showed == 0 ? 'selected' : ''}}>No show</option>
                                                                <option value="{{$list->download_showed}}" {{$list->download_showed == 1 ? 'selected' : ''}}>Show</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="relation-group">
                                                        <div class="row model-group">
                                                            <div class="col-sm-12">
                                                                <b><h2 class="modal-group-title">Model Relation</h2></b>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <h5 class="modal-title">Search Model</h5>
                                                                <div class="input-group">
                                                                    <input class="form-control search-model" type="search" placeholder="Search" aria-label="Search" model-id="{{$list->download_id}}">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-navbar btn-search-model" type="button" >
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <h5 class="modal-title">Search Product</h5>
                                                                <div class="input-group">
                                                                    <input class="form-control search-product" type="search" placeholder="Search" aria-label="Search" model-id="{{$list->download_id}}">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-navbar btn-search-product" type="button" >
                                                                            <i class="fas fa-search"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row model-group">
                                                            <div class="col-sm-3 relation-action">
                                                                <!-- Select multiple-->
                                                                <div class="form-group">
                                                                    <label>Models</label>
                                                                    <button type="button" class="form-control btn btn-default btn-add-model-product" value="{{$list->download_id}}">+</button>
                                                                    <select class="form-control" id="model_pool-{{$list->download_id}}" size="20"></select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4 relation-action">
                                                                <!-- Select multiple-->
                                                                <div class="form-group">
                                                                    <label>Products</label>
                                                                    <button type="button" class="form-control btn btn-default btn-add-all" value="{{$list->download_id}}">>></button>
                                                                    <select multiple class="form-control" id="product_pool-{{$list->download_id}}" size="20"></select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                    <div class="form-group relation-action">
                                                                        <label>action</label>
                                                                        <button type="button" class="form-control btn btn-default btn-add-selected btn-relation-action" value="{{$list->download_id}}">></button>
                                                                        <br>
                                                                        <button type="button" class="form-control btn btn-default btn-remove-selected btn-relation-action" value="{{$list->download_id}}"><</button>
                                                                    </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group relation-action">
                                                                    <label>Product relation</label>
                                                                    <button type="button" class="form-control btn btn-default btn-remove-all" value="{{$list->download_id}}">X</button>
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
    <script src="{{asset('storage/js/'.$module_name.'/'.$module_name.'.js')}}"></script>
</section>
@endsection