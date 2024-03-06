@php
    use Vanguard\User;
@endphp
@extends('layouts.app')


@section('page-title', __('Attendance summary report'))
@section('page-heading', __('Attendance summary report'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Attendacne / Attendance report')
    </li>
@stop

@section('content')

    @include('partials.messages')
    

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('attendance.report.summary.store') }}" method="POST">
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
