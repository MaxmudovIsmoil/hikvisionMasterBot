<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.2/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/datatable/dataTables.bootstrap5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/datatable/jquery.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15/css/all.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <div>
        <div class="topBar">
            <div class="logo">
                <img src="{{ asset('assets/images/logo-black.png') }}" alt="Logo">
            </div>
            <div class="search search-div">
                <input type="text" name="search" placeholder="Qidirish...">
                <label for="search"><i class="fas fa-search"></i></label>
            </div>
            <i class="fas fa-bell"></i>
            <div class="user user-div">
                <img class="dropdown-toggle" src="{{ asset('assets/images/user.png') }}" alt="Admin">
            </div>

        </div>
        <div class="sidebar">
            <ul class="sidebar-ul">
                <li class="@if(Request::is('dashboard')) active @endif">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-th-large"></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="@if(Request::is('install')) active @endif">
                    <a href="{{ route('install.index') }}">
                        <i class="fas fa-stream"></i>
                        <div>установка</div>
                    </a>
                </li>
                <li class="@if(Request::is('service')) active @endif">
                    <a href="{{ route('service.index') }}">
                        <i class="fas fa-layer-group"></i>
                        <div>Servis</div>
                    </a>
                </li>
                <li class="@if(Request::is('group')) active @endif">
                    <a href="{{ route('group.index') }}">
                        <i class="fas fa-group"></i>
                        <div>Guruh</div>
                    </a>
                </li>
                <li class="@if(Request::is('master')) active @endif">
                    <a href="{{ route('master.index') }}">
                        <i class="fas fa-users"></i>
                        <div>Hodimlar</div>
                    </a>
                </li>
                <li class="@if(Request::is('report')) active @endif">
                    <a href="{{ route('report') }}">
                        <i class="fas fa-chart-bar"></i>
                        <div>Hisobot</div>
                    </a>
                </li>
                <li class="@if(Request::is('group-ball')) active @endif">
                    <a href="{{ route('groupBall') }}">
                        <i class="fas fa-balance-scale"></i>
                        <div>Guruh bal</div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery3.7.min.js') }}"></script>
    <script src="{{ asset('assets/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-5.0.2/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-5.0.2/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/jquery.dataTables.min.js') }}"></script>
    @yield('script')
</body>
</html>
