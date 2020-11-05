<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> {{ config('app.name') }} - @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{asset('storage/img/msi-logo.png')}}" type="image/x-icon"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('storage/third-party/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('storage/third-party/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('storage/third-party/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('storage/css/adminLTE3.0.5/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- jQuery -->
  <script src="{{asset('storage/third-party/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="{{asset('storage/third-party/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('layouts._navbar')
    @include('layouts._aside')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  
  @include('layouts._footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 4 -->
<script src="{{asset('storage/third-party/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('storage/third-party/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('storage/third-party/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('storage/third-party/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('storage/third-party/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('storage/js/adminLTE3.0.5/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('storage/js/adminLTE3.0.5/demo.js')}}"></script>
</body>
</html>
