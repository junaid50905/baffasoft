@extends('layouts.app')

@section('page-title', __('Salary info'))
@section('page-heading', __('Salary info'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Salary')
    </li>
@stop

@section('content')

    @include('partials.messages')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('salary.info.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-3">
                                <label>Month & Year</label>
                                <input type="month" name="year_month" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Place of Posting</label>
                                <select class="form-control" name="place_of_posting">
                                    <option value="HSIA">HSIA</option>
                                    <option value="Headoffice, Dhaka">Headoffice, Dhaka</option>
                                    <option value="Chattogram">Chattogram</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark btn-sm mt-2">Show result</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        $("#status").change(function() {
            $("#users-form").submit();
        });
    </script>
@stop
