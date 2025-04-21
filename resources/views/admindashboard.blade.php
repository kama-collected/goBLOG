@extends('layouts.app')

@section('body-class', 'dark-body')

@section('custom-style')
<style>
    body.dark-body {
        background-color: #222 !important;
        color: #ddd !important;
    }

    .admin-container, .container {
        background-color: #181a1b;
        color: #ddd;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-top: 2rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #444;
    }

    th {
        background-color: #333;
        color: #27ae60;
    }

    tr:nth-child(even) {
        background-color: #2a2c2d;
    }

    tr:hover {
        background-color: #333;
    }

    .btn {
        background-color: #181a1b;
        border: none;
        padding: 0.5rem 1rem;
        margin: 2px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        color: #ddd;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #222;
        color: #27ae60;
    }

    .edit-btn {
        color: #27ae60;
    }

    .delete-btn {
        color: #dc3545;
    }

    .add-user-btn {
        background-color: #222;
        color: #27ae60;
        font-size: 1rem;
        margin-top: 1.5rem;
    }

    .logout-btn {
        background-color: #444;
        color: #fff;
        margin-top: 1rem;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <h1>Admin Dashboard</h1>

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
                    @if(!$user->is_admin)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a class="btn edit-btn" href="{{ url('/admin/user/' . $user->user_id . '/contents') }}">View Content</a>
                            <form action="{{ route('users.destroy', ['user' => $user->user_id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn delete-btn" type="submit">Delete User</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <a class="btn add-user-btn" href="{{ route('users.create') }}">Add New User</a>
    @else
        <p class="text-center">You do not have permission to manage users.</p>
    @endcan
</div>

<form method="POST" action="{{ route('logout') }}" style="text-align: center; margin-top: 2rem;">
    @csrf
    <button class="btn logout-btn" type="submit">Logout</button>
</form>
@endsection
