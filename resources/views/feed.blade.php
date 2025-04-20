<!DOCTYPE html>
<!-- Added by kama (used) -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" upload="width=device-width, initial-scale=1">

        <title>Blog</title>

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/app.css'])

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <script src="{{ asset('js/like.js') }}"></script>

        <style>

            .menu-wrapper {
                position: relative;
                display: flex;
            }
            .menu {
                position: absolute;
                top: 30px;
                right: 0;
                background-color: white;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                padding: 10px;
                z-index: 100;
            }
            .menu form {
                width:100%;
            }

            .menu a{
                margin-left: 10px;
                margin-right: 20px;
                margin-bottom: 4px;

                border-radius: 8px;
            }
            .menu a,
            .menu form button {
                display: block;
                padding: 5px 10px;
                text-align: left;
                background: none;
                border: none;
                font: inherit;
                cursor: pointer;
                color: #333;
                padding: 5px 40px 5px 40px;
            }
            .menu a:hover,
            .menu form button:hover {
                background-color:inherit;
                color: #27ae60;
            }

            .hidden {
                display: none;
            }


        </style>   
    </head>
    <body>
        @include('layouts.sidebar')
        @include('layouts.upload')
        @php
            $charLimit = 200; // Character limit before showing "See more"
        @endphp

        <div class="content-container">
            <h1>Posts</h1>
            @foreach($contents as $content)
                <div class="content">

                    <!-- Content Header  -->
                    <div class='content-header'>
                        <div class='content-header-user'>
                            <h2><i class='fas fa-user'></i>{{$user->name}}</h2>
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
                                    <span class="like-label">Like</span>
                                </span>
                            </button>
                        </form>

                        <a href="{{ route('content.show', ['content_id' => $content->content_id]) }}" class="comment-btn">
                            <i class="fas fa-comment"></i> Comment
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </body>
</html>
