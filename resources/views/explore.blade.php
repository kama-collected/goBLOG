<!DOCTYPE html>
<html>
    <head>
        <title>Explore</title>

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/content.js'])

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    </head>
    <body>
        @include('layouts.sidebar')
        @php
            $charLimit = 200;
        @endphp

        <div class="content-container">
            <h1>Explore</h1>
            @foreach($contents as $content)
                <div class="content">

                    <!-- Content Header  -->
                    <div class='content-header'>
                        <div class='content-header-user'>
                            <h2><a href="{{ route('content.exploreUser', ['user_id' => $content->user->user_id])}}"><i class='fas fa-user'></i>{{$content->user->name}}</a></h2>
                        </div>

                        <div class='content-header-menu'>
                        @if(auth()->id() === $content->user_id)
                        <div class="menu-wrapper">
                            <i class='fas fa-ellipsis-vertical' onclick="toggleMenu(this)"></i>
                            <div class="menu hidden">
                                <a href="{{ route('content.edit', ['content_id' => $content->content_id]) }}"><i class='fas fa-edit'></i>Edit</a>
                                <form method="POST" action="{{ route('content.delete', ['content_id' => $content->content_id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    
                                    <button type="submit"><i class='fas fa-trash-can'></i>Delete</button>
                                </form>
                            </div>
                        </div>
                        @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class='content-post'>
                        @if(!empty($content->img_dir))
                            <image src="/images/{{ $content->img_dir }}" alt="Image"> </br>
                        @endif

                        @if(strlen($content->content_text) > $charLimit)
                            <span class="preview">{{Str::limit($content->content_text, $charLimit)}}</span>
                            <span class="full-text" style="display:none;">{{ $content->content_text }} </br> <a href='{{$content->url}}'> {{ $content->url }} </a> </span>
                            <button class="see-more-btn" onclick="toggleText(this)">See more...</button>
                        @else
                            <span>{{ $content->content_text }} </br> <a href='{{$content->url}}'> {{ $content->url }} </a> </span>
                        @endif
                    </div>

                    <!-- Content Footer -->
                    <div class='content-footer'>
                        <form class="like-form" data-content-id="{{ $content->content_id }}" data-liked="{{ in_array($content->content_id, $likedContentIDs) ? '1' : '0' }}">
                            @csrf
                            <button type="submit"
                                    class="like-btn {{ in_array($content->content_id, $likedContentIDs) ? 'liked' : '' }}">
                                <span class="like-content">
                                    <span class="like-count">{{ $content->likes_count }}</span>
                                    <i class="fas fa-thumbs-up"></i>
                                    <span class="like-label">Likes</span>
                                </span>
                            </button>
                        </form>

                        <a href="{{ route('content.show', ['content_id' => $content->content_id]) }}" class="comment-btn">
                            <span class="comment-content">
                                <span class="comment-count">{{ $content->comments_count }}</span>
                                <i class="fas fa-comment"></i>
                                <span class="comment-label">Comments</span>
                            </span>
                        </a>

                    </div>

                </div>
            @endforeach
        </div>

    </body>
</html>