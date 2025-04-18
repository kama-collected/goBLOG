<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>

<h2>Create New User</h2>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <label>Role:</label>
    <select name="is_admin">
        <option value="0">User</option>
        <option value="1">Admin</option>
    </select><br><br>

    <button type="submit">Create User</button>
</form>

<br>
<a href="{{ route('users.index') }}">Back to Users</a>

</body>
</html>

