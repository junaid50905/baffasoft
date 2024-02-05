@extends('layouts.front')
@section('content')
{{--    <h1>User - {{auth()->guard('front')->user()}}</h1>--}}
{{--    <meta name="user-id" content="{{ Auth::guard('front')->user()->id }}">--}}
    @if (Auth::guard('front')->check())
        @php
            $user_auth_data = [
                'isLoggedin' => true,
                'user' =>  Auth::guard('front')->user()
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
        // console.log('Hy');
    </script>

    <div id="app">
        <router-view></router-view>
    </div>
@stop
@section('scripts')
    <script src="{{ url('js/app.js') }}"></script>
@stop

