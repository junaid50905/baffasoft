@php

    use Carbon\Carbon;
@endphp
@extends('layouts.app')


@section('page-title', __('Update user salary info'))
@section('page-heading', __('Update user salary info'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('User / Salary History / Edit')
    </li>
@stop

@section('content')

    @include('partials.messages')

    @php
        $totalSalary = $rateOfPay->basic_salary + $rateOfPay->house_rent_allowance + $rateOfPay->medical_allowance + $rateOfPay->conveyance + $rateOfPay->other_addition;
        $totalDeduction = $rateOfPay->tds + $rateOfPay->provident_fund + $rateOfPay->other_subtraction;
    @endphp

    @if (Session::has('salary_updated'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session('salary_updated') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.update.salary.store', [$user->id, $salary->id]) }}" method="POST">
                        @csrf
                        {{-- user id --}}
                        <input type="text" value="{{ $user->id }}" name="user_id" hidden>
                        <input type="text" value="{{ $salary->late }}" name="late" hidden>
                        <input type="text" value="{{ $salary->absent }}" name="absent" hidden>
                        <div>
                            <p class="m-0"><b>Employee Name:</b> {{ $user->first_name }}</p>
                            <p class="m-0"><b>Designation:</b> {{ $user->userProfile->designation }}</p>
                            <p class="m-0"><b>Year & Month:</b> <input type="month" name="paid_year_month"
                                    value="{{ $salary->paid_year_month }}"> </p>
                        </div>
                        <table class="table mt-3">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Rate of Pay</th>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">Income</th>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">Deduction</th>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">Changable Deduction</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td>{{ $rateOfPay->basic_salary }}</td>
                                    <td>Basic Salary</td>
                                    <td><input type="text" value="{{ $salary->basic_salary }}" name="basic_salary"
                                            id="basicSalary"></td>
                                    <td>TDS</td>
                                    <td>{{ $rateOfPay->tds ?? 0 }}</td>
                                    <td>TDS</td>
                                    <td><input type="text" value="{{ $salary->tds }}" name="tds"></td>
                                </tr>
                                <tr>
                                    <td>Home Rent</td>
                                    <td>{{ $rateOfPay->house_rent_allowance }}</td>
                                    <td>Home Rent</td>
                                    <td><input type="text" value="{{ $salary->house_rent }}" name="house_rent"></td>
                                    <td>Provident Fund</td>
                                    <td>{{ $rateOfPay->provident_fund }}</td>
                                    <td>Provident Fund</td>
                                    <td><input type="text" value="{{ $salary->provident_fund }}" name="provident_fund">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Medical</td>
                                    <td>{{ $rateOfPay->medical_allowance }}</td>
                                    <td>Medical</td>
                                    <td><input type="text" value="{{ $salary->medical }}" name="medical"></td>
                                    <td>Other</td>
                                    <td>{{ $rateOfPay->other_subtraction ?? 0 }}</td>
                                    <td>Other</td>
                                    <td><input type="text" value="{{ $salary->other_subtraction }}"
                                            name="other_subtraction">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Conveyance</td>
                                    <td>{{ $rateOfPay->conveyance }}</td>
                                    <td>Conveyance</td>
                                    <td><input type="text" value="{{ $salary->conveyance }}" name="conveyance"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td>{{ $rateOfPay->other_addition ?? 0 }}</td>
                                    <td>Other</td>
                                    <td><input type="text" value="{{ $salary->other_addition }}" name="other_addition">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <td><b>Total Salary TK</b></td>
                                <td>{{ $totalSalary }}</td>
                                <td><b>Total Payable TK</b></td>
                                <td>{{ $salary->total_payable }}</td>
                                <td><b>Total Deduction</b></td>
                                <td>{{ $totalDeduction }}</td>
                                <td><b>Total Deduction after change</b></td>
                                <td>{{ $salary->total_deduction_after_change }}</td>
                            </tfoot>
                        </table> <br>




                        <div class="row">
                            <div class="col-md-5 py-2">
                                <div>
                                    <p class="m-0">Total Late: {{ $salary->late }}</p>
                                    <p class="m-0">Total absent: {{ $salary->absent }} </p>
                                    <p class="m-0">Total Deduction: {{ $salary->late_absent_deduction }}</p>
                                </div>
                            </div>
                            <div class="col-md-7 py-2 text-right">
                                <div>
                                    <p class="m-1"><b>Total payable :</b> <input type="text"
                                            value="{{ $salary->total_payable }}" readonly></p>
                                    <p class="m-1"><b>Total deduction after change :</b> ( - )<input type="text"
                                            value="{{ $salary->total_deduction_after_change }}" readonly></p>
                                    <hr>
                                    <p class="m-1"><b>Net payment :</b> <input type="text"
                                            value="{{ $salary->net_payment }}" readonly></p>
                                </div>
                                <button class="btn btn-success float-right" type="submit" name="payment_status"
                                    value="paid">Update</button>
                            </div>
                        </div>

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
