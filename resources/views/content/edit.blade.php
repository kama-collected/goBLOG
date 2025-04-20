<!DOCTYPE html>
<html>
    <head>
        <title>Edit Post</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>
    @include('layouts.sidebar')
        <div class='upload-container'>
            <form action="{{ route('content.update', ['content_id' => $content->content_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="upload-form">
                    <div class="upload_text">
                        <textarea id="text_upload" name="text_upload" rows="4" columns="16">{{ $content->content_text }}</textarea>
                    </div>

                    <div class="upload-additional">
                        <label for="link">Add URL</label>
                        <input type="url" id="urllink" name="urllink" value="{{ $content->url }}" placeholder="http://example.com">

                        <label for="img_dir" class="btn">
                            <i class="fas fa-camera"></i>Change Image
                        </label>
                        <input type="file" id="img_dir" name="img_dir" accept="image/*" style="display:none">

                        @if ($content->img_dir)
                            <div class="preview-image">
                                <p>Current Image:</p>
                                <img src="{{ asset('images/' . $content->img_dir) }}" alt="Current image">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="upload-submission">
                    <button type="submit">Update <i class="fas fa-square-arrow-up-right"></i></button>
                </div>
            </form>
        </div>
    </body>
</html>
