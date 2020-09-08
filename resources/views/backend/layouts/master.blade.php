<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>JCS</title>
    <link rel="shortcut icon" href="{{Config::get('app.url') . '/public/backend/images/logo/favicon.ico'}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/app.css'}}">
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/flag-icon.css'}}">
    <link href="{{Config::get('app.url').'/public/dashboard/styles/shards-dashboards.1.1.0.min.css'}}" rel="stylesheet">
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/dashboard/styles/extras.1.1.0.min.css'}}">
    <script src="{{Config::get('app.url').'/public/js/buttons.js'}}"></script>
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/vue-multiselect.min.css'}}">
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/canvas_css.css'}}">
    @include('backend.layouts.js_variable')
</head>

<body>
    <div class="container-fluid" id="app"></div>
    <b-modal size="lg" :hide-backdrop="true" @ok="signinUser($event)" :title="table_col_modal_title"
        v-model="table_col_modal_setting">

        <div v-html="table_col_setting_list"></div>
    </b-modal>
    <script type="text/javascript">
    @auth
    window.Permissions = {!!json_encode(Auth::user()->allPermissions, true) !!};
    @else
        window.Permissions = [];
    @endauth
    </script>
    <script src="{{Config::get('app.url').'/public/js/app.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/js/jquery-3.5.1.min.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/dashboard/scripts/Chart.min.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/dashboard/scripts/shards-dashboards.1.1.0.min.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/js/jquery.sharrre.min.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/dashboard/scripts/extras.1.1.0.min.js'}}"></script>
    <script src="{{Config::get('app.url').'/public/js/printThisLibrary/printThis.js'}}"></script>
</body>

</html>