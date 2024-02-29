@php
    use Carbon\Carbon;
@endphp


@extends('layouts.app')

@section('page-title', __('Pay salary'))
@section('page-heading', __('Pay salary'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Pay salary')
    </li>
@stop

@section('content')

    @include('partials.messages')

    @php
        // user info ////////////////////////////////////////////////////
        $name = $user->first_name . ' ' . $user->last_name;
        $designation = $userProfile->designation ?? 'not set';

        // rate of payable salary and deduction /////////////////////////
        // rate of pay
        $basic_salary = $rateOfPay->basic_salary ?? 0;
        $hr = $rateOfPay->house_rent_allowance ?? 0;
        $medical = $rateOfPay->medical_allowance ?? 0;
        $conveyance = $rateOfPay->conveyance ?? 0;
        $other_addition = $rateOfPay->other_addition ?? 0;
        // rate of deduction
        $tds = $rateOfPay->tds ?? 0;
        $pf = $rateOfPay->provident_fund ?? 0;
        $other_subtraction = $rateOfPay->other_subtraction ?? 0;
        // total payable salaray
        $totalSalary = $basic_salary + $hr + $medical + $conveyance + $other_addition;
        $totalPayable = $totalSalary;

        //
        $totalDeduction = $tds + $other_subtraction + $pf;

        $lateDeductionFeePerDay = intval($basic_salary / 30);

        // // after showing month wise attendance
        $lateCount = $lateCount;
        $formattedDate = $formattedDate;
        $absentCount = $absentCount;

        // Parse the date string using Carbon
        $date = Carbon::createFromFormat('M-y', $formattedDate);

        // Format the date as 'Y-m' (year-month)
        $dateForInvoic = $date->format('Y-m');

        //
        $lateDays = intval($lateCount / 3);

        // total late days
        $totalLateDays = $lateDays + $absentCount;

        // total late deduciton
        $totalLateAbsentDeduction = $totalLateDays * $lateDeductionFeePerDay;

        // finialSubtraction
        $finialDeductionAfterChange = $totalDeduction + $totalLateAbsentDeduction;

        // netPayment
        $netPayment = $totalPayable - $finialDeductionAfterChange;

    @endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payable.salary.create', $user->id) }}" method="POST">
                        @csrf
                        {{-- user id --}}
                        <input type="text" value="{{ $user->id }}" name="user_id" hidden>
                        <input type="text" value="{{ $lateDays }}" name="late" hidden>
                        <input type="text" value="{{ $absentCount }}" name="absent" hidden>
                        <div>
                            <p class="m-0"><b>Employee Name:</b> {{ $name ?? 'Not set yet' }}</p>
                            <p class="m-0"><b>Designation:</b> {{ $designation ?? 'Not set yet' }}</p>
                            <p class="m-0"><b>Year & Month:</b> <input type="month" name="paid_year_month"
                                    value="{{ $dateForInvoic }}" readonly> </p>
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
                                    <td>{{ $basic_salary }}</td>
                                    <td>Basic Salary</td>
                                    <td><input type="text" value="{{ $basic_salary }}" name="basic_salary"
                                            id="basicSalary"></td>
                                    <td>TDS</td>
                                    <td>{{ $tds }}</td>
                                    <td>TDS</td>
                                    <td><input type="text" value="{{ $tds }}" name="tds"></td>
                                </tr>
                                <tr>
                                    <td>Home Rent</td>
                                    <td>{{ $hr }}</td>
                                    <td>Home Rent</td>
                                    <td><input type="text" value="{{ $hr }}" name="house_rent"></td>
                                    <td>Provident Fund</td>
                                    <td>{{ $pf }}</td>
                                    <td>Provident Fund</td>
                                    <td><input type="text" value="{{ $pf }}" name="provident_fund"></td>
                                </tr>
                                <tr>
                                    <td>Medical</td>
                                    <td>{{ $medical }}</td>
                                    <td>Medical</td>
                                    <td><input type="text" value="{{ $medical }}" name="medical"></td>
                                    <td>Other</td>
                                    <td>{{ $other_subtraction }}</td>
                                    <td>Other</td>
                                    <td><input type="text" value="{{ $totalLateAbsentDeduction }}"
                                            name="other_subtraction">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Conveyance</td>
                                    <td>{{ $conveyance }}</td>
                                    <td>Conveyance</td>
                                    <td><input type="text" value="{{ $conveyance }}" name="conveyance"></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td>{{ $other_addition }}</td>
                                    <td>Other</td>
                                    <td><input type="text" value="{{ $other_addition }}" name="other_addition"></td>
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
                                <td>{{ $totalPayable }}</td>
                                <td><b>Total Deduction</b></td>
                                <td>{{ $totalDeduction }}</td>
                                <td><b>Total Deduction after change</b></td>
                                <td>{{ $finialDeductionAfterChange ?? 0 }}</td>
                            </tfoot>
                        </table> <br>




                        <div class="row">
                            <div class="col-md-5 py-2">
                                <div>
                                    <p class="m-0">Total Late: {{ $lateDays }}</p>
                                    <p class="m-0">Total absent: {{ $absentCount }}</p>
                                    <p class="m-0">Total Deduction: {{ $totalLateAbsentDeduction }}</p>
                                </div> <br>
                                <div class="d-flex mt-2">
                                    <button class="btn btn-info" type="submit" value="calculate"
                                        name="payment_status">Calculate Net Payment</button>
                                </div>
                            </div>
                            <div class="col-md-7 py-2 text-right">
                                <div>
                                    <p class="m-1"><b>Total payable :</b> <input type="text"
                                            value="{{ $totalSalary }}" disabled></p>
                                    <p class="m-1"><b>Total deduction after change :</b> ( - )<input type="text"
                                            value="{{ $finialDeductionAfterChange }}" disabled></p>
                                    <hr>
                                    <p class="m-1"><b>Net payment :</b> <input type="text"
                                            value="{{ $netPayment }}" disabled></p>
                                </div>
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
