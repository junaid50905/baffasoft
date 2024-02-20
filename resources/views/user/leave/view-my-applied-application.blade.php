@php
    use Vanguard\User;
@endphp

@extends('layouts.app')


@section('page-title', __('My applied application'))
@section('page-heading', __('My applied application'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Leave / My application')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Approved Days : {{ $approvedMyLeave->approved_days }}</h4>
                    <p class="m-1"><b>Casual Leave :</b>{{ $approvedMyLeave->casual_leave }}</p>
                    <p class="m-1"><b>Sick Leave :</b>{{ $approvedMyLeave->sick_leave }}</p>
                    <p class="m-1"><b>Annual Leave :</b>{{ $approvedMyLeave->annual_leave }}</p>
                    <p class="m-1"><b>Maternity Leave :</b>{{ $approvedMyLeave->maternity_leave }}</p>
                    <p class="m-1"><b>Paternity Leave :</b>{{ $approvedMyLeave->paternity_leave }}</p>
                    <p class="m-1"><b>Special Leave :</b>{{ $approvedMyLeave->special_leave }}</p>
                    <p class="m-1"><b>Annual Leave alpecial Leave :</b>{{ $approvedMyLeave->annual_leave_total }}</p>
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
