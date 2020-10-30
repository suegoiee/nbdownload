@section('home-menu', 'menu-open')
@section('home-href', 'active')
@section('all_data', 'active')

@extends('layouts.base')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>All Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Data</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Data From RD System</h3>
                <!-- SEARCH FORM -->
                <form class="form-inline ml-3" style="position: absolute; right: 15px;">
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
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Title</th>
                    <th>Marketing Name</th>
                    <th>Model Name</th>
                    <th>Device</th>
                    <th>Version</th>
                    <th>Package Version</th>
                    <th>OS</th>
                    <th>OS Image</th>
                    <th>CRC</th>
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
                        </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Title</th>
                    <th>Marketing Name</th>
                    <th>Model Name</th>
                    <th>Device</th>
                    <th>Version</th>
                    <th>Package Version</th>
                    <th>OS</th>
                    <th>OS Image</th>
                    <th>CRC</th>
                  </tr>
                  </tfoot>
                </table>
                {{ $data->links('vendor.pagination.bootstrap-4') }}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection