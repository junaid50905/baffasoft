@extends('layouts.app')


@section('page-title', __('Allocate Leave'))
@section('page-heading', __('Allocate Leave'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Allocate Leave')
    </li>
@stop

@section('content')

    @include('partials.messages')


    @if ($allocated_leave)
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
                                        <td>{{ $allocated_leave->casual_leave_allowed }}</td>
                                        <td>{{ $allocated_leave->casual_leave_enjoyed }}</td>
                                        <td>{{ $allocated_leave->casual_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sick Leave</td>
                                        <td>{{ $allocated_leave->sick_leave_allowed }}</td>
                                        <td>{{ $allocated_leave->sick_leave_enjoyed }}</td>
                                        <td>{{ $allocated_leave->sick_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Annual Leave</td>
                                        <td>{{ $allocated_leave->annual_leave_allowed }}</td>
                                        <td>{{ $allocated_leave->annual_leave_enjoyed }}</td>
                                        <td>{{ $allocated_leave->annual_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Paternity Leave</td>
                                        <td>{{ $allocated_leave->paternity_leave_allowed }}</td>
                                        <td>{{ $allocated_leave->paternity_leave_enjoyed }}</td>
                                        <td>{{ $allocated_leave->paternity_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Maternity Leave</td>
                                        <td>{{ $allocated_leave->maternity_leave_allowed }}</td>
                                        <td>{{ $allocated_leave->maternity_leave_enjoyed }}</td>
                                        <td>{{ $allocated_leave->maternity_leave_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>Special Leave</td>
                                        <td>-</td>
                                        <td>{{ $allocated_leave->special_leave_enjoyed }}</td>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('allocate.leave.store', $userId) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-2 mx-1">
                                    <div class="form-group">
                                        <label>Casual Leave</label>
                                        <input type="text" value="10" name="casual_leave_allowed">
                                    </div>
                                </div>
                                <div class="col-md-2 mx-1">
                                    <div class="form-group">
                                        <label>Sick Leave</label>
                                        <input type="text" value="14" name="sick_leave_allowed">
                                    </div>
                                </div>
                                <div class="col-md-2 mx-2">
                                    <div class="form-group">
                                        <label>Annual Leave</label>
                                        <input type="text" value="18" name="annual_leave_allowed">
                                    </div>
                                </div>
                                <div class="col-md-2 mx-2">
                                    <div class="form-group">
                                        <label>Maternity Leave</label>
                                        <input type="text" value="0" name="maternity_leave_allowed">
                                    </div>
                                </div>
                                <div class="col-md-2 mx-2">
                                    <div class="form-group">
                                        <label>Paternity Leave</label>
                                        <input type="text" value="14" name="paternity_leave_allowed">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
