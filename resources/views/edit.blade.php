

<div class="container">
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $user->name }}" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required><br><br>

        <label>Role:</label>
        <select name="is_admin">
            <option value="0" {{ $user->is_admin ? '' : 'selected' }}>User</option>
            <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
        </select><br><br>

        <button type="submit">Update</button>
    </form>

    <br>
    <a href="{{ route('users.index') }}">Back to Users</a>
</div>

