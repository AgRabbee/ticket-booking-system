
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('AdminLTE/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Ticket Booking System</span>
    </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                       alt="User Image">
              </div>
              <div class="info">
                  <a href="{{ url('/dashboard/users/'.Auth::user()->id) }}"
                     class="d-block">{{ ucfirst(Auth::user()->first_name) . ' ' . ucfirst(Auth::user()->last_name)}}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
                       with font-awesome or any other icon font library -->

                  <li class="nav-item">
                      <a href="{{ url('dashboard') }}" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>Dashboard</p>
                      </a>
                  </li>

                  <li class="nav-header">System Users</li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-users"></i>
                          <p>
                              Users
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ url('/dashboard/users') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Users</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon far fa-building"></i>
                          <p>
                              Company
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/dashboard/admins" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Company Admins</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-header">Trips</li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-location-arrow"></i>
                          <p>
                              Trips
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ url('/dashboard/all/trips') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Trips</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-header">Transports</li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fa fa-bus"></i>
                          <p>
                              Transports
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ url('/dashboard/all/transport_type') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>All Transports Type</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('/dashboard/add/transport_type') }}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New Type</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-header">Reports</li>
                  <li class="nav-item has-treeview">
                      <a href="{{ url('/dashboard/sales/reports') }}" class="nav-link">
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
