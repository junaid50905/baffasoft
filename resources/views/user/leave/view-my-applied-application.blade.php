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
                    @php
                        $application = DB::table('leave_applications')->where('id', $applicationId)->first();
                        $userId = $application->user_id;
                        $status = $application->status;

                        $approvedDays = DB::table('leave_approves')
                            ->where('leave_application_id', $applicationId)
                            ->where('user_id', $userId)
                            ->get();
                    @endphp

                    @if ($status == 'approved')
                        <p class="badge badge-success">{{ $status }}</p>
                        <div>
                            <h5>Leave approved days:</h5>
                            @foreach ($approvedDays as $day)
                                <p class="m-1">{{ $day->date }} : {{ $day->leave_type }}</p>
                            @endforeach
                        </div>
                    @elseif($status == 'declined')
                        <p class="badge badge-danger">{{ $status }}</p>
                        <p class="text-danger">Your application has been declined</p>
                    @elseif($status == 'pending')
                        <p class="badge badge-info">{{ $status }}</p>
                        <p class="text-danger">Your application is in pending</p>
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
