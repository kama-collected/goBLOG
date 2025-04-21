@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Profile</h1>
    <p>Welcome, {{ Auth::user()->name }}</p>
    <p>Email: {{ Auth::user()->email }}</p>
    <p>Role: {{ Auth::user()->role }}</p>
</div>
@endsection
