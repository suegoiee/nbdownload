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
            <h1>All Data</h1>
            <form class="form-inline ml-3" style="position: absolute; left: 15%; top: 7px;">
                <div class="input-group input-group-sm">
                    <p>data status &nbsp</p>
                    <select class="form-control" name="country" onchange="location = this.value;">
                        <option value="{{route('data', ['status'=>'all', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'all' ? 'selected' : ''}}>All Data</option>
                        <option value="{{route('data', ['status'=>'NCND', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'NCND' ? 'selected' : ''}}>NCND</option>
                        <option value="{{route('data', ['status'=>'confirmed', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'confirmed' ? 'selected' : ''}}>Confirmed</option>
                        <option value="{{route('data', ['status'=>'denied', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$status == 'denied' ? 'selected' : ''}}>Denied</option>
                    </select>
                </div>
            </form>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Data</li>
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
                <h3 class="card-title">ALL Data</h3>
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
                            <option value="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '5', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 5 ? 'selected' : ''}}>5</option>
                            <option value="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '15', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 15 ? 'selected' : ''}}>15</option>
                            <option value="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '50', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 50 ? 'selected' : ''}}>50</option>
                            <option value="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => '100', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 100 ? 'selected' : ''}}>100</option>
                        </select>
                        <p>&nbsp data per page</p>
                    </div>
                </form>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_title', 'order' => $order == 'ASC' && $orderby == 'tmp_title' ? 'DESC' : 'ASC'])}}">Title<i class="{{$orderby == 'tmp_title' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_marketing_name', 'order' => $order == 'ASC' && $orderby == 'tmp_marketing_name' ? 'DESC' : 'ASC'])}}">Marketing Name<i class="{{$orderby == 'tmp_marketing_name' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_prd_model_name', 'order' => $order == 'ASC' && $orderby == 'tmp_prd_model_name' ? 'DESC' : 'ASC'])}}">Model Name<i class="{{$orderby == 'tmp_prd_model_name' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_device', 'order' => $order == 'ASC' && $orderby == 'tmp_device' ? 'DESC' : 'ASC'])}}">Device<i class="{{$orderby == 'tmp_device' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_version', 'order' => $order == 'ASC' && $orderby == 'tmp_version' ? 'DESC' : 'ASC'])}}">Version<i class="{{$orderby == 'tmp_version' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_packageVersion', 'order' => $order == 'ASC' && $orderby == 'tmp_packageVersion' ? 'DESC' : 'ASC'])}}">Package Version<i class="{{$orderby == 'tmp_packageVersion' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_os', 'order' => $order == 'ASC' && $orderby == 'tmp_os' ? 'DESC' : 'ASC'])}}">OS<i class="{{$orderby == 'tmp_os' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_osImage', 'order' => $order == 'ASC' && $orderby == 'tmp_osImage' ? 'DESC' : 'ASC'])}}">OS Image<i class="{{$orderby == 'tmp_osImage' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_crc', 'order' => $order == 'ASC' && $orderby == 'tmp_crc' ? 'DESC' : 'ASC'])}}">CRC<i class="{{$orderby == 'tmp_crc' ? $order : ''}}"></i></a></th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $download_data)
                        <tr>
                            <td>{{$download_data->tmp_title}}</td>
                            <td>{{$download_data->tmp_marketing_name}}</td>
                            <td>{{$download_data->tmp_prd_model_name}}</td>
                            <td>{{$download_data->tmp_device}}</td>
                            <td>{{$download_data->tmp_version}}</td>
                            <td>{{$download_data->tmp_packageVersion}}</td>
                            <td>{{$download_data->tmp_os}}</td>
                            <td>{{$download_data->tmp_osImage}}</td>
                            <td>{{$download_data->tmp_crc}}</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-{{$download_data->tmp_no}}" {{$download_data->tmp_status != 1 ? '' : 'disabled'}}>Approve</button></td>
                        </tr>
                        @if( $download_data->tmp_status != 1 )
                            <div class="modal fade" id="modal-{{$download_data->tmp_no}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form style="display:none" action="/confirmDownload" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Warning</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>You are about to approve <b>{{$download_data->tmp_title}}</b> to online system.</p><p> Please make sure the data is correct before confirming.</p>
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
                                                <input type="hidden" name="tmp_releasedate" value="{{$download_data->tmp_releasedate}}">
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
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Confirm</button>
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
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_title', 'order' => $order == 'ASC' && $orderby == 'tmp_title' ? 'DESC' : 'ASC'])}}">Title<i class="{{$orderby == 'tmp_title' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_marketing_name', 'order' => $order == 'ASC' && $orderby == 'tmp_marketing_name' ? 'DESC' : 'ASC'])}}">Marketing Name<i class="{{$orderby == 'tmp_marketing_name' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_prd_model_name', 'order' => $order == 'ASC' && $orderby == 'tmp_prd_model_name' ? 'DESC' : 'ASC'])}}">Model Name<i class="{{$orderby == 'tmp_prd_model_name' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_device', 'order' => $order == 'ASC' && $orderby == 'tmp_device' ? 'DESC' : 'ASC'])}}">Device<i class="{{$orderby == 'tmp_device' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_version', 'order' => $order == 'ASC' && $orderby == 'tmp_version' ? 'DESC' : 'ASC'])}}">Version<i class="{{$orderby == 'tmp_version' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_packageVersion', 'order' => $order == 'ASC' && $orderby == 'tmp_packageVersion' ? 'DESC' : 'ASC'])}}">Package Version<i class="{{$orderby == 'tmp_packageVersion' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_os', 'order' => $order == 'ASC' && $orderby == 'tmp_os' ? 'DESC' : 'ASC'])}}">OS<i class="{{$orderby == 'tmp_os' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_osImage', 'order' => $order == 'ASC' && $orderby == 'tmp_osImage' ? 'DESC' : 'ASC'])}}">OS Image<i class="{{$orderby == 'tmp_osImage' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('data', ['status'=>$status, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'tmp_crc', 'order' => $order == 'ASC' && $orderby == 'tmp_crc' ? 'DESC' : 'ASC'])}}">CRC<i class="{{$orderby == 'tmp_crc' ? $order : ''}}"></i></a></th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
                {{ $data->links('vendor.pagination.bootstrap-4') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection