<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>JCS</title>
    <link rel="shortcut icon" href="{{Config::get('app.url') . '/public/backend/images/logo/favicon.ico'}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/app.css'}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.css">

    <link href="{{Config::get('app.url').'/public/dashboard/styles/shards-dashboards.1.1.0.min.css'}}"
        rel="stylesheet">
    <link rel="stylesheet"
        href="{{Config::get('app.url').'/public/dashboard/styles/extras.1.1.0.min.css'}}">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/vue-multiselect.min.css'}}">
    {{-- <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/my_login_css.css'}}"> --}}
    @include('backend.layouts.js_variable')
</head>

<body>
    <div class="container-fluid" id="app"></div>
    <script type="text/javascript">
        @auth
          window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
       @else
          window.Permissions = [];
       @endauth
    </script>
    <script src="{{Config::get('app.url').'/public/js/app.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/js/jquery-3.5.1.min.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/dashboard/scripts/Chart.min.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/dashboard/scripts/shards-dashboards.1.1.0.min.js'}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="{{Config::get('app.url').'/public/dashboard/scripts/extras.1.1.0.min.js'}}"></script>
</body>

</html>