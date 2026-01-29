<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span
                    class="dropdown-item dropdown-header">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name}}</span>
                <div class="dropdown-divider"></div>
                {{--@if (Auth::user()->roles[0]->name == 'Super Admin')
                    <a href="{{ url('/dashboard/users/'. Auth::user()->id) }}" class="dropdown-item">
                      <i class="fas fa-address-card mr-2"></i> Profile
                    </a>
                @elseif (Auth::user()->roles[1]->name == 'Admin')
                    <a href="{{ url('/company/dashboard/users/'. Auth::user()->id) }}" class="dropdown-item">
                      <i class="fas fa-address-card mr-2"></i> Profile
                    </a>
                @endif--}}

                <a href="{{ url('/dashboard/users/'. Auth::user()->id) }}" class="dropdown-item">
                    <i class="fas fa-address-card mr-2"></i> Profile
                </a>

                <div class="dropdown-divider"></div>
                <a href="{{ route('logOut') }}" class="dropdown-item"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
                </a>
                <form id="logout-form" action="{{ route('logOut') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
