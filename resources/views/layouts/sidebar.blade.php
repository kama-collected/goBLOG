<!DOCTYPE html>
<!-- Added by kama (used) -->
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<aside class="sidebar">
    <h1><i class ='fas fa-address-book'></i>goBLOG</h1></br>
    <nav class="sideNav">
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

        <div class="logoutWrapper">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logoutBtn">
                    <i class="fas fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </nav>
</aside>
