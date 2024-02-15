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
        $name = $user->first_name . ' ' . $user->last_name;

        $designation = $userProfile->designation ?? 'Not set yet';

        $basic_salary = $rateOfPay->basic_salary ?? 'Not set yet';
        $hr = $rateOfPay->house_rent_allowance ?? 'Not set yet';
        $medical = $rateOfPay->medical_allowance ?? 'Not set yet';
        $conveyance = $rateOfPay->conveyance ?? 'Not set yet';
        $other_addition = $rateOfPay->other_addition ?? 'Not set yet';

        $tds = $rateOfPay->tds ?? 'Not set yet';
        $pf = $rateOfPay->provident_fund ?? 'Not set yet';
        $other_subtraction = $rateOfPay->other_subtraction ?? 'Not set yet';

        $totalSalary = $basic_salary + $hr + $medical + $conveyance + $other_addition;
        $totalPayable = $totalSalary;

        $totalDeduction = $tds + $other_subtraction + $pf;
        $totalDeductionAfterChange = $totalDeduction;

        $netPayment = $totalPayable - $totalDeductionAfterChange;
    @endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payable.salary.create', $user->id) }}" method="POST">
                        @csrf
                        <input type="text" value="{{ $user->id }}" name="user_id" hidden>
                        <div>
                            <p class="m-0"><b>Employee Name:</b> {{ $name ?? 'Not set yet' }}</p>
                            <p class="m-0"><b>Designation:</b> {{ $designation }}</p>
                            <p class="m-0"><b>Year & Month:</b> <input type="month" name="paid_year_month"> </p>
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
                                    <td><input type="text" value="{{ $other_subtraction }}" name="other_subtraction">
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
                                <td>{{ $totalDeductionAfterChange }}</td>
                            </tfoot>
                        </table> <br>




                        <div class="row">
                            <div class="col-md-5 py-2">
                                <div class="d-flex justify-content-between">
                                    <label>Total absent</label>
                                    <div>
                                        <input type="text" placeholder="Total absent days"
                                            title="120 taka will be deducted for per absent" name="absent" required> × 120
                                        Tk
                                    </div>
                                </div> <br>
                                <div class="d-flex justify-content-between">
                                    <label>Total Late Hour</label>
                                    <div>
                                        <input type="text" placeholder="Total late hours"
                                            title="15 taka will be deducted for per late hour" name="late" required> × 15
                                        Tk
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <button class="btn btn-info" type="submit" value="calculate" name="payment_status">Calculate Net Payment</button>
                                </div>
                            </div>
                            <div class="col-md-7 py-2 text-right">
                                <div>
                                    <p class="m-1"><b>Total payable :</b> <input type="text"
                                            value="{{ $totalSalary }}" disabled></p>
                                    <p class="m-1"><b>Total deduction after change :</b> ( - )<input type="text"
                                            value="{{ $totalDeduction }}" disabled></p>
                                    <p class="m-1"><b>Total absent deduction :</b> ( - ) <input type="text" disabled></p>
                                    <p class="m-1"><b>Total late deduction :</b> ( - )<input type="text" disabled></p>
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
