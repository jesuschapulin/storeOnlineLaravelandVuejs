<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Store</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('kit/fontawesome-free-5.0.13/web-fonts-with-css/css/fontawesome-all.css')}}">
    </head>
    <body>
        <div class="container-fluid" style="background-color: white; margin: 0; padding: 0; height: 39rem;">
            <div id="app" style="margin: 0; padding: 0; height: 100%;">
                <barra></barra>
                <router-view></router-view>
                @yield('content')
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</html>