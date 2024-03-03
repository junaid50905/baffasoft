@php
    use Vanguard\User;
@endphp

@extends('layouts.app')


@section('page-title', __('View applied application'))
@section('page-heading', __('View application'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('View application')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <p class="m-0 badge badge-info">{{ $application->status }}</p>
                        <p class="m-0"><b>Leave Type:</b> {{ $application->leave_type }}</p>
                        <p class="m-0"><b>Leave From:</b> {{ $application->leave_from }}</p>
                        <p class="m-0"><b>Leave To:</b> {{ $application->leave_to }}</p>
                        <p class="m-0"><b>Leave Days:</b> {{ $application->leave_days }}</p>
                        <p class="m-0"><b>Purpose:</b> {{ $application->purpose }}</p>
                    </div>
                    <hr>

                    <div>
                        @php
                            $userId = DB::table('leave_applications')
                                ->where('id', $application->id)
                                ->first()->user_id;
                            $leaves = DB::table('leave_approves')
                                ->where('leave_application_id', $application->id)
                                ->where('user_id', $userId)
                                ->get();
                        @endphp

                        @if ($application->status === 'pending')
                            <form action="{{ route('store.applied.application', $application->id) }}" method="POST">
                                @csrf
                                <div class="row my-2">
                                    <div class="col-md-6">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Leave Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (range(1, $application->leave_days) as $day)
                                                    <tr>
                                                        <td>
                                                            @php
                                                                $date = \Carbon\Carbon::createFromFormat(
                                                                    'Y-m-d',
                                                                    $application->leave_from,
                                                                )
                                                                    ->addDays($day - 1)
                                                                    ->format('Y-m-d');
                                                            @endphp
                                                            <input type="text" name="date[]" value="{{ $date }}"
                                                                readonly>
                                                        </td>
                                                        <td>
                                                            <select name="leave_type[]">
                                                                <option value="Casual Leave"
                                                                    {{ $leaveAllowcation->casual_leave_allowed == 0 ? 'disabled' : '' }}>
                                                                    Casual Leave</option>
                                                                <option value="Sick Leave"
                                                                    {{ $leaveAllowcation->sick_leave_allowed == 0 ? 'disabled' : '' }}>
                                                                    Sick Leave</option>
                                                                <option value="Annual Leave"
                                                                    {{ $leaveAllowcation->annual_leave_allowed == 0 ? 'disabled' : '' }}>
                                                                    Annual Leave</option>
                                                                <option value="Paternity Leave"
                                                                    {{ $leaveAllowcation->paternity_leave_allowed == 0 ? 'disabled' : '' }}>
                                                                    Paternity Leave</option>
                                                                <option value="Maternity Leave"
                                                                    {{ $leaveAllowcation->maternity_leave_allowed == 0 ? 'disabled' : '' }}>
                                                                    Maternity Leave</option>
                                                                <option value="Special Leave">Special Leave</option>
                                                                <option value="Annual Total Leave"
                                                                    {{ $leaveAllowcation->annual_leave_total == 0 ? 'disabled' : '' }}>
                                                                    Annual Total Leave</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6 border-left">
                                        <div>
                                            <p><b>Leave Balance Summary:</b></p>
                                            <ul>
                                                <li>Casual Leave Balance: {{ $leaveAllowcation->casual_leave_balance }}
                                                </li>
                                                <li>Sick Leave Balance: {{ $leaveAllowcation->sick_leave_balance }}</li>
                                                <li>Annual Leave Balance: {{ $leaveAllowcation->annual_leave_balance }}
                                                </li>
                                                <li>Maternity Leave Balance:
                                                    {{ $leaveAllowcation->maternity_leave_balance }}
                                                </li>
                                                <li>Paternity Leave Balance:
                                                    {{ $leaveAllowcation->paternity_leave_balance }}
                                                </li>
                                                <li>Annual Leave Total Balance:
                                                    {{ $leaveAllowcation->annual_leave_total_balance }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm" type="submit" value="approved"
                                    name="application_status">Save</button>
                                <button class="btn btn-danger btn-sm" type="submit" value="declined"
                                    name="application_status">Decline</button>
                            </form>
                        @elseif($application->status === 'approved')
                            <h5>Leave approved dates: </h5>
                            @foreach ($leaves as $leave)
                                <div>
                                    <p class="m-1">{{ $leave->date }}: {{ $leave->leave_type }}</p>
                                </div>
                            @endforeach
                        @elseif($application->status === 'declined')
                            <p class="text-danger">Your leave application has been declined</p>
                        @endif




                    </div>

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
