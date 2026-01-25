
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/' )}}" class="brand-link">
      <img src="{{ asset('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Ticket Booking System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ url('/company/admin/profile') }}" class="d-block">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

           <li class="nav-item">
               <a href="{{ url('company/dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                 <p>Dashboard</p>
               </a>
           </li>


           <li class="nav-header">Routes</li>
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-route"></i>
              <p>
                Trips
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ml-3">
                  <a href="{{ url('/company/dashboard/all/trips') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Trips</p>
                  </a>
                </li>
                <li class="nav-item ml-3">
                <a href="{{ url('/company/dashboard/add/trip') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add New</p>
                </a>
                </li>
            </ul></li>

           <li class="nav-header">Transports</li>
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bus"></i>
              <p>
                Transports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item has-treeview ml-3">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All Transports<i class="right fas fa-angle-left"></i></p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item ml-3">
                          <a href="{{ url('/company/all/buses') }}" class="nav-link">
                            <i class="fa fa-bus nav-icon"></i>
                            <p>Buses</p>
                          </a>
                      </li>
                  </ul></li>
                <li class="nav-item ml-3">
                    <a href="{{ url('/company/add/transport') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add New Transports</p>
                    </a>
                </li>
            </ul></li>

            <li class="nav-header">Employees</li>
            <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-user"></i>
               <p>
                 Drivers
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item ml-3">
                   <a href="{{ url('/company/dashboard/all/drivers') }}" class="nav-link">
                     <i class="far fa-circle nav-icon"></i>
                     <p>All Drivers</p>
                   </a>
                 </li>
                 <li class="nav-item ml-3">
                 <a href="{{ url('/company/dashboard/add/driver') }}" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>Add New</p>
                 </a>
                 </li>
             </ul></li>

            <li class="nav-header">Sales</li>
            <li class="nav-item has-treeview">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-shopping-cart"></i>
               <p>
                 Sales
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
                 <li class="nav-item ml-3">
                   <a href="{{ url('/company/dashboard/all/sales') }}" class="nav-link">
                     <i class="far fa-circle nav-icon"></i>
                     <p>All Sales</p>
                   </a>
                 </li>
             </ul></li>

            <li class="nav-header">Reports</li>
            <li class="nav-item has-treeview">
             <a href="{{ url('/company/dashboard/sales/reports') }}" class="nav-link">
             <i class="nav-icon fas fa-chart-pie"></i>
               <p>
                 Sales Reports
               </p>
             </a></li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
