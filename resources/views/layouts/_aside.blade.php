  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home.index')}}" class="brand-link">
      <img src="{{asset('storage/img/msi-logo.png')}}" alt="MSI Logo" class="brand-image img-circle elevation-3" style="opacity: 1">
      <span class="brand-text font-weight-light">NB Download System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <a href="/user/profile" class="d-block">
          <div class="image">
            <img src="{{asset('storage/img/notebook-team-logo.png')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="/user/profile" class="d-block">{{Auth::user()->name}}</a>
          </div>
        </a>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview @yield('home-menu')">
            <a href="{{route('home.index')}}" class="nav-link @yield('home-href')">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('home.index')}}" class="nav-link @yield('download_tmp')">
                  <i class="fas fa-folder-open nav-icon"></i>
                  <p>Local Download Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('downloadListOnline.show', ['keyword'=>'last-data', 'amount' => '15', 'orderby' => 'download_id', 'order' => 'DESC', 'page' => 1])}}" class="nav-link @yield('download_online')">
                  <i class="fas fa-globe nav-icon"></i>
                  <p>Online Download Data</p>
                </a>
              </li>
              @can('admin')
                <li class="nav-item">
                  <a href="{{route('productList.show', ['keyword'=>'all-data', 'amount' => '15', 'orderby' => 'product_id', 'order' => 'ASC', 'page' => 1])}}" class="nav-link @yield('products')">
                    <i class="fas fa-calendar-check nav-icon"></i>
                    <p>Products</p>
                  </a>
                </li>
              @endcan
            </ul>
          </li>
          <li class="nav-item">
            <form id="logout" action="{{route('logout')}}" method="POST">
              @csrf
              <a href="javascript:{}" onclick="document.getElementById('logout').submit();" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>