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
<a href="{{ url('/feed/' . Auth::user()->name . '/' . Auth::user()->user_id) }}" class="btn btn-outline-dark mb-3">
    ← Back to My Feed
</a>

<form action="{{ route('content.search') }}" method="GET" class="d-flex">
    <input type="text" name="query" class="form-control me-2" placeholder="Search posts...">
    <button type="submit" class="btn btn-outline-success">Search</button>
</form>`
<div class="container mt-4">
    <h2>Search Results for "{{ $query }}"</h2>

    @if ($results->isEmpty())
        <p>No matching content found.</p>
    @else
    @foreach ($results as $content)
    <div class="card p-3 mb-3">
        <h4>{{ $content->content_title }}</h4>
        <p>{{ $content->content_body }}</p>
        <small>By {{ $content->user->name ?? 'Unknown User' }}</small>
    </div>
@endforeach
    @endif
</div>
@endsection
