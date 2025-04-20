<!DOCTYPE html>
<!-- Added by kama (used) -->
<html>
    <head>
        <title>Upload</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>
        <div class='upload-container'>
        <form action='/store' method='POST'>
            @csrf
            <div class="upload-form">
                <div class="upload_text">
                    <textarea id="text_upload" name="text_upload" rows="4" columns="16" placeholder="Write what's on your mind..."></textarea>
                </div>
                <div class="upload-additional">
                    <label for="link">Add URL</label>
                    <input type="url" id="urllink" name="urllink" placeholder="http://example.com">
                    <label for="img_dir" class="btn"><i class="fas fa-camera"></i>Add Image</label>
                    <input type="file" id="img_dir" name="img_dir" accept="image/*" style="display:none">
                </div>
            </div>

            <div class="upload-submission">
                <button type="submit">Post <i class="fas fa-square-arrow-up-right"></i></button>
            </div>
        </form>
        </div>
    </body>
</html>