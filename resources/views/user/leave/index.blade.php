@php
    use Vanguard\User;
@endphp
@extends('layouts.app')


@section('page-title', __('My Leaves'))
@section('page-heading', __('My Leaves'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Leaves / My applications')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-borderless table-primary align-middle">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Manager</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Leave Days</th>
                                    <th>Type</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($myApplications as $application)
                                    <tr>
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td>{{ DB::table('users')->where('id', $application->manager_id)->first()->first_name }}</td>
                                        <td>{{ $application->leave_from }}</td>
                                        <td>{{ $application->leave_to }}</td>
                                        <td>{{ $application->leave_days }}</td>
                                        <td>{{ $application->leave_type }}</td>
                                        <td>{{ $application->purpose }}</td>
                                        <td>
                                            @if ($application->status === 'pending')
                                                <span class="badge badge-info">{{ $application->status }}</span>
                                            @elseif($application->status === 'approved')
                                                <span class="badge badge-success">{{ $application->status }}</span>
                                            @elseif($application->status === 'declined')
                                                <span class="badge badge-danger">{{ $application->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($application->status !== 'pending')
                                            <a href="{{ route('view.my.applied.application', $application->id) }}" class="btn btn-success btn-sm">View</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
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