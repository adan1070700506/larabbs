<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <mate charset="utf-8" >
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--CSRF token-->
        <mate name="csrf_toke" content="{{ csrf_token() }}">
        <title>@yield('title','larabbs')</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="{{ route_class() }}-page">
            @include('layouts._header')
            <div class="container">
                @include('layouts._message')
                @yield('content')
            </div>
            @include('layouts._footer')
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>