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
<div class="admin-container">
    <h2>All Posts by {{ $user->name }}</h2>

    @if ($contents->isEmpty())
        <p>This user has not posted anything yet.</p>
    @else
        @foreach($contents as $content)
            <div class="card mb-4 p-3 border">
                <h4>{{ $content->title }}</h4>
                <p>{{ $content->body }}</p>
                <small>Posted on {{ $content->created_at->format('d M Y H:i') }}</small><br>

                {{-- Like count --}}
                <p><strong>Likes:</strong> {{ $content->likes->count() }}</p>

                {{-- Delete post button --}}
                <form action="{{ route('content.delete', $content->content_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete This Post</button>
                </form>

                {{-- Comments --}}
                <div class="mt-3">
                    <strong>Comments:</strong>
                    @if ($content->comments->isEmpty())
                        <p><em>No comments yet.</em></p>
                    @else
                        <ul>
                            @foreach($content->comments as $comment)
                                <li>
                                    {{ $comment->comment_text }}
                                    <small>— by {{ $comment->user->name ?? 'Unknown User' }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
<a href="{{ route('admindashboard') }}" class="btn btn-secondary mb-3">← Back to Admin Dashboard</a>

@endsection
