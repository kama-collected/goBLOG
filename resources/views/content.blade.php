<!DOCTYPE html>
<html>
<head>
    <title>Content</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script src="{{ asset('js/like.js') }}"></script>


    <style>
        body {
            font-family: Arial, sans-serif;
            background: #222;
            padding: 10px;
            color: #ddd;
        }

        .content {
            margin: 1rem auto;
            width: 60%;
            background-color: #181a1b;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            color: #ddd;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .to-user {
            display: flex;
            align-items: center;
        }

        .to-user i {
            background-color: #333;
            margin-right: 10px;
            padding: 15px;
            border-radius: 10px;
        }

        .to-user h2 {
            margin: 0;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .to-user i:hover,
        .to-user h2:hover {
            color: #27ae60;
        }

        .edit-post i {
            background-color: inherit;
            padding: 10px;
            cursor: pointer;
        }

        .edit-post i:hover {
            background-color: #222;
            color: #27ae60;
            border-radius: 25%;
        }

        img {
            margin: 20px 0;
            width: 100%;
            border-radius: 10px;
        }

        .post-text {
            margin-bottom: 1.5rem;
            font-size: 1rem;
            text-align: justify;
            padding: 15px;
            border-bottom: 1px solid #444;
        }

        .comments-section {
            margin-top: 2rem;
        }

        .comments-section h2 {
            font-size: 20px;
            margin-bottom: 1rem;
            color: #ddd;
        }

        .comment {
            padding: 1rem;
            background: #2c2f31;
            border-radius: 8px;
            margin-bottom: 10px;
            color: #ccc;
        }

        .comment p {
            margin: 0.3rem 0;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #555;
            background-color: #2c2f31;
            color: #ddd;
            margin-top: 1rem;
            resize: none;
        }

        textarea:focus{
            border-color: #27ae60;
        outline: none;
            box-shadow: 0 0 0 2px rgba(39, 174, 96, 0.3);
        }

        button {
            background-color: #181a1b;
            border: none;
            padding: 0.5rem 1rem;
            margin-top: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 0.9rem;
            color: #ddd;
        }

        button:hover {
            background-color: #222;
            color: #27ae60;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .comment-user {
            margin: 0;
        }

        .comment-menu-wrapper form {
            margin: 0;
        }

        .comment-menu-wrapper form button {
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            padding: 0;
            margin-right: 10px;
            margin-top: 0;
        }

        .comment-menu-wrapper form button:hover {
            color: #e74c3c;
        }

        .hidden {
            display: none;
        }

        .interact {
            margin-top: 10px; 
            display: flex; 
            gap: 10px; 
            align-items: left;
        }

        .interact form {
            display: flex;
            box-shadow: 0 0 0 0;
            padding: 0;
            border: 0;
            margin: 0;
        }

        .interact i {
            background-color: #222;
            padding: 0;
            margin-bottom: 0;
        }

        .interact button {
            background: none;
            padding: 6px;
            color: #ccc;
        }

        .interact button:hover {
            background: none;
            color: #27ae60;
        }

        .interact a {
            background: none;
            margin-left: auto;
            padding: 6px;
            color: #ccc;
            text-decoration: none;
        }

        .interact a:hover {
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
            margin-right: 10px;
        }

        .like-btn {
            width: auto;
            color: #ccc;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            padding: 6px;
            gap: 8px;
        }

        .like-btn.liked {
            color: #27ae60;
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')
    <div class="content">
        <!-- Top row of the content page -->
        <div class='top-row'>
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

        <!-- Image section of the feed page -->
        <div class='content-post'>
            @if(!empty($content->img_dir))
                <img src="/images/{{ $content->img_dir }}" alt="Image" style="max-width: 100%; margin-top: 10px;"> </br>
            @endif

            <!-- Text and URL display (no "see more" logic needed) -->
            @if(!empty($content->content_text))
                <span>{{ $content->content_text }}</span><br>
            @endif

            @if(!empty($content->url))
                <a style='color:blue' href="{{ $content->url }}" target="_blank">{{ $content->url }}</a>
            @endif
        </div>

        <!-- Like button -->
        <div class='interact'>
            <form class="like-form" data-content-id="{{ $content->content_id }}">
                @csrf
                <button type="submit" class="like-btn">
                    <span class="like-content">
                        <span style='margin-left:10px;'class="like-count">{{ $content->likes()->count() }}</span>
                        <i style='padding:15px;background-color:#f0f2f5;border-radius:10px;font-size:20px;'class="fas fa-thumbs-up"></i>
                        <span class="like-label">Like</span>
                    </span>
                </button>
            </form>
        </div>

        <!-- Display comments -->
        <div class="comments-section">
            <h2 style='font-weight:bold'>Comments</h2>
            @foreach($comments as $comment)
                <div class="comment">
                    <div class="comment-header">
                        <p><strong>{{ $comment->user?->name ?? 'Deleted User' }}</strong> says:</p>

                        @if(auth()->id() === $comment->user_id)
                            <div class="comment-menu-wrapper">
                                <form method="POST" action="{{ route('comment.destroy', ['comment' => $comment->comment_id]) }}" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;cursor:pointer;">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                    <p>{{ $comment->comment_text }}</p>
                </div>
            @endforeach
        </div>

        <!-- Comment form -->
        <form action="{{ route('comment.store', ['content_id' => $content->content_id]) }}" method="POST">
            @csrf
            <textarea name="comment_text" placeholder="Add a comment..." required></textarea>
            <button style='display:flex;margin-left: auto;' type="submit">Post Comment
            <i style='display:flex;align-items:center;margin-left:10px;font-size:20px;' class='fas fa-comment-dots'></i></button>
        </form>
    </div>
</body>
</html>