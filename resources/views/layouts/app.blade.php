<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
{{--    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.2/css/bootstrap.min.css') }}"/>--}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15/css/all.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body>
<div class="container1-fluid">
    <div class="topbar">
        <div class="logo">
            <img src="{{ asset('assets/images/logo-black.png') }}" alt="Logo">
        </div>
        <div class="search search-div">
            <input type="text" name="search" placeholder="Qidirish...">
            <label for="search"><i class="fas fa-search"></i></label>
        </div>
        <i class="fas fa-bell"></i>
        <div class="user user-div">
            <img src="{{ asset('assets/images/user.png') }}" alt="">
        </div>
    </div>
    <div class="sidebar">
        <ul class="sidebar-ul">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-th-large"></i>
                    <div>Dashboard</div>
                </a>
            </li>
            <li>
                <a href="{{ route('master.index') }}">
                    <i class="fas fa-users"></i>
                    <div>Ustalar</div>
                </a>
            </li>
            <li>
                <a href="{{ route('work.index') }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <div>Ishlar</div>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-delicious"></i>
                    <div>Ish turlari</div>
                </a>
            </li>
            <li>
                <a href="{{ route('report') }}">
                    <i class="fas fa-chart-bar"></i>
                    <div>Analytics</div>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-hand-holding-usd"></i>
                    <div>Earnings</div>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <div>Settings</div>
                </a>
            </li>
        </ul>
    </div>
    <div class="main">
        @yield('content')
    </div>
</div>
<script src="{{ asset('assets/js/jquery3.7.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap-5.0.2/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/chart.min.js') }}"></script>
<script src="{{ asset('assets/js/chart1.js') }}"></script>
<script src="{{ asset('assets/js/chart2.js') }}"></script>
</body>

</html>
