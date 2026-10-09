<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        @php
            $projectName = \DB::table('project_settings')->first()->project_name ?? 'Recora';
        @endphp
        <h2>{{ $projectName }} - Users Export</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Number</th>
                <th>Email</th>
                <th>Status</th>
                <th>Joining Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->number ?: 'N/A' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generated on: {{ now()->format('d M Y h:i A') }}</p>
    </div>
</body>
</html>
