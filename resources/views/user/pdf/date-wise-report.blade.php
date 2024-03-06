@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendacne summary report by date wise</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 10px 20px;
        }

        table.table {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table.table tr,
        table.table td,
        table.table th {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table.table td,
        table.tableth{
            padding: 1px;
        }

        .title {
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 70px;
        }

        .title h5 {
            text-transform: uppercase;
        }

        .overview-table th,
        .overview-table td {
            padding: 2px 10px;
        }
        .company-details {
            text-align: center;
            margin: 10px 0 20px 0;
        }

        .date-overview-table {
            width: 100%;
            height: 150px;
        }
        .date-overview-table .title{
            width: 80%;
            float: left;
        }
        .date-overview-table .table-overview{
            width: 20%;
            float: right;
            margin-bottom: 10px;
        }

        .date-overview-table .table-overview table th,
        .date-overview-table .table-overview table td {
            padding: 3px 10px;
        }
        .download-btn{
            background: green;
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 2px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="company-details">
            <h3>Bangladesh Freight Forwarder Association</h3>
            <p>Dhaka Office, House # 10, Road # 17A, Block # E, Banani, Dhaka-1213.</p>
        </div>
    </div>


    <div class="date-overview-table">
        <div class="title">
            <h5>Attendance summary report by date wise</h5>
            <p><b>From : </b>{{ $from }}</p>
            <p><b>To : </b>{{ $to }}</p>
            <p><b>Total Days : </b>{{ Carbon::parse($to)->diffInDays(Carbon::parse($from)) + 1 }}</p>
        </div>
        <div class="table-overview">
            <table class="table">
                <tr>
                    <th>Present</th>
                    <td>{{ $totalPresent }}</td>
                </tr>
                <tr>
                    <th>Absent</th>
                    <td>{{ $totalAbsent }}</td>
                </tr>
                <tr>
                    <th>Late In</th>
                    <td>{{ $totalLate }}</td>
                </tr>
                <tr>
                    <th>Early In</th>
                    <td>{{ $totalEarly }}</td>
                </tr>
            </table>
        </div>
    </div>




    <table style="margin-top: 20px;" class="table">
        <thead>
            <tr>
                <th rowspan="2">EMP NO</th>
                <th rowspan="2">Employee Name</th>
                <th rowspan="2">Designation</th>
                <th colspan="2">Attendance</th>
                <th colspan="2">Attendance Status</th>
                <th colspan="6">Leave</th>
            </tr>
            <tr>
                <th>Present</th>
                <th>Absent</th>
                <th>Late In</th>
                <th>Early In</th>
                <th>Casual</th>
                <th>Sick</th>
                <th>Annual</th>
                <th>Paternity</th>
                <th>Maternity</th>
                <th>Special</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($distinctUserIds as $distinctUserId)
                @php
                    $user = DB::table('users')->where('id', $distinctUserId)->first();
                    $userProfile = DB::table('users_profiles')->where('user_id', $distinctUserId)->first();
                    $attendance = DB::table('attendance')
                        ->where('user_id', $distinctUserId)
                        ->whereBetween('date', [$from, $to])
                        ->get();
                    $late = $attendance->where('late', '!=', '')->count();
                    $present = $attendance->where('clock_in', '!=', '')->count();
                    $absent = $attendance
                        ->where('clock_in', '')->where('clock_out', '')->where('week', '!=', 'Fri')->count();
                    $early_in = $attendance->where('early', '>', '0:00')->count();

                    $leaves = DB::table('leave_approves')->where('user_id', $distinctUserId)->get();
                    $casual = $leaves->where('leave_type', 'Casual Leave')->count();
                    $sick = $leaves->where('leave_type', 'Sick Leave')->count();
                    $annual = $leaves->where('leave_type', 'Annual Leave')->count();
                    $maternity = $leaves->where('leave_type', 'Maternity Leave')->count();
                    $paternity = $leaves->where('leave_type', 'Paternity Leave')->count();
                    $special = $leaves->where('leave_type', 'Special Leave')->count();

                @endphp
                <tr>
                    <td>{{ $distinctUserId }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $userProfile->designation ?? '' }}</td>
                    <td>{{ $present == 0 ? '' : $present }}</td>
                    <td>{{ $absent == 0 ? '' : $absent }}</td>
                    <td>{{ $late == 0 ? '' : $late }}</td>
                    <td>{{ $early_in == 0 ? '' : $early_in }}</td>
                    <td>{{ $casual == 0 ? '' : $casual }}</td>
                    <td>{{ $sick == 0 ? '' : $sick }}</td>
                    <td>{{ $annual == 0 ? '' : $annual }}</td>
                    <td>{{ $paternity == 0 ? '' : $paternity }}</td>
                    <td>{{ $maternity == 0 ? '' : $maternity }}</td>
                    <td>{{ $special == 0 ? '' : $special }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>



</body>

</html>
