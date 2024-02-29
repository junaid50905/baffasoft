
@extends('layouts.app')


@section('page-title', __('Edit department'))
@section('page-heading', __('Edit department'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Departments')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('department.update', $department->id) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label>Department Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $department->name }}">
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
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
