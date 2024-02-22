@php

    use Vanguard\LeaveAllocation;

    use Carbon\Carbon;

    $minDate = Carbon::today()->subDays(7)->format('Y-m-d');
    $maxDate = Carbon::today()->addDays(7)->format('Y-m-d');

@endphp

@extends('layouts.app')


@section('page-title', __('Apply for leave'))
@section('page-heading', __('Apply leave'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Leave / Apply')
    </li>
@stop

@section('content')

    @include('partials.messages')


    @php
        $user = auth()->user()->id;
    @endphp

    @if (LeaveAllocation::where('user_id', $authUserId)->exists())
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        @if (Session::has('already_leaved'))
                            <p class="text-danger"></p>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ Session('already_leaved') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="{{ route('leave.store', $user) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Manager <abbr class="text-danger">*</abbr></label>
                                        <select name="manager_id" class="form-control">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }}
                                                    {{ $user->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Leave Type <abbr class="text-danger">*</abbr></label>
                                        <select name="leave_type" class="form-control">
                                            <option value="Casual Leave">Casual Leave</option>
                                            <option value="Sick Leave">Sick Leave</option>
                                            <option value="Annual Leave">Annual Leave</option>
                                            <option value="Maternity Leave" {{ $allowedLeave->maternity_leave_allowed == 0 ? 'disabled' : '' }}>Maternity Leave</option>
                                            <option value="Paternity Leave" {{ $allowedLeave->paternity_leave_allowed == 0 ? 'disabled' : '' }}>Paternity Leave</option>
                                            <option value="Annual Leave Total">Annual Leave Total</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From <abbr class="text-danger">*</abbr></label>
                                        <input name="leave_from" type="date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To <abbr class="text-danger">*</abbr></label>
                                        <input name="leave_to" type="date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Purpose <abbr class="text-danger">*</abbr></label>
                                        <textarea name="purpose" id="" cols="30" rows="3" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-success" type="submit">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h5>Leave Summary</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Leave Type</th>
                                        <th scope="col">Allowed</th>
                                        <th scope="col">Enjoyed</th>
                                        <th scope="col">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Casual Leave</td>
                                        <td>{{ $allowedLeave->casual_leave_allowed }}</td>
                                        <td>{{ $allowedLeave->casual_leave_enjoyed }}</td>
                                        <td>{{ $allowedLeave->casual_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sick Leave</td>
                                        <td>{{ $allowedLeave->sick_leave_allowed }}</td>
                                        <td>{{ $allowedLeave->sick_leave_enjoyed }}</td>
                                        <td>{{ $allowedLeave->sick_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Annual Leave</td>
                                        <td>{{ $allowedLeave->annual_leave_allowed }}</td>
                                        <td>{{ $allowedLeave->annual_leave_enjoyed }}</td>
                                        <td>{{ $allowedLeave->annual_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Paternity Leave</td>
                                        <td>{{ $allowedLeave->paternity_leave_allowed }}</td>
                                        <td>{{ $allowedLeave->paternity_leave_enjoyed }}</td>
                                        <td>{{ $allowedLeave->paternity_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Maternity Leave</td>
                                        <td>{{ $allowedLeave->maternity_leave_allowed }}</td>
                                        <td>{{ $allowedLeave->maternity_leave_enjoyed }}</td>
                                        <td>{{ $allowedLeave->maternity_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Special Leave</td>
                                        <td>-</td>
                                        <td>{{ $allowedLeave->special_leave_enjoyed }}</td>
                                        <td>-
                                        <td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-danger">Leave is not set yet for you</p>
    @endif


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
