<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title') - {{ setting('app_name') }}</title>

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('assets/img/icons/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('assets/img/icons/apple-touch-icon-152x152.png') }}" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ url('assets/img/icons/favicon-16x16.png') }}" sizes="16x16" />
    <meta name="application-name" content="{{ setting('app_name') }}"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ url('assets/img/icons/mstile-144x144.png') }}" />

{{--    <link media="all" type="text/css" rel="stylesheet" href="{{ url('assets/css/vendor.css') }}">--}}
    <link media="all" type="text/css" rel="stylesheet" href="{{ url('assets/css/app.css') }}">

    @yield('styles')

    @hook('app:styles')

    {{--    <link media="all"--}}
    {{--          type="text/css"--}}
    {{--          rel="stylesheet"--}}
    {{--          href="{{ url('vendor/plugins/announcements/css/announcements.css') }}">--}}
</head>
<body>
{{--@include('partials.navbar')--}}

<div class="container-fluid">
{{--    <div class="row">--}}
        {{--        @include('partials.sidebar.main')--}}

{{--        <div class="content-page">--}}
            <main role="main">
                @if (Auth::check())
                    @php
                        $user_auth_data = [
                            'isLoggedin' => true,
                            'user' =>  Auth::user()
                        ];
                    @endphp
                @else
                    @php
                        $user_auth_data = [
                            'isLoggedin' => false
                        ];
                    @endphp
                @endif
                <script>
                    window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
                </script>
                <div id="app">
                    <router-view></router-view>
                </div>
                <style>
                    .sidebar-sticky {
                        overflow-y: hidden !important;
                        margin-bottom: 50px;
                    }
                </style>
            </main>
{{--        </div>--}}
{{--    </div>--}}
</div>

{{--<script src="{{ url('assets/js/vendor.js') }}"></script>--}}
{{--<script src="{{ url('assets/js/as/app.js') }}"></script>--}}
<script src="{{ url('js/app.js') }}"></script>

@hook('app:scripts')
</body>
</html>
