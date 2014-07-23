<!DOCTYPE html>
<html class="y">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9,chrome=1">
    <meta name="author" content="{{ Config::get('website.author') }}">
    <meta name="keywords" content="{{ Config::get('website.keywords') }}">
    <meta name="description" content="{{ Config::get('website.description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-param" content="authenticity_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title or 'Hello, Laravel.' }}</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    {{ HTML::style('assets/application.css') }}
    <script src="http://remote.qiniudn.com/jquery.js"></script>
    <script src="http://remote.qiniudn.com/u.js"></script>
    <script src="http://remote.qiniudn.com/turbolinks.js"></script>
    {{ HTML::script('assets/application.js') }}
</head>
<body>
<div class="navbar">
    <div class="inner w970">
        <div class="logo">@include('util.logo')</div>
        <div class="tab left">
            <ul class="navtab"></ul>
        </div>
        <div class="tab right">@include('partial.navtab')</div>
    </div>
    <div class="spinner"></div>
</div>
<div class="master">
    <div class="inner w560">
        @yield('main')
    </div>
</div>
<script>
    $(document).on('page:fetch', function(){
        $('.spinner').fadeIn();
    });
    $(document).on('page:change', function(){
        $('.spinner').fadeOut();
    });
    $(document).on('page:restore', function(){
        $('.spinner').hide();
    });
</script>
</body>
</html>
