<!DOCTYPE html>
<!-- Added by kama (used) -->
<head>
    <style>
        .site-title, h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar h1 {
            text-align:center;
            font-size: 2rem;
            font-weight:bold;
            font-family: sans-serif;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 15%;
            background-color: white;
            color: #333;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sideNav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 10px;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }

        .sideNav a:hover {
            background-color: #f0f2f5;
            color: #27ae60;
        }

        .sideNav a.active {
            font-weight: bold;
            color: #27ae60;
        }


        .sidebar i {
            margin-right: 10px;
        }

        .sideNav form {

            position: absolute;
            margin: 100% auto 5% 5%;
            left: 0;
            bottom:0;
            width: 80%;
            padding: 0px;
            box-shadow: 0 0 0 0;
        }

        .sideNav form button {
            display: block;
            color: white;
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            padding: 12px 10px;
            border-radius: 6px;
            font: inherit;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .sideNav form button:hover {
            background-color: #f0f2f5;
            color: red;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</head>

<aside class="sidebar">
    <nav class="sideNav">
        <h1><i class ='fas fa-address-book'></i>goBLOG</h1></br>
        <a 
            href="{{ route('user.feed', ['name' => Auth::user()->name, 'user_id' => Auth::user()->user_id]) }}" 
            class="{{ request()->is('feed/*') ? 'active' : '' }}"
        >
            <i class ='fas fa-house-chimney'></i>Home
        </a></br>

        <a href="/search" class="{{ request()->is('search') ? 'active' : '' }}">
            <i class ='fas fa-search'></i>Search
        </a></br>

        <a href="/explore" class="{{ request()->is('explore') ? 'active' : '' }}">
            <i class ='fas fa-compass'></i>Explore
        </a></br>

        <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">
            <i class ='fas fa-user'></i>Profile
        </a></br>


        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logoutBtn">
                <i class="fas fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </nav>
</aside>