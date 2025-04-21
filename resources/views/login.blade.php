<!DOCTYPE html>
<!-- used -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #222;
            color: #ddd;
            display: flex;
            height: 100vh;
            margin: 0;
            align-items: center;
        }

        .web-title {
            display: flex;
            text-align: left;
        }

        .web-title h1 {
            font-size: 60px;
            margin: auto auto auto 10px;
            padding-left: 30px;
            color: #ddd;
        }

        .web-title i {
            font-size: 160px;
            margin-left: 20%;
            color: #27ae60;
        }

        .login-card {
            display: inline-block;
            margin-left: auto;
            margin-right: 10%;
            background: #181a1b;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-card h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ddd;
        }

        .login-card form {
            text-align: right;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            background: #333;
            color: #ddd;
        }

        label {
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: #ddd;
        }

        .error-messages {
            background: #ffe5e5;
            color: #c0392b;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background: #27ae60;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #219150;
        }

        .signup-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #4A90E2;
            text-decoration: none;
        }

        .signup-link:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <div class='web-title'>
        <i class='fas fa-address-book'></i>
        <h1>Welcome to goBLOG</h1>
    </div>

    <div class="login-card">
        <h1>Login</h1>

        @if ($errors->any())
            <div class="error-messages">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Name (optional)" value="{{ old('name', Cookie::get('user_name')) }}">
            <input type="email" name="email" placeholder="Email (optional)" value="{{ old('email', Cookie::get('user_email')) }}">
            <input type="password" name="password" placeholder="Enter Your Password" required>

            <label>
                <input type="checkbox" name="remember" {{ Cookie::has('user_email') ? 'checked' : '' }}>
                Remember Me
            </label>

            <button type="submit">Login</button>

            <a class="signup-link" href="/signup">Do not have an account? Sign up now!</a>
        </form>
    </div>
</body>
</html>
