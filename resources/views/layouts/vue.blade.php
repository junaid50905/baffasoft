<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        @yield('page-title') - {{ setting('app_name') }}
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
{!! HTML::style('front/assets/css/nucleo-icons.css') !!}
{!! HTML::style('front/assets/css/nucleo-svg.css') !!}
<!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    {!! HTML::style('front/assets/css/soft-ui-dashboard.css?v=1.0.3') !!}
</head>

<body class="">

@yield('content')
{!! HTML::script('front/assets/js/core/bootstrap.min.js') !!}
{!! HTML::script('front/assets/js/plugins/perfect-scrollbar.min.js') !!}
{!! HTML::script('front/assets/js/plugins/smooth-scrollbar.min.js') !!}
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
@yield('scripts')
@hook('member:scripts')
</body>

</html>
