
@extends('layouts.app')


@section('page-title', __('Upload attendance file'))
@section('page-heading', __('Upload attendance file'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Attendance/Upload attendance file')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('upload.csv.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label>Upload attendance csv file</label>
                        <input type="file" name="csv_file">
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                    </form>

                    <div class="mt-5">
                        <p><b>Note: Make sure your Attendance CSV file's format is like the following image</b></p>
                        <img src="{{ asset('images/csv format.jpg') }}" class="img-fluid">
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
