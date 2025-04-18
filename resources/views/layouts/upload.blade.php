<!DOCTYPE html>
<!-- Added by kama (used) -->
<html>
    <head>
        <title>Upload</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style> 
            form {
                display: block;
                margin: auto;
                width: 60%;
                padding: 2rem;
                background-color: white;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                font-family: Arial, sans-serif;
                color: #333;
            }

            textarea{
                width: 100%;
                padding: 0.75rem;
                margin-bottom: 1rem;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 1rem;
            }

            input[type="url"] {
                margin-left:10px;
                padding: 3px;
                width: 50%;
                border: 1px solid #ccc;
                border-radius: 8px;

            }

            .additional-upload i {
            margin-right: 10px;
            }

            label.btn {
                display: inline-block;
                background-color: #27ae60;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.3s;
                margin-left: 10px;
            }

            label.btn:hover {
                background-color: #219150;
                color: #27ae60;
            }

            .submission {
                margin-top: 10px;
                text-align: right;
            }

            .submission button {
                padding: 3px 1.25rem;
                font-size: 1.5rem;
                color: white;
                background-color: #27ae60;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: background 0.3s;
            }

            .submission button:hover {
                background-color: #219150;
                color: #27ae60;
            }
        </style>
    </head>

    <body>
        <form action='/store' method='POST'>
            @csrf
            <div class="upload">
                <div class="main-upload">
                    <textarea id="text_upload" name="text_upload" rows="4" columns="16" placeholder="Write what's on your mind..."></textarea>
                </div>
                <div class="additional-upload">
                    <label for="link">Add URL</label>
                    <input type="url" id="urllink" name="urllink" placeholder="http://example.com">
                    <label for="img_dir" class="btn"><i class="fas fa-camera"></i>Add Image</label>
                    <input type="file" id="img_dir" name="img_dir" accept="image/*" style="display:none">
                </div>
            </div>
            <div class="submission">
                <button type="submit"><i class="fas fa-square-arrow-up-right"></i></button>
            </div>
        </form>
    </body>
</html>