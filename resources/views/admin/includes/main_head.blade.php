<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{__('admin.admin_title')}}</title>
<!-- Bootstrap  Framework -->
<link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">
<!-- FontAwesome  Framework -->
<link rel="stylesheet" href="{{asset('admin/css/all.min.css')}}">
<!-- Calender  css -->
<link rel="stylesheet" href="{{asset('admin/css/calender.css')}}">
<!-- Custom  Style -->
<link rel="stylesheet" href="{{asset('admin/css/admin_style.css')}}">
<!-- if the current language is arabic: call arabic font and rtl style -->
@if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('admin/css/style_rtl.css')}}">
@endif
<!-- if the current language is english: call english font and ltr style -->
@if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
    <!-- <link rel="icon" href="{{asset('admin/fonts/OpenSans/OpenSans.ttf')}}"> -->
    <link rel="stylesheet" href="{{asset('admin/css/style_ltr.css')}}">
@endif
<link rel="icon" href="{{asset('admin/images/logo.png')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

