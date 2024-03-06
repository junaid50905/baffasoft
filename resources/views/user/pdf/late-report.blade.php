<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Late report</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin: 20px 0;
            text-align: center;
        }

        table th,
        table td {
            padding: 3px;
        }

        table thead {
            border: 1px solid black;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 10px 20px;
        }

        .company-details {
            text-align: center;
            margin: 10px 0 20px 0;
        }

        .download-btn {
            background: green;
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 2px;
        }

        .title-content {
            margin: 20px 0;
        }

        .title-content h5 {
            text-transform: uppercase;
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

    <div class="title-content">
        <h5>Absent report (by date wise)</h5>
        <div>
            <h5>Report show as on</h5>
            <p><b>From : </b>{{ $from }}</p>
            <p><b>To : </b> {{ $to }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>EMP No</th>
                <th>Employee Name</th>
                <th>Department No</th>
                <th>Department Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                @php
                    $user = DB::table('users')
                        ->where('id', $attendance->user_id)
                        ->first();
                    $userProfile = DB::table('users_profiles')
                        ->where('user_id', $attendance->user_id)
                        ->first();
                    $departmentId = $userProfile->department_id ?? '';
                    $department = DB::table('departments')->where('id', $departmentId)->first();
                @endphp
                <tr>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $userProfile->department_id ?? '' }}</td>
                    <td>{{ $department->name ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
