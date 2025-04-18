<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            margin: 5px;
            display: inline-block;
        }
        .edit-btn {
            background-color: #28a745;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .add-user-btn {
            background-color: #007bff;
            padding: 10px 15px;
            font-size: 16px;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .logout-btn {
            background-color: #6c757d;
            padding: 10px 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>This an Admin View</h1>

        @can('manage', App\Models\User::class)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}">Edit</a> |
                <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('users.create') }}">Add New User</a>
@else
<p>You do not have permission to manage users.</p>
@endcan
