<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>

    <style>
       * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #222;
            color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .signup-card {
            background: #181a1b;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ddd;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            background-color: #222;
            color: #ddd;
            border: 1px solid #444;
            border-radius: 8px;
            font-size: 1rem;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 0.5rem;
            color: #ddd;
        }

        .error-messages {
            background: #3a1f1f;
            color: #e57373;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .success-message {
            background: #1d3525;
            color: #27ae60;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .inline-error {
            color: #e57373;
            font-size: 0.9rem;
            margin-top: -0.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #219150;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #4A90E2;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<div class="signup-card">
    <h1>Sign Up</h1>

    @if ($errors->any())
        <div class="error-messages">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('signup') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Name" required>
        @error('name')
            <span class="inline-error">{{ $message }}</span>
        @enderror

        <input type="password" name="password" placeholder="Password" required>
        @error('password')
            <span class="inline-error">{{ $message }}</span>
        @enderror

        <input type="email" name="email" placeholder="Email" required>
        @error('email')
            <span class="inline-error">{{ $message }}</span>
        @enderror

        <label for="is_admin">Sign up as:</label>
        <select name="is_admin" required>
            <option value="0">User</option>
            <option value="1">Admin</option>
        </select>
        @error('is_admin')
            <span class="inline-error">{{ $message }}</span>
        @enderror

        <button type="submit">Sign Up</button>

        <a class="login-link" href="{{ route('login') }}">Already have an account? Log in here.</a>
    </form>
</div>

</body>
</html>
