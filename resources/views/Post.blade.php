@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $post->title }}</h2>
    <p class="text-muted">Posted by {{ $poster->name }} on {{ $post->created_at->format('Y-m-d H:i') }}</p>
    <p>{{ $post->body }}</p>

    {{-- Like Button --}}
    <form method="POST" action="{{ Auth::check() ? route('posts.like', $post->id) : route('login') }}">
        @csrf
        <button class="btn btn-danger mb-3">❤️</button>
        <span>{{ $post->likes_count ?? 0 }}</span>
    </form>

    {{-- Comments --}}
    <hr>
    <h4>💬 Comments</h4>
    @forelse ($comments as $comment)
        <div class="border rounded p-2 mb-2">
            <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment_text }}
            <div class="text-muted">{{ $comment->created_at->format('Y-m-d H:i') }}</div>
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse

    {{-- Comment Form --}}
    <hr>
    <h5>Write a Comment</h5>
    <form method="POST" action="{{ Auth::check() ? route('posts.comment', $post->id) : route('login') }}">
        @csrf
        <textarea name="comment_text" class="form-control mb-2" rows="3" required></textarea>
        <button class="btn btn-primary">Submit Comment</button>
    </form>
</div>
@endsection

