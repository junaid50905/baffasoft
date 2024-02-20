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

                    <div>
                        <div class="text-center">
                            <span>Cl = Casual Leave ,</span>
                            <span>SL = Sick Leave ,</span>
                            <span>AL = Annual Leave ,</span>
                            <span>ML = Maternity Leave ,</span>
                            <span>PL = Paternity Leave ,</span>
                            <span>ALT = Annual Leave Leave ,</span>
                        </div>
                        <form action="{{ route('store.applied.application', $application->id) }}" method="POST">
                            @csrf
                            <input type="text" hidden name="leave_application_id" value="{{ $application->id }}">
                            <input type="text" hidden name="user_id" value="{{ $application->user_id }}">

                            <div class="row border p-2 m-2">
                                <div class="col-md-2">
                                    <label>CL</label>
                                    <input name="casual_leave" type="text"
                                        value="{{ $application->leave_type === 'Casual Leave' ? $application->leave_days : 0 }}"
                                        class="w-50">
                                </div>
                                <div class="col-md-2">
                                    <label>SL</label>
                                    <input name="sick_leave" type="text"
                                        value="{{ $application->leave_type === 'Sick Leave' ? $application->leave_days : 0 }}"
                                        class="w-50">
                                </div>
                                <div class="col-md-2">
                                    <label>AL</label>
                                    <input name="annual_leave" type="text"
                                        value="{{ $application->leave_type === 'Annual Leave' ? $application->leave_days : 0 }}"
                                        class="w-50">
                                </div>
                                <div class="col-md-2">
                                    <label>ML</label>
                                    <input name="maternity_leave" type="text"
                                        value="{{ $application->leave_type === 'Maternity Leave' ? $application->leave_days : 0 }}"
                                        class="w-50">
                                </div>
                                <div class="col-md-2">
                                    <label>PL</label>
                                    <input name="paternity_leave" type="text"
                                        value="{{ $application->leave_type === 'Paternity Leave' ? $application->leave_days : 0 }}"
                                        class="w-50">
                                </div>
                                <div class="col-md-2">
                                    <label>ALT</label>
                                    <input name="annual_leave_total" type="text"
                                        value="{{ $application->leave_type === 'Annual Leave Total' ? $application->leave_days : 0 }}"
                                        class="w-50">
                                </div>
                                <div class="col-md-2 mt-1">
                                    <label>Special Leave</label>
                                    <input name="special_leave" type="text" value="0" class="w-50">
                                </div>
                            </div>
                            @if ($application->status === 'pending')
                                <button class="btn btn-success btn-sm" type="submit" value="approved"
                                    name="status">Approve</button>
                                <button class="btn btn-danger btn-sm" type="submit" value="declined"
                                    name="status">Decline</button>
                            @endif
                        </form>
                    </div>

                    @if ($application->status === 'approved')
                    <div class="border p-2 m-2">
                        @php
                            $approvedInfo = DB::table('approved_decline_leaves')
                                ->where('leave_application_id', $application->id)
                                ->first();
                        @endphp
                        <p><b>Leave Approved:</b> {{ $approvedInfo->approved_days }}</p>
                        <div class="row">
                            <div class="col-md-2">
                                <label>CL</label>
                                <input type="text" value="{{ $approvedInfo->casual_leave ?? '' }}" class="w-50" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>SL</label>
                                <input type="text" value="{{ $approvedInfo->sick_leave ?? '' }}" class="w-50" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>AL</label>
                                <input type="text" value="{{ $approvedInfo->annual_leave ?? '' }}" class="w-50" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>ML</label>
                                <input type="text" value="{{ $approvedInfo->maternity_leave ?? '' }}" class="w-50" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>PL</label>
                                <input type="text" value="{{ $approvedInfo->paternity_leave ?? '' }}" class="w-50" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>ALT</label>
                                <input type="text" value="{{ $approvedInfo->annual_leave_total ?? '' }}" class="w-50" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>Special Leave</label>
                                <input type="text" value="{{ $approvedInfo->special_leave ?? '' }}" class="w-50" disabled>
                            </div>
                        </div>
                    </div>
                    @endif

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
