@extends('layouts.app')
@section('body-class', 'dark-body')

@section('custom-style')
<style>
    body.dark-body {
        background-color: #222 !important;
        color: #ddd !important;
    }

    .admin-container {
        background-color: #181a1b;
        color: #ddd;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin: 3rem auto;
        width: 60%;
    }

    h2 {
        color: #27ae60;
        text-align: center;
        margin-bottom: 2rem;
    }

    label {
        display: block;
        margin-top: 1rem;
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 0.6rem;
        margin-top: 0.5rem;
        background-color: #2a2c2d;
        color: #ddd;
        border: 1px solid #444;
        border-radius: 6px;
    }

    button {
        margin-top: 2rem;
        padding: 0.7rem 1.5rem;
        border: none;
        border-radius: 6px;
        background-color: #27ae60;
        color: white;
        font-size: 1rem;
        cursor: pointer;
    }

    button:hover {
        background-color: #2ecc71;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 1.5rem;
        color: #aaa;
    }

    .back-link:hover {
        color: #27ae60;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <h2>Create New User</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Role:</label>
        <select name="is_admin" required>
            <option value="0">User</option>
            <option value="1">Admin</option>
        </select>

        <button type="submit">Create User</button>
    </form>

    <a href="{{ route('admindashboard') }}" class="back-link">← Back to Users</a>
</div>
@endsection
