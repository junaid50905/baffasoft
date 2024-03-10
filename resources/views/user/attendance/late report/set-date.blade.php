@php
    use Vanguard\User;
@endphp
@extends('layouts.app')


@section('page-title', __('Late report'))
@section('page-heading', __('Late report'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Attendacne / Late report')
    </li>
@stop

@section('content')

    @include('partials.messages')


    @if (Session::has('attendance_report_date_miss_match'))
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>{{ Session('attendance_report_date_miss_match') }}</strong>
    </div>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('attendance.late.report.store') }}" method="POST" target="_blank">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label>From</label>
                                <input type="date" name="from_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>To</label>
                                <input type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-dark mt-2">See report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')


    {!! HTML::script('assets/js/as/btn.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest(
        'Vanguard\Http\Requests\User\UpdateProfileLoginDetailsRequest',
        '#login-details-form',
    ) !!}

    @if (setting('2fa.enabled'))
        {!! JsValidator::formRequest('Vanguard\Http\Requests\TwoFactor\EnableTwoFactorRequest', '#two-factor-form') !!}
    @endif
@stop
