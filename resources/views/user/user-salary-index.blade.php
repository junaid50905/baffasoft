@php
    use Carbon\Carbon;
@endphp

@extends('layouts.app')


@section('page-title', __('User salary history'))
@section('page-heading', __('User salary history'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('User / Salary History')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p><b>Employee:{{$user->first_name}}</b></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Year & Month</th>
                                <th scope="col">Payable Salary</th>
                                <th scope="col">Total Deduction</th>
                                <th scope="col">Net Payment</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salaries as $salary)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ Carbon::createFromFormat('Y-m', $salary->paid_year_month)->format('M-y') }}</td>
                                    <td>{{ $salary->total_payable }}</td>
                                    <td>{{ $salary->total_deduction_after_change }}</td>
                                    <td>{{ $salary->net_payment }}</td>
                                    <td>
                                        <a href="{{ route('user.update.salary', [$user->id, $salary->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a class="btn btn-success btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
