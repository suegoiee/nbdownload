@section('user-management-href', 'active')
@section('user-management', 'active')
@section('title', 'User Management')

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
  </style>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="page-title">User Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
              <li class="breadcrumb-item active">User Management</li>
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
                <h3 class="card-title">User Management</h3>
                <form class="form-inline ml-3 table-title">
                    <input type="hidden" id="csrf" value="{{csrf_token()}}">
                    <div class="input-group input-group-sm">
                        <p>show &nbsp</p>
                        <select class="form-control" name="country" onchange="location = this.value;">
                            <option value="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => '5', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 5 ? 'selected' : ''}}>5</option>
                            <option value="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => '15', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 15 ? 'selected' : ''}}>15</option>
                            <option value="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => '50', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 50 ? 'selected' : ''}}>50</option>
                            <option value="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => '100', 'orderby' => $orderby, 'order' => $order])}}" {{$amount == 100 ? 'selected' : ''}}>100</option>
                        </select>
                        <p>&nbsp data per page</p>
                        <a href="{{route('register')}}"><button type="button" class="btn btn-primary table-control-button">Create User</button></a>
                        <a href="{{route('userManage.export', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => $orderby, 'order' => $order])}}{{ app('request')->input('page') != null ? '?page='.app('request')->input('page') : ''}}"><button type="button" class="btn btn-danger table-control-button">Export CSV</button></a>
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
                    <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'id', 'order' => $order == 'ASC' && $orderby == 'id' ? 'DESC' : 'ASC'])}}">ID<i class="{{$orderby == 'id' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'name', 'order' => $order == 'ASC' && $orderby == 'name' ? 'DESC' : 'ASC'])}}">Name<i class="{{$orderby == 'name' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'email', 'order' => $order == 'ASC' && $orderby == 'email' ? 'DESC' : 'ASC'])}}">Email<i class="{{$orderby == 'email' ? $order : ''}}"></i></a></th>
                    <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'permission', 'order' => $order == 'ASC' && $orderby == 'permission' ? 'DESC' : 'ASC'])}}">Permission<i class="{{$orderby == 'permission' ? $order : ''}}"></i></a></th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($data as $user_data)
                          <tr>
                              <td>{{$user_data->id}}</td>
                              <td>{{$user_data->name}}</td>
                              <td>{{$user_data->email}}</td>
                              <td>{{config('global.permission_list')[$user_data->permission]}}</td>
                              <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-{{$user_data->id}}">Edit</button></td>
                          </tr>
                          <div class="modal fade" id="modal-{{$user_data->id}}">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <form action="{{route('userManage.changePermission')}}" method="POST" id="changePermission-{{$user_data->id}}">
                                          @csrf
                                          <div class="modal-header">
                                              <h4 class="modal-title">{{$user_data->name}}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <div class="form-group">
                                                <label>Permission : </label>
                                                <select name="permission" class="form-control select2" style="width: 100%;">
                                                    <option value="0" {{$user_data->permission == 0 ? 'selected' : ''}}>User</option>
                                                    <option value="1" {{$user_data->permission == 1 ? 'selected' : ''}}>Admin</option>
                                                    <option value="2" {{$user_data->permission == 2 ? 'selected' : ''}}>Super</option>
                                                    <option value="2" {{$user_data->permission == 10 ? 'selected' : ''}}>Super</option>
                                                </select>
                                              </div>
                                              <input type="hidden" name="id" value="{{$user_data->id}}">
                                          </div>
                                          <div class="modal-footer justify-content-between">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                                              <button type="submit" class="btn btn-primary" name="action" value="confirm">Confirm</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'id', 'order' => $order == 'ASC' && $orderby == 'id' ? 'DESC' : 'ASC'])}}">ID<i class="{{$orderby == 'id' ? $order : ''}}"></i></a></th>
                      <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'name', 'order' => $order == 'ASC' && $orderby == 'name' ? 'DESC' : 'ASC'])}}">Name<i class="{{$orderby == 'name' ? $order : ''}}"></i></a></th>
                      <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'email', 'order' => $order == 'ASC' && $orderby == 'email' ? 'DESC' : 'ASC'])}}">Email<i class="{{$orderby == 'email' ? $order : ''}}"></i></a></th>
                      <th><a href="{{route('userManage.show', ['keyword'=>$keyword, 'amount' => $amount, 'orderby' => 'permission', 'order' => $order == 'ASC' && $orderby == 'permission' ? 'DESC' : 'ASC'])}}">Permission<i class="{{$orderby == 'permission' ? $order : ''}}"></i></a></th>
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