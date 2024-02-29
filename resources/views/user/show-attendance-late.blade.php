@extends('layouts.app')


@section('page-title', __('Select month of salary'))
@section('page-heading', __('Select month of salary'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('User / View Profile / Pay salary')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            @if (Session::has('already_paid'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ Session('already_paid') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div>
                <p><b>Employee:</b>{{ $user->first_name }}</p>
            </div>
            <div class="m-0"><b>Select month and year of salary</b>
                <form action="{{ route('user.monthly.attendance', $user->id) }}" method="POST">
                    @csrf
                    <input type="month" name="year_month" max="{{ date('Y-m') }}">
                    <button type="submit" class="btn btn-sm btn-dark">Go Forward</button>
                </form>
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
