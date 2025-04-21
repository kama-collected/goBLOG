<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
body {
    background-color: #222; /* dark background */
    font-family: Arial, sans-serif;
    color: #ddd;
}

.edit-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
}

.edit-card {
    background-color: #181a1b;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    padding: 2rem;
    width: 100%;
    max-width: 450px;
    color: #ddd;
}

.edit-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #eee;
    text-align: center;
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #ccc;
    margin-bottom: 0.25rem;
}

.form-input {
    width: 100%;
    padding: 0.5rem;
    background-color: #2c2f30;
    border: 1px solid #444;
    border-radius: 0.5rem;
    color: #ddd;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.3);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-input:focus {
    border-color: #27ae60;
    outline: none;
    box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.3);
}

.error-message {
    color: #e3342f;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.success-message {
    background-color: #1e3d2f;
    color: #27ae60;
    border: 1px solid #10b981;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.submit-btn {
    width: 100%;
    background-color: #27ae60;
    color: white;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    border: none;
    margin-top: 1.5rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.submit-btn:hover {
    background-color: #219653;
}

    </style>
</head>
<body>
    @include('layouts.sidebar')

    <div class="edit-container">
        <div class="edit-card">
            <h2 class="edit-title">
                <i class="fas fa-user-edit mr-2"></i>Edit Your Profile
            </h2>

            <form action="{{ route('profile.update', ['user_id' => $user->user_id]) }}" method="POST">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-input">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
                </div>


                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </form>
        </div>
    </div>
</body>
</html>
