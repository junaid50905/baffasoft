@extends('layouts.vue')

{{--@section('page-title', trans('Registration'))--}}

@section('content')
    <div id="app">
        <router-view></router-view>

        {{--        <div class="myProjectPath">{{url('')}}</div>--}}
        {{--        <member-registration />--}}
{{--        <example-component />--}}
    </div>
@stop
@section('scripts')
        <script src="{{ url('js/app.js') }}"></script>
@stop

