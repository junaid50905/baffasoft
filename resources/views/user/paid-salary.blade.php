@extends('layouts.app')


@section('page-title', __('Pay'))
@section('page-heading', __('Pay'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Pay')
    </li>
@stop

@section('content')

    @include('partials.messages')

    @php
        $name = $user->first_name . ' ' . $user->last_name;

        $designation = $user->userProfile->designation ?? 'Null';

        $basic_salary = $salary->basic_salary ?? 'Null';
        $hr = $salary->house_rent_allowance ?? 'Null';
        $medical = $salary->medical_allowance ?? 'Null';
        $conveyance = $salary->conveyance ?? 'Null';
        $other_addition = $salary->other_addition ?? 'Null';
        $totalSalary = $basic_salary + $hr + $medical + $conveyance + $other_addition;

        $tds = $salary->tds ?? 'Null';
        $pf = $salary->provident_fund ?? 'Null';
        $other_subtraction = $salary->other_subtraction ?? 'Null';
        $totalDeduction = $tds + $pf + $other_subtraction;

        // after change
        $year_month = $afterChangeSalary->paid_year_month ?? 'Null';
        $basic = $afterChangeSalary->basic_salary ?? 'Null';
        $house_rent = $afterChangeSalary->house_rent ?? 'Null';
        $medical_allowance = $afterChangeSalary->medical ?? 'Null';
        $conveyance_fee = $afterChangeSalary->conveyance ?? 'Null';
        $other_add = $afterChangeSalary->other_addition ?? 'Null';
        $totalPayable = $basic + $house_rent + $medical_allowance + $conveyance_fee + $other_add;

        $tds_fee = $afterChangeSalary->tds ?? 'Null';
        $provident_fund = $afterChangeSalary->provident_fund ?? 'Null';
        $other_sub = $afterChangeSalary->other_subtraction ?? 'Null';
        $totalDeductionAfterChange = $tds_fee + $provident_fund + $other_sub;

        $absent = $afterChangeSalary->absent ?? 'Null';
        $late = $afterChangeSalary->late ?? 'Null';
        $totalAbsentDeduction = $afterChangeSalary->absent_deduction ?? 'Null';
        $totalLateDeduction = $afterChangeSalary->late_deduction ?? 'Null';


        $netPayment = $totalPayable - $totalDeductionAfterChange - $totalAbsentDeduction - $totalLateDeduction;

        // send the data when click the back button to change the net payment

        


    @endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="payment-form" action="{{ route('paid.salary.store', $user->id) }}" method="POST">
                        @csrf
                        <input type="text" value="{{ $user->id }}" name="user_id" hidden>
                        <div>
                            <p class="m-0"><b>Employee Name:</b>{{ $name }}</p>
                            <p class="m-0"><b>Designation:</b>{{ $designation }}</p>
                            <p class="m-0"><b>Year & Month:</b> <input type="month" value="{{ $year_month }}"
                                    name="paid_year_month"> </p>
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
                                    <td><input type="text" value="{{ $basic }}" name="basic_salary"></td>
                                    <td>TDS</td>
                                    <td>{{ $tds }}</td>
                                    <td>TDS</td>
                                    <td><input type="text" value="{{ $tds_fee }}" name="tds"></td>
                                </tr>
                                <tr>
                                    <td>Home Rent</td>
                                    <td>{{ $hr }}</td>
                                    <td>Home Rent</td>
                                    <td><input type="text" value="{{ $house_rent }}" name="house_rent"></td>
                                    <td>Provident Fund</td>
                                    <td>{{ $pf }}</td>
                                    <td>Provident Fund</td>
                                    <td><input type="text" value="{{ $provident_fund }}" name="provident_fund">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Medical</td>
                                    <td>{{ $medical }}</td>
                                    <td>Medical</td>
                                    <td><input type="text" value="{{ $medical_allowance }}" name="medical">
                                    </td>
                                    <td>Other</td>
                                    <td>{{ $other_subtraction }}</td>
                                    <td>Other</td>
                                    <td><input type="text" value="{{ $other_sub }}" name="other_subtraction">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Conveyance</td>
                                    <td>{{ $conveyance }}</td>
                                    <td>Conveyance</td>
                                    <td><input type="text" value="{{ $conveyance_fee }}" name="conveyance">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Other</td>
                                    <td>{{ $other_addition }}</td>
                                    <td>Other</td>
                                    <td><input type="text" value="{{ $other_add }}" name="other_addition">
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
                                            title="120 taka will be deducted for per absent" value="{{ $absent }}"
                                            name="absent" required> × 120
                                        Tk
                                    </div>
                                </div> <br>
                                <div class="d-flex justify-content-between">
                                    <label>Total Late Hour</label>
                                    <div>
                                        <input type="text" placeholder="Total late hours"
                                            title="15 taka will be deducted for per late hour" value="{{ $late }}"
                                            name="late" required> × 15
                                        Tk
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <button onclick="changeFormAction(this.value)" class="btn btn-info" type="submit" name="payment_status" value="calculate">Calculate net payment</button>
                                </div>
                            </div>
                            <div class="col-md-7 py-2 text-right">
                                <div>
                                    <p class="m-1"><b>Total payable :</b> <input type="text" value="{{ $totalPayable }}" name="total_payable">
                                    </p>
                                    <p class="m-1"><b>Total deduction after change :</b> ( - )<input type="text"
                                            value="{{ $totalDeductionAfterChange }}" name="total_deduction_after_change"></p>
                                    <p class="m-1"><b>Total absent deduction :</b> ( - ) <input type="text" value="{{ $totalAbsentDeduction }}" name="absent_deduction">
                                    </p>
                                    <p class="m-1"><b>Total late deduction :</b> ( - )<input type="text" value="{{ $totalLateDeduction }}" name="late_deduction"></p>
                                    <hr>
                                    <p class="m-1"><b>Net payment :</b> <input type="text" value="{{ $netPayment }}" name="net_payment">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button onclick="changeFormAction(this.value)" class="btn btn-success float-right" type="submit" name="payment_status" value="paid">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop

@section('scripts')

<script>
    function changeFormAction(buttonValue) {
        var form = document.getElementById('payment-form');
        if (buttonValue === 'calculate') {
            form.action = "{{ route('payable.salary.create', $user->id) }}";
        } else if (buttonValue === 'paid') {
            form.action = "{{ route('paid.salary.store', $user->id) }}";
        }
    }
</script>

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
