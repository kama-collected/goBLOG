<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        table {
            width: 60%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>You Have Successfully Logged In - Welcome to User Lists</h1>
    
    @can('viewAny', App\Models\User::class)
    <form method="GET" action="{{ route('userTable') }}">
        <input type="text" name="name" placeholder="Search by Name" value="{{ request('name') }}">
        <input type="email" name="email" placeholder="Search by Email" value="{{ request('email') }}">
        <select name="is_admin">
            <option value="">All Roles</option>
            <option value="1" {{ request('is_admin') === '1' ? 'selected' : '' }}>Admin</option>
            <option value="0" {{ request('is_admin') === '0' ? 'selected' : '' }}>User</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    
    @if(isset($users) && $users->count() > 0)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No users found.</p>
    @endif
    
    @endcan
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
