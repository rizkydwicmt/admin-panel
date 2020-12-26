@section('sidebar-header')
    <img src="{{ asset('/assets/images/logo.svg') }}" alt="" srcset="">
@endsection

@section('sidebar-menu')

    <ul class="menu">
        
        <li class='sidebar-title'>Main Menu</li>

        <li class="sidebar-item {{ Request::is('akses_admin') ? 'active' : '' }} ">
        <a href="{{ url('akses_admin') }}" class='sidebar-link'>
                <i data-feather="home" width="20"></i> 
                <span>Dashboard</span>
            </a>
        </li>

        <li class="
            sidebar-item  has-sub 
            {{ Request::is('akses_admin/list_user') ? 'active' : '' }} 
            {{ Request::is('akses_admin/kelola_user') ? 'active' : '' }}
        ">
            <a href="#" class='sidebar-link'>
                <i data-feather="layers" width="20"></i> 
                <span>Penjadwalan</span>
            </a>
            
            <ul class="
                submenu 
                {{ Request::is('akses_admin/list_user') ? 'active' : '' }} 
                {{ Request::is('akses_admin/kelola_user') ? 'active' : '' }}
            ">
                <li style="
                    {{ 
                        Request::is('akses_admin/list_user') ? 'color: #96d4f9;border-right: solid;' : '' 
                    }} 
                ">
                    <a href="{{ url('akses_admin/list_user') }}">List penjadwalan</a>
                </li>
                <li style="
                    {{ 
                        Request::is('akses_admin/kelola_user') ? 'color: #96d4f9;border-right: solid;' : '' 
                    }} 
                ">
                    <a href="{{ url('akses_admin/kelola_user') }}">Kelola penjadwalan</a>
                </li>
            </ul>
        </li>

@endsection

@section('navbar')

    <nav class="navbar navbar-header navbar-expand navbar-light">
        <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
        <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <div class="avatar mr-1">
                            <img src="{{ asset('/assets/images/avatar/avatar-s-1.png') }}" alt="" srcset="">
                        </div>
                        <div class="d-none d-md-block d-lg-inline-block">Hi, {{Session::get('nama')}}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                        <a class="dropdown-item" href="#"><i data-feather="mail"></i> Messages</a>
                        <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/akses_admin/Logout') }}"><i data-feather="log-out"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

@endsection