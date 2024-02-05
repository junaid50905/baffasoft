@extends('layouts.app')

{{--@section('page-title', trans('Registration'))--}}

@section('content')
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
@stop
@section('scripts')
    <script src="{{ url('js/app.js') }}"></script>
@stop

