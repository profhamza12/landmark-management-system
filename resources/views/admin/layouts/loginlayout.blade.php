<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/login.css')}}">
    <!-- if the current language is arabic: call arabic font and rtl style -->
    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
        <link rel="icon" href="{{asset('admin/fonts/DroidKufi/DroidKufi-Regular.ttf')}}">
        <link rel="stylesheet" href="{{asset('admin/css/style_rtl.css')}}">
    @endif
    <!-- if the current language is english: call english font and ltr style -->
    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
        <link rel="icon" href="{{asset('admin/fonts/OpenSans/OpenSans.ttf')}}">
        <link rel="stylesheet" href="{{asset('admin/css/style_ltr.css')}}">
    @endif
    <link rel="icon" href="{{asset('admin/images/logo.jpg')}}">
</head>
<body>
    @yield('content')
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
    @yield('validation')
    <script src="{{asset('admin/js/login.js')}}"></script>
</body>
</html>