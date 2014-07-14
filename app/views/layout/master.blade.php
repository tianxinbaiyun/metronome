<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9,chrome=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="author" content="{{ Config::get('website.author') }}">
    <title>{{ $title or 'Hello, Busker.' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ URL::to('favicon.ico') }}">
    {{ HTML::style('assets/application.css') }}
    {{ HTML::script('assets/application.js') }}
</head>
<body id="busker">
<div class="navbar">
    <div class="inner">
        <div id="logo">
            <a href="{{ url('/') }}">{{ Config::get('website.logo') }}<sup>{{ Config::get('website.version') }}</sup></a>
        </div>
        <div class="options pull_right">@include('partials.user.options')</div>
    </div>
</div>
<div class="master">
    <div class="grid">
        <div class="unit slim">@yield('sidebar')</div>
        <div class="unit fat">@yield('main')</div>
    </div>
</div>
<div class="footer">
    <p>{{ Config::get('website.copyright') }}</p>
</div>
</body>
</html>