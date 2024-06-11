<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hikvision Kokand</title>
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" />
</head>
<body>
<div class="wrapper">
    <div class="title"><span>Hikvision Kokand</span></div>
    <form action="{{ route('login') }}" method="post" style="margin-bottom: 20px;">
        @csrf
        <div class="row">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required />
        </div>
        <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required />
        </div>
        <div class="row button">
            <input type="submit" value="Login" />
        </div>
    </form>
</div>
</body>
</html>
