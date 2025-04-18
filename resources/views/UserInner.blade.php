@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="container">
    {{-- Profile Header --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-4">
                <div class="rounded-circle bg-primary p-3 text-white" style="width: 80px; height: 80px; font-size: 2rem; display: flex; align-items: center; justify-content: center;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="mb-1">{{ $user->name }}</h2>
                    <p class="text-muted mb-1">
                        <i class="fas fa-envelope me-1"></i> {{ $user->email }}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-calendar-alt me-1"></i> Joined {{ $user->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-end">
            @can('manage', $user)
                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-user-edit me-1"></i> Edit Profile
                </a>
                <a href="{{ route('user.settings') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-cog"></i>
                </a>
            @endcan
        </div>
    </div>

    {{-- Stats Overview --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Contents</h5>
                    <p class="display-6 mb-0">{{ $contents->total() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Comments</h5>
                    <p class="display-6 mb-0">{{ $commentsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Likes</h5>
                    <p class="display-6 mb-0">{{ $likesCount }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="contents-tab" data-bs-toggle="tab" data-bs-target="#contents" type="button" role="tab">
                <i class="fas fa-file-alt me-1"></i> Contents
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab">
                <i class="fas fa-comments me-1"></i> Comments
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="likes-tab" data-bs-toggle="tab" data-bs-target="#likes" type="button" role="tab">
                <i class="fas fa-heart me-1"></i> Likes
            </button>
        </li>
        @can('manage', $user)
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="drafts-tab" data-bs-toggle="tab" data-bs-target="#drafts" type="button" role="tab">
                <i class="fas fa-edit me-1"></i> Drafts
            </button>
        </li>
        @endcan
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content" id="profileTabsContent">
        {{-- Contents Tab --}}
        <div class="tab-pane fade show active" id="contents" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>My Contents</h4>
                <a href="{{ route('contents.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i> New Content
                </a>
            </div>
            
            @forelse ($contents as $content)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('contents.show', $content->id) }}" class="text-decoration-none">{{ $content->title }}</a>
                        <div class="d-flex gap-2">
                            @can('update', $content)
                                <a href="{{ route('contents.edit', $content->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('contents.destroy', $content->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this content?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ Str::limit($content->body, 150, '...') }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <span class="me-3"><i class="far fa-comment me-1"></i> {{ $content->comments_count }} comments</span>
                                <span><i class="far fa-heart me-1"></i> {{ $content->likes_count }} likes</span>
                            </div>
                            <a href="{{ route('contents.show', $content->id) }}" class="btn btn-sm btn-outline-secondary">
                                View Content <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-footer text-muted small">
                        Created {{ $content->created_at->diffForHumans() }}
                        @if($content->created_at != $content->updated_at)
                            • Edited {{ $content->updated_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    You haven't created any content yet. <a href="{{ route('contents.create') }}" class="alert-link">Create your first content</a>.
                </div>
            @endforelse

            {{ $contents->links() }}
        </div>

        {{-- Comments Tab --}}
        <div class="tab-pane fade" id="comments" role="tabpanel">
            <h4 class="mb-3">My Comments</h4>
            
            @forelse ($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-subtitle mb-2 text-muted">
                                On: <a href="{{ route('contents.show', $comment->content_id) }}">{{ $comment->content->title ?? '[Deleted Content]' }}</a>
                            </h6>
                            <div class="d-flex gap-2">
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="card-text">{{ $comment->comment_text }}</p>
                        <div class="text-muted small">
                            <i class="far fa-clock me-1"></i> {{ $comment->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    You haven't made any comments yet.
                </div>
            @endforelse

            {{ $comments->links() }}
        </div>

        {{-- Likes Tab --}}
        <div class="tab-pane fade" id="likes" role="tabpanel">
            <h4 class="mb-3">Liked Contents</h4>
            
            @forelse ($likedContents as $like)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title">
                                    <a href="{{ route('contents.show', $like->content->id) }}" class="text-decoration-none">
                                        {{ $like->content->title ?? '[Deleted Content]' }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">
                                    By {{ $like->content->user->name ?? '[Deleted User]' }}
                                </p>
                            </div>
                            <form action="{{ route('contents.unlike', $like->content_id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-heart-broken"></i> Unlike
                                </button>
                            </form>
                        </div>
                        <div class="text-muted small mt-2">
                            <i class="far fa-clock me-1"></i> Liked {{ $like->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    You haven't liked any contents yet.
                </div>
            @endforelse

            {{ $likedContents->links() }}
        </div>

        {{-- Drafts Tab (only visible to profile owner) --}}
        @can('manage', $user)
        <div class="tab-pane fade" id="drafts" role="tabpanel">
            <h4 class="mb-3">My Drafts</h4>
            
            @forelse ($drafts as $draft)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning text-dark">Draft</span>
                        <div class="d-flex gap-2">
                            <a href="{{ route('contents.edit', $draft->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('contents.destroy', $draft->id) }}" method="POST" onsubmit="return confirm('Delete this draft?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $draft->title }}</h5>
                        <p class="card-text">{{ Str::limit($draft->body, 150, '...') }}</p>
                    </div>
                    <div class="card-footer text-muted small">
                        Last updated {{ $draft->updated_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    You don't have any saved drafts.
                </div>
            @endforelse
        </div>
        @endcan
    </div>
</div>

@push('scripts')
<script>
    // Activate tab based on URL hash
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = new bootstrap.Tab(document.querySelector(`[data-bs-target="${hash}"]`));
            tabTrigger.show();
        }
    });
</script>
@endpush
@endsection
