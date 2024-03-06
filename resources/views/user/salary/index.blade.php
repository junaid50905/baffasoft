@php
    use Carbon\Carbon;
    use Vanguard\EmployeeSalary;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salary paid</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 5px;
        }

        .company-details {
            text-align: center;
        }

        table {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        tr,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse
        }

        p.date {
            margin-left: 10px;
            margin-top: 10px;
        }

        p.office {
            margin-left: 10px;
        }

        .save-btn {
            background: green;
            border: none;
            color: white;
            border-radius: 2px;
            padding: 5px 10px;
            text-decoration: none;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="header-content">
        <div class="company-details">
            <h3>Bangladesh Freight Forwarder Association</h3>
            <p>Dhaka Office, House # 10, Road # 17A, Block # E, Banani, Dhaka-1213.</p>
            <p>Salary Statement {{ $office }} for the month of
                {{ Carbon::createFromFormat('Y-m', $year_month)->format('F-Y') }}</p>
        </div>
    </div>
    <a href="{{ route('pdf.monthWiseSalary', [$office, $year_month]) }}" class="save-btn">Download as PDf</a>
    <p class="date">Date: {{ Carbon::now()->toDateString() }}</p>
    <p class="office">Office: {{ $office }}</p>

    <div>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">SN</th>
                    <th rowspan="2">Name of Employee</th>
                    <th rowspan="2">Designation</th>
                    <th rowspan="2">Joining Date</th>
                    <th colspan="5">Rate of Pay</th>
                    <th rowspan="2">Total <br> Salary</th>
                    <th rowspan="2">Absent</th>
                    <th rowspan="2">Late</th>
                    <th colspan="5">Income</th>
                    <th rowspan="2">Total Payable</th>
                    <th colspan="4">Deduction</th>
                    <th rowspan="2">Net Payment</th>
                </tr>
                <tr>
                    <th>Basic</th>
                    <th>H.R</th>
                    <th>Medical</th>
                    <th>Conveyance</th>
                    <th>Other</th>
                    <th>Basic</th>
                    <th>H.R</th>
                    <th>Medical</th>
                    <th>Conveyance</th>
                    <th>Other</th>
                    <th>TDS</th>
                    <th>Others</th>
                    <th>P.F</th>
                    <th>Total</th>
                </tr>

            </thead>
            <tbody>
                @php
                    // rate of pay and income
                    $totalRp_basic = 0;
                    $totalRp_hr = 0;
                    $totalRp_medical = 0;
                    $totalRp_conveyance = 0;
                    $totalRp_other_addition = 0;
                    $totalRp_total_salary = 0;

                    // deduction
                    $deduction_tax_deduction = 0;
                    $deduction_other_subtruction = 0;
                    $deduction_provident_fund = 0;
                    $deduction_total = 0;
                    $total_netPayment = 0;
                @endphp
                @foreach ($salaryPaidUsers as $salaryPaidUser)
                    @php
                        $user = DB::table('users')
                            ->where('id', $salaryPaidUser->user_id)
                            ->first();
                        $username = $user->first_name;
                        $userProfile = DB::table('users_profiles')
                            ->where('user_id', $salaryPaidUser->user_id)
                            ->first();
                        $designation = $userProfile->designation ?? '';
                        $joining_date = $userProfile->joining_date ?? '';
                        $employeeSalary = DB::table('employees_salaries')
                            ->where('user_id', $salaryPaidUser->user_id)
                            ->first();
                        // rate of pay and income
                        $rateofpay_basic_salary = $employeeSalary->basic_salary;
                        $rateofpay_house_rent = $employeeSalary->house_rent;
                        $rateofpay_medical = $employeeSalary->medical;
                        $rateofpay_conveyance = $employeeSalary->conveyance;
                        $rateofpay_other_addition = $employeeSalary->other_addition;
                        $rateofpay_totalSalary = $employeeSalary->total_payable;

                        // deduction
                        $deduction_tds = $employeeSalary->tds;
                        $deduction_other_subtraction = $employeeSalary->other_subtraction;
                        $deduction_pf = $employeeSalary->provident_fund;
                        $total_deduction = $employeeSalary->total_deduction_after_change;
                        $late = $employeeSalary->late;
                        $absent = $employeeSalary->absent;

                        // netpayment
                        $netpayment = $employeeSalary->net_payment;

                        ////////////
                        $totalRp_basic += $rateofpay_basic_salary;
                        $totalRp_hr += $rateofpay_house_rent;
                        $totalRp_medical += $rateofpay_medical;
                        $totalRp_conveyance += $rateofpay_conveyance;
                        $totalRp_other_addition += $rateofpay_other_addition;
                        $totalRp_total_salary += $rateofpay_totalSalary;
                        ////////////
                        $deduction_tax_deduction += $deduction_tds;
                        $deduction_other_subtruction += $deduction_other_subtraction;
                        $deduction_provident_fund += $deduction_pf;
                        $deduction_total += $total_deduction;
                        $total_netPayment += $netpayment;

                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $username }}</td>
                        <td>{{ $designation }}</td>
                        <td>{{ $joining_date }}</td>
                        <td>{{ $rateofpay_basic_salary }}</td>
                        <td>{{ $rateofpay_house_rent }}</td>
                        <td>{{ $rateofpay_medical }}</td>
                        <td>{{ $rateofpay_conveyance }}</td>
                        <td>{{ $rateofpay_other_addition }}</td>
                        <td>{{ $rateofpay_totalSalary }}</td>
                        <td>{{ $absent }}</td>
                        <td>{{ $late }}</td>
                        <td>{{ $rateofpay_basic_salary }}</td>
                        <td>{{ $rateofpay_house_rent }}</td>
                        <td>{{ $rateofpay_medical }}</td>
                        <td>{{ $rateofpay_conveyance }}</td>
                        <td>{{ $rateofpay_other_addition }}</td>
                        <td>{{ $rateofpay_totalSalary }}</td>
                        <td>{{ $deduction_tds }}</td>
                        <td>{{ $deduction_other_subtraction }}</td>
                        <td>{{ $deduction_pf }}</td>
                        <td>{{ $total_deduction }}</td>
                        <td>{{ $netpayment }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th>{{ $totalRp_basic }}</th>
                    <th>{{ $totalRp_hr }}</th>
                    <th>{{ $totalRp_medical }}</th>
                    <th>{{ $totalRp_conveyance }}</th>
                    <th>{{ $totalRp_other_addition }}</th>
                    <th>{{ $totalRp_total_salary }}</th>
                    <th></th>
                    <th></th>
                    <th>{{ $totalRp_basic }}</th>
                    <th>{{ $totalRp_hr }}</th>
                    <th>{{ $totalRp_medical }}</th>
                    <th>{{ $totalRp_conveyance }}</th>
                    <th>{{ $totalRp_other_addition }}</th>
                    <th>{{ $totalRp_total_salary }}</th>
                    <th>{{ $deduction_tax_deduction }}</th>
                    <th>{{ $deduction_other_subtruction }}</th>
                    <th>{{ $deduction_provident_fund }}</th>
                    <th>{{ $deduction_total }}</th>
                    <th>{{ $total_netPayment }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
