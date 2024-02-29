@extends('layouts.app')


@section('page-title', __('Departments'))
@section('page-heading', __('Departments'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Departments')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <a href="{{ route('department.create') }}" class="btn btn-dark mb-3"> + Add new </a>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        <a href="{{ route('department.edit', $department->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="{{ route('department.delete', $department->id) }}" class="btn btn-sm btn-danger">Delete</a>
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
