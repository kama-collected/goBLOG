<!DOCTYPE html>
<!-- Added by kama (used) -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" upload="width=device-width, initial-scale=1">

        <title>Blog</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <script src="{{ asset('js/like.js') }}"></script>

        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f0f2f5;
                padding: 10px;
            }

            .content {
                margin: 1rem auto;
                width: 60%;
                background-color: white;
                padding: 2rem;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                color: #333;
            }

            .content h1 {
                font-size: 2rem;
                color: #333;
                margin-bottom: 1.5rem;
            }

            .content h2{
                font-size: 20px;
            }

            .content i {
                margin-right: 10px;
                margin-bottom: 10px;
                background-color: #f0f2f5;
                border-radius: 10px;
                padding: 15px;
            }

            .content img {
                margin: 0 20%;
                width: 60%;
            }

            .post-text {
                margin-bottom: 1.5rem;
                font-size: 1rem;
                text-align: justify;
                padding: 15px;
                border-bottom: 1px solid #ccc;
            }

            .top-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            /* Left side user info */
            .to-user {
                display: flex;
                align-items: center;
            }

            .to-user i {
                background-color: #f0f2f5;
                margin-right: 10px;
            }

            .to-user h2 {
                margin: 0;
                font-size: 1.2rem;
                cursor:pointer;
            }

            .to-user i:hover,
            .to-user h2:hover {
                color: #27ae60;
            }

            /* Right side icon */
            .edit-post i {
                background-color: inherit;
                padding: 10px;
                cursor: pointer;
            }

            .edit-post i:hover {
                background-color: #f0f2f5;
                color: #27ae60;
                border-radius: 25%;
            }

            .content button {
                background-color: #fff;
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                margin-left: 10px;
                border-radius: 8px;
                cursor: pointer;
                transition: background 0.3s;
                font-size: 0.9rem;
            }

            .content button:hover {
                background-color: #f0f2f5;
                color: #27ae60;
            }

            .interact {
                margin-top: 10px; 
                display: flex; 
                gap: 10px; 
                align-items: left;
            }

            .interact form{
                display: flex;
                box-shadow: 0 0 0 0;
                padding: 0;
                border:0;
                margin: 0;
            }

            .interact i {
                margin-bottom: 0;
            }

            .interact button{
                background: none;
                padding: 6px;
            }

            .interact button:hover{
                background: none;
            }

            .interact a {
                background: none;
                margin-left:auto;
                padding: 6px;
            }

            .interact a:hover{
                background: none;
                color: #27ae60;
            }

            .like-content {
                display: flex;
                align-items: center;
                gap: 6px;
                width: 40px;
            }

            .like-count {
                font-size: 14px;
                color: #777;
                margin-right:10px;
            }

            .like-btn {
                width: auto;
                color: white;
                transition: color 0.3s ease;
                display: flex;
                align-items: center;
                padding: 6px;
                gap: 8px;
            }

            .like-btn.liked {
                color: #27ae60;
            }

            .menu-wrapper {
                position: relative;
                display: inline-block;
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
                padding-right: 20px;
                width:100%;
            }

            .menu a{
                margin-left: 10px;
                margin-right: 20px;
                margin-bottom: 4px;
                width: 70%;
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
            }

            .menu a:hover,
            .menu form button:hover {
                background-color: #f0f2f5;
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

        <div class="content">
            <h1>Posts</h1>
            @foreach($contents as $content)
                <div class="post-text">

                    <!-- Top row of the feed page  -->
                    <div class='top-row'>
                        <div class='to-user'>
                            <h2><i class='fas fa-user'></i>{{$user->name}}</h2>
                        </div>

                        <div class='edit-post'>
                        @if(auth()->id() === $content->user_id)
                        <div class="menu-wrapper">
                            <i class='fas fa-ellipsis-vertical' onclick="toggleMenu(this)"></i>
                            <div class="menu hidden">
                                <a href="{{ route('content.edit', ['content_id' => $content->content_id]) }}">Edit</a>
                                <form method="POST" action="{{ route('content.delete', ['content_id' => $content->content_id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endif
                        </div>
                    </div>

                    <!-- Image section of the feed page -->
                    @if(!empty($content->img_dir))
                        <image src="/images/{{ $content->img_dir }}" alt="Image"> </br>
                    @endif

                    <!-- Text, url and see more button of the feed page -->
                    @if(strlen($content->content_text) > $charLimit)
                        <span class="preview">{{Str::limit($content->content_text, $charLimit)}}</span>
                        <span class="full-text" style="display:none;">{{ $content->content_text }} </br> <a style='color:blue;'href='{{$content->url}}'> {{ $content->url }} </a> </span>
                        <button class="see-more-btn" onclick="toggleText(this)">See more...</button>
                    @else
                        <span>{{ $content->content_text }} </br> <a style='color:blue' href='{{$content->url}}'> {{ $content->url }} </a> </span>
                    @endif

                    <!-- Like and comment buttons -->
                    <div class='interact'>
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
