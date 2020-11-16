@section('log-href', 'active')
@section('log', 'active')
@section('title', 'Logs')

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
    .page-title{
      position: relative; 
      float: left;
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
                <h1 class="page-title">Log Data</h1>
                <form class="form-inline ml-3 page-title">
                    <div class="input-group input-group-sm">
                        <p>log date &nbsp</p>
                        <select class="form-control">
                            <option value="{{route('log.show', ['date'=>'202011', 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}" {{$date == '202011' ? 'selected' : ''}}>202011</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Log Data</li>
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
                        <h3 class="card-title">Log Data</h3>
                        <form class="form-inline ml-3 table-title">
                            <input type="hidden" id="csrf" value="{{csrf_token()}}">
                            <div class="input-group input-group-sm">
                                <p>show &nbsp</p>
                                <select class="form-control" name="country" onchange="location = this.value;">
                                    <option value="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => '5', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 5 ? 'selected' : ''}}>5</option>
                                    <option value="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => '15', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 15 ? 'selected' : ''}}>15</option>
                                    <option value="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => '50', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 50 ? 'selected' : ''}}>50</option>
                                    <option value="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => '100', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 100 ? 'selected' : ''}}>100</option>
                                </select>
                                <p>&nbsp data per page</p>
                                <a href="{{route('log.export', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}{{ app('request')->input('page') != null ? '?page='.app('request')->input('page') : ''}}"><button type="button" class="btn btn-danger table-control-button">Export CSV</button></a>
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
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_action', 'order' => $order == 'ASC' && $orderby == 'log_action' ? 'DESC' : 'ASC'])}}">Action<i class="{{$orderby == 'log_action' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_ip', 'order' => $order == 'ASC' && $orderby == 'log_ip' ? 'DESC' : 'ASC'])}}">IP<i class="{{$orderby == 'log_ip' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_user_id', 'order' => $order == 'ASC' && $orderby == 'log_user_id' ? 'DESC' : 'ASC'])}}">User ID<i class="{{$orderby == 'log_user_id' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_create', 'order' => $order == 'ASC' && $orderby == 'log_create' ? 'DESC' : 'ASC'])}}">Create Date<i class="{{$orderby == 'log_create' ? $order : ''}}"></i></a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $log)
                                    <tr>
                                        <td>{{$log->log_action}}</td>
                                        <td>{{$log->log_ip}}</td>
                                        <td>{{$log->log_user_id}}</td>
                                        <td>{{$log->log_create}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_action', 'order' => $order == 'ASC' && $orderby == 'log_action' ? 'DESC' : 'ASC'])}}">Action<i class="{{$orderby == 'log_action' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_ip', 'order' => $order == 'ASC' && $orderby == 'log_ip' ? 'DESC' : 'ASC'])}}">IP<i class="{{$orderby == 'log_ip' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_user_id', 'order' => $order == 'ASC' && $orderby == 'log_user_id' ? 'DESC' : 'ASC'])}}">User ID<i class="{{$orderby == 'log_user_id' ? $order : ''}}"></i></a></th>
                                    <th><a href="{{route('log.show', ['date'=>$date, 'keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'log_create', 'order' => $order == 'ASC' && $orderby == 'log_create' ? 'DESC' : 'ASC'])}}">Create Date<i class="{{$orderby == 'log_create' ? $order : ''}}"></i></a></th>
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