<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biman Cargo Village</title>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
{{--    <link rel="stylesheet" href="css/style.css">--}}
    <link media="all" type="text/css" rel="stylesheet" href="{{ url('front/assets/css/gatepass-print-style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/fontawesome-all.min.css') }}" />
    <!-- <link rel="stylesheet" href="css/all.css"> -->
{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Antique+Soft&display=swap" rel="stylesheet">

{{--    <link rel="stylesheet" href="{{ url('front/assets/css/fontawesome.css') }}" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>--}}
{{--    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>--}}
</head>

<body>

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
<footer>
    <script src="{{ url('js/app.js') }}"></script>
</footer>
</body>
</html>





