<!-- unused -->
@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    {{-- Top Right User Icon --}}
    <div class="d-flex justify-content-end mb-3">
        @auth
            <a href="{{ route('users.profile', auth()->id()) }}" class="text-decoration-none" title="My Profile">
                <i class="fas fa-user-circle fa-2x text-primary"></i>
            </a>
        @else
            <a href="{{ route('login') }}" class="text-decoration-none" title="Login">
                <i class="fas fa-user-circle fa-2x text-secondary"></i>
            </a>
        @endauth
    </div>

    {{-- Filter and Sorting Options --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <h2 class="mb-0">Contents</h2>
        <div class="d-flex flex-column flex-sm-row gap-3 w-100 w-md-auto">
            <form method="GET" action="{{ route('home') }}" class="d-flex flex-column flex-sm-row gap-3 w-100">
                {{-- Sort Options --}}
                <select name="sort" onchange="this.form.submit()" class="form-select">
                    <option value="latest" {{ $currentSort == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="popular" {{ $currentSort == 'popular' ? 'selected' : '' }}>Most Liked</option>
                    <option value="commented" {{ $currentSort == 'commented' ? 'selected' : '' }}>Most Commented</option>
                    <option value="oldest" {{ $currentSort == 'oldest' ? 'selected' : '' }}>Oldest</option>
                </select>
            </form>
            
            {{-- New Content Button --}}
            @auth
                <a href="{{ route('contents.create') }}" class="btn btn-success flex-shrink-0">
                    <i class="fas fa-plus me-1"></i> New Content
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-success flex-shrink-0">
                    <i class="fas fa-plus me-1"></i> New Content
                </a>
            @endauth
        </div>
    </div>

    {{-- Content List --}}
    @if($contents->isEmpty())
        <div class="alert alert-info">
            No contents found. Be the first to create one!
        </div>
    @else
        @foreach ($contents as $content)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h4>
                        <a href="{{ route('contents.show', $content) }}" class="text-decoration-none">{{ $content->title }}</a>
                    </h4>
                    
                    {{-- Display categories if they exist --}}
                    @if($content->categories->isNotEmpty())
                        <div class="mb-2">
                            @foreach($content->categories as $category)
                                <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    {{-- Like button and comment count --}}
                    <div class="d-flex gap-2 mt-3">
                        @auth
                            <form action="{{ route('contents.like', $content) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-heart me-1"></i> 
                                    <span class="ms-1">{{ $content->likes_count }} likes</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-heart me-1"></i> 
                                <span class="ms-1">{{ $content->likes_count }} likes</span>
                            </a>
                        @endauth
                        
                        <a href="{{ route('contents.show', $content) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-comment me-1"></i> 
                            <span class="ms-1">{{ $content->comments_count }} comments</span>
                        </a>
                    </div>
                </div>
                <div class="card-footer text-muted d-flex justify-content-between align-items-center">
                    <small>
                        Posted by <a href="{{ route('users.profile', $content->user_id) }}" class="text-decoration-none">{{ $content->user->name }}</a>
                    </small>
                    <small>{{ $content->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $contents->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif
@endsection