<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.3.3/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/datepicker/gijgo.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/dataTables.bootstrap5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/datatable/jquery.dataTables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15/css/all.min.css') }}"/>
{{--    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jQueryUi.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    @stack('style')
</head>
<body>
    <div>
        <div class="topBar">
            <div class="logo">
                <img src="{{ asset('assets/images/logo-black.png') }}" alt="Logo"/>
            </div>
            <div class="search search-div">
{{--                <input type="text" name="search" placeholder="Qidirish...">--}}
{{--                <label for="search"><i class="fas fa-search"></i></label>--}}
            </div>
            <i class="fas fa-bell"></i>
            <div class="user-div">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <div class="user user-profile js_user_profile">
                    <img class="dropdown-toggle" src="{{ asset('assets/images/user.png') }}" alt="Admin">
                </div>
            </div>
            <ul class="ul-profile d-none">
                <li>
                    <a class="dropdown-item jsProfileBtn" href="javascript:void(0);">
                        <i class="fas fa-user-cog"></i> Parolni o'zgartirish
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();"
                        ><i class="fas fa-sign-out-alt"></i> Chiqish
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>

        </div>
        <div class="sidebar">
            <ul class="sidebar-ul">
                <li class="@if(Request::is('dashboard')) active @endif">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-th-large"></i>
                        <div>Bosh sahifa</div>
                    </a>
                </li>
                <li class="@if(Request::is('install')) active @endif">
                    <a href="{{ route('install.index') }}">
                        <i class="fas fa-project-diagram"></i>
                        <div>O'rnatishlar</div>
                    </a>
                </li>
                <li class="@if(Request::is('service')) active @endif">
                    <a href="{{ route('service.index') }}">
                        <i class="fas fa-users-cog"></i>
                        <div>Servislar</div>
                    </a>
                </li>
                <li class="@if(Request::is('group')) active @endif">
                    <a href="{{ route('group.index') }}">
                        <i class="fas fa-user-friends"></i>
                        <div>Guruhlar</div>
                    </a>
                </li>
                <li class="@if(Request::is('report')) active @endif">
                    <a href="{{ route('report') }}">
                        <i class="fas fa-chart-bar"></i>
                        <div>Hisobot</div>
                    </a>
                </li>
                <li class="@if(Request::is('master')) active @endif">
                    <a href="{{ route('master.index') }}">
                        <i class="fas fa-users"></i>
                        <div>Ustalar</div>
                    </a>
                </li>
                <li class="@if(Request::is('user')) active @endif">
                    <a href="{{ route('user.index') }}">
                        <i class="fas fa-user"></i>
                        <div>Hodimlar</div>
                    </a>
                </li>
                <li class="@if(Request::is('category-install')) active @endif">
                    <a href="{{ route('categoryInstall.index') }}">
                        <i class="fas fa-list-alt"></i>
                        <div>O'rnatish kategoyasi</div>
                    </a>
                </li>
                <li class="@if(Request::is('group-ball')) active @endif">
                    <a href="{{ route('groupBall') }}">
                        <i class="fas fa-coins"></i>
                        <div>Guruh bal va E'lonlar</div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            @yield('content')
        </div>

        @include('layouts.deleteModal')
        @include('layouts.profileModal')
        @include('layouts.successModal')
    </div>



    <script src="{{ asset('assets/js/jquery3.7.min.js') }}"></script>
    <script src="{{ asset('assets/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/datepicker/gijgo.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/dataTables.bootstrap5.min.js') }}"></script>

{{--    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>--}}
    <script src="{{ asset('assets/jquery-ui/jQueryUi.min.js') }}"></script>

    <script src="{{ asset('assets/js/profile.js') }}"></script>
    <script src="{{ asset('assets/js/delete_function.js') }}"></script>
    <script src="{{ asset('assets/js/functions.js') }}"></script>
    @stack('script')
</body>
</html>
