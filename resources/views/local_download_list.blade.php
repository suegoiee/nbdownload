@section('home-menu', 'menu-open')
@section('home-href', 'active')
@section('download_tmp', 'active')
@section('title', 'Local Download')

@extends('layouts.base')

@section('content')
<link rel="stylesheet" href="{{asset('storage/css/'.$module_name.'/'.$module_name.'.css')}}">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="page-title">Local Download Data</h1>
                <form class="form-inline ml-3 page-title">
                    <div class="input-group input-group-sm">
                        <p>data status &nbsp</p>
                        <select class="form-control" name="country" onchange="location = this.value;">
                            <option value="{{route('downloadListLocal.show', ['status'=>'all', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'all' ? 'selected' : ''}}>All Data</option>
                            <option value="{{route('downloadListLocal.show', ['status'=>'Draft', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'Draft' ? 'selected' : ''}}>Draft</option>
                            <option value="{{route('downloadListLocal.show', ['status'=>'Approve', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'Approve' ? 'selected' : ''}}>Approved</option>
                            <option value="{{route('downloadListLocal.show', ['status'=>'Reject', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'Reject' ? 'selected' : ''}}>Rejected</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Local Download Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <input type="hidden" id="downloadListLocal-api" value="{{route('downloadListLocal.downloadActionByBatch')}}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Local Download Data</h3>
                        <form class="form-inline ml-3 table-title">
                            <input type="hidden" id="csrf" value="{{csrf_token()}}">
                            <div class="input-group input-group-sm">
                                <p>show &nbsp</p>
                                <select class="form-control" name="country" onchange="location = this.value;">
                                    <option value="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '5', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 5 ? 'selected' : ''}}>5</option>
                                    <option value="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '15', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 15 ? 'selected' : ''}}>15</option>
                                    <option value="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '50', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 50 ? 'selected' : ''}}>50</option>
                                    <option value="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '100', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 100 ? 'selected' : ''}}>100</option>
                                </select>
                                <p>&nbsp data per page</p>
                                @if($status == 'Draft')
                                    <button type="submit" form="downloadActionByBatch" class="btn btn-warning btn-batch table-control-button" data-dismiss="modal" name="action" value="Reject">Reject by batch</button>
                                @endif
                                @if($status == 'Reject')
                                    <button type="submit" form="downloadActionByBatch" class="btn btn-success btn-batch table-control-button" data-dismiss="modal" name="action" value="Draft">Draft by batch</button>
                                @endif
                                <a href="{{route('downloadListLocal.export', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}{{ app('request')->input('page') != null ? '?page='.app('request')->input('page') : ''}}"><button type="button" class="btn btn-danger table-control-button">Export CSV</button></a>
                            </div>
                        </form>
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
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    @if($status != 'all' && $status != 'Approve')
                                        <th>Select</th>
                                    @endif
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_no', 'order' => $order == 'ASC' && $orderby == 'tmp_no' ? 'DESC' : 'ASC'])}}">ID<i class="{{$orderby == 'tmp_no' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_title', 'order' => $order == 'ASC' && $orderby == 'tmp_title' ? 'DESC' : 'ASC'])}}">Title<i class="{{$orderby == 'tmp_title' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_marketing_name', 'order' => $order == 'ASC' && $orderby == 'tmp_marketing_name' ? 'DESC' : 'ASC'])}}">Marketing Name<i class="{{$orderby == 'tmp_marketing_name' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_prd_model_name', 'order' => $order == 'ASC' && $orderby == 'tmp_prd_model_name' ? 'DESC' : 'ASC'])}}">Model Name<i class="{{$orderby == 'tmp_prd_model_name' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_category', 'order' => $order == 'ASC' && $orderby == 'tmp_category' ? 'DESC' : 'ASC'])}}">Category Name<i class="{{$orderby == 'tmp_category' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_device', 'order' => $order == 'ASC' && $orderby == 'tmp_device' ? 'DESC' : 'ASC'])}}">Device<i class="{{$orderby == 'tmp_device' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_version', 'order' => $order == 'ASC' && $orderby == 'tmp_version' ? 'DESC' : 'ASC'])}}">Version<i class="{{$orderby == 'tmp_version' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_packageVersion', 'order' => $order == 'ASC' && $orderby == 'tmp_packageVersion' ? 'DESC' : 'ASC'])}}">Package Version<i class="{{$orderby == 'tmp_packageVersion' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_os', 'order' => $order == 'ASC' && $orderby == 'tmp_os' ? 'DESC' : 'ASC'])}}">OS<i class="{{$orderby == 'tmp_os' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_osImage', 'order' => $order == 'ASC' && $orderby == 'tmp_osImage' ? 'DESC' : 'ASC'])}}">OS Image<i class="{{$orderby == 'tmp_osImage' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_crc', 'order' => $order == 'ASC' && $orderby == 'tmp_crc' ? 'DESC' : 'ASC'])}}">CRC<i class="{{$orderby == 'tmp_crc' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_ctime', 'order' => $order == 'ASC' && $orderby == 'tmp_ctime' ? 'DESC' : 'ASC'])}}">Create Date<i class="{{$orderby == 'tmp_ctime' ? $order : ''}}"></i></a></th>
                                    @if($status == 'Draft' || $status == 'all')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $download_data)
                                    <tr class="{{$download_data->tmp_status == 2 ? 'table-danger' : ''}}">
                                        @if($status != 'all' && $status != 'Approve')
                                            <td>
                                                <input type="checkbox" class="downloadBatch" name="id[]" value="{{$download_data->tmp_no}}" {{$download_data->tmp_status == 1 ? 'disabled' : ''}}>
                                            </td>
                                        @endif
                                        <td>{{$download_data->tmp_no}}</td>
                                        <td>{{$download_data->tmp_title}}</td>
                                        <td>{{$download_data->tmp_marketing_name}}</td>
                                        <td>{{$download_data->tmp_prd_model_name}}</td>
                                        <td>{{$download_data->tmp_category}}</td>
                                        <td>{{$download_data->tmp_device}}</td>
                                        <td>{{$download_data->tmp_version}}</td>
                                        <td>{{$download_data->tmp_packageVersion}}</td>
                                        <td>{{$download_data->tmp_os}}</td>
                                        <td>{{$download_data->tmp_osImage}}</td>
                                        <td>{{$download_data->tmp_crc}}</td>
                                        <td>{{$download_data->tmp_ctime->toDateString()}}</td>
                                        @if($status == 'Draft' || $status == 'all')
                                            <td>
                                                <button type="button" class="btn {{$download_data->tmp_status == 0 ? 'btn-primary' : 'btn-default'}}" data-toggle="modal" data-target="#modal-{{$download_data->tmp_no}}" {{$download_data->tmp_status == 0 ? '' : 'disabled'}}>Approve</button>
                                            </td>
                                        @endif
                                    </tr>
                                    @if( $download_data->tmp_status != 1 )
                                        <div class="modal fade" id="modal-{{$download_data->tmp_no}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{route('onlineHandShake.confirmDownload')}}" method="POST" id="confirmDownload-{{$download_data->tmp_no}}">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Warning</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if( $download_data->tmp_category == 'Driver and Application' || $download_data->tmp_category == 'Driver' )
                                                                <div class="form-group">
                                                                    <label>File Path : </label>
                                                                    <select name="file_path" class="form-control select2" style="width: 100%;">
                                                                        @foreach($file_path_list as $file)
                                                                            <option value="{{$file['index']}}">{{$file['index']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                            <p>You are about to approve <b>{{$download_data->tmp_title}}</b> to online system.</p>
                                                            <p> Please make sure the data is correct before confirming.</p>
                                                            <input type="hidden" name="tmp_no" value="{{$download_data->tmp_no}}">
                                                            <input type="hidden" name="download_id" value="{{$download_data->download_id}}">
                                                            <input type="hidden" name="tmp_prd_list_no" value="{{$download_data->tmp_prd_list_no}}">
                                                            <input type="hidden" name="tmp_marketing_name" value="{{$download_data->tmp_marketing_name}}">
                                                            <input type="hidden" name="tmp_prd_model_name" value="{{$download_data->tmp_prd_model_name}}">
                                                            <input type="hidden" name="tmp_title" value="{{$download_data->tmp_title}}">
                                                            <input type="hidden" name="tmp_file_name" value="{{$download_data->tmp_file_name}}">
                                                            <input type="hidden" name="tmp_file_category" value="{{$download_data->tmp_file_category}}">
                                                            <input type="hidden" name="tmp_description" value="{{$download_data->tmp_description}}">
                                                            <input type="hidden" name="tmp_device" value="{{$download_data->tmp_device}}">
                                                            <input type="hidden" name="tmp_version" value="{{$download_data->tmp_version}}">
                                                            <input type="hidden" name="tmp_guid" value="{{$download_data->tmp_guid}}">
                                                            <input type="hidden" name="tmp_upgradeguid" value="{{$download_data->tmp_upgradeguid}}">
                                                            <input type="hidden" name="tmp_deviceid" value="{{$download_data->tmp_deviceid}}">
                                                            <input type="hidden" name="tmp_silentInstantparameter" value="{{$download_data->tmp_silentInstantparameter}}">
                                                            <input type="hidden" name="tmp_crc" value="{{$download_data->tmp_crc}}">
                                                            <input type="hidden" name="tmp_ctime" value="{{$download_data->tmp_ctime}}">
                                                            <input type="hidden" name="tmp_os" value="{{$download_data->tmp_os}}">
                                                            <input type="hidden" name="tmp_type" value="{{$download_data->tmp_type}}">
                                                            <input type="hidden" name="tmp_category" value="{{$download_data->tmp_category}}">
                                                            <input type="hidden" name="tmp_other" value="{{$download_data->tmp_other}}">
                                                            <input type="hidden" name="tmp_packageVersion" value="{{$download_data->tmp_packageVersion}}">
                                                            <input type="hidden" name="tmp_reboot" value="{{$download_data->tmp_reboot}}">
                                                            <input type="hidden" name="tmp_source" value="{{$download_data->tmp_source}}">
                                                            <input type="hidden" name="tmp_osImage" value="{{$download_data->tmp_osImage}}">
                                                            <input type="hidden" name="tmp_status" value="{{$download_data->tmp_status}}">
                                                            <input type="hidden" name="tmp_ctime" value="{{$download_data->tmp_ctime}}">
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                                                            <button type="submit" class="btn btn-danger" name="action" value="Reject">Reject</button>
                                                            <button type="submit" class="btn btn-primary" name="action" value="Approve">Approve</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    @if($status != 'all' && $status != 'Approve')
                                        <th>Select</th>
                                    @endif
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_no', 'order' => $order == 'ASC' && $orderby == 'tmp_no' ? 'DESC' : 'ASC'])}}">ID<i class="{{$orderby == 'tmp_no' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_title', 'order' => $order == 'ASC' && $orderby == 'tmp_title' ? 'DESC' : 'ASC'])}}">Title<i class="{{$orderby == 'tmp_title' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_marketing_name', 'order' => $order == 'ASC' && $orderby == 'tmp_marketing_name' ? 'DESC' : 'ASC'])}}">Marketing Name<i class="{{$orderby == 'tmp_marketing_name' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_prd_model_name', 'order' => $order == 'ASC' && $orderby == 'tmp_prd_model_name' ? 'DESC' : 'ASC'])}}">Model Name<i class="{{$orderby == 'tmp_prd_model_name' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_category', 'order' => $order == 'ASC' && $orderby == 'tmp_category' ? 'DESC' : 'ASC'])}}">Category Name<i class="{{$orderby == 'tmp_category' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_device', 'order' => $order == 'ASC' && $orderby == 'tmp_device' ? 'DESC' : 'ASC'])}}">Device<i class="{{$orderby == 'tmp_device' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_version', 'order' => $order == 'ASC' && $orderby == 'tmp_version' ? 'DESC' : 'ASC'])}}">Version<i class="{{$orderby == 'tmp_version' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_packageVersion', 'order' => $order == 'ASC' && $orderby == 'tmp_packageVersion' ? 'DESC' : 'ASC'])}}">Package Version<i class="{{$orderby == 'tmp_packageVersion' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_os', 'order' => $order == 'ASC' && $orderby == 'tmp_os' ? 'DESC' : 'ASC'])}}">OS<i class="{{$orderby == 'tmp_os' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_osImage', 'order' => $order == 'ASC' && $orderby == 'tmp_osImage' ? 'DESC' : 'ASC'])}}">OS Image<i class="{{$orderby == 'tmp_osImage' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_crc', 'order' => $order == 'ASC' && $orderby == 'tmp_crc' ? 'DESC' : 'ASC'])}}">CRC<i class="{{$orderby == 'tmp_crc' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('downloadListLocal.show', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_ctime', 'order' => $order == 'ASC' && $orderby == 'tmp_ctime' ? 'DESC' : 'ASC'])}}">Create Date<i class="{{$orderby == 'tmp_ctime' ? $order : ''}}"></i></a></th>
                                    @if($status == 'Draft' || $status == 'all')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                        {{ $data->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('storage/js/'.$module_name.'/'.$module_name.'.js')}}"></script>
</section>
@endsection