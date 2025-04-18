@extends('layouts.app')
@section('title', 'Create New Post')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Create New Post
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('contents.store') }}" enctype="multipart/form-data" id="post-form">
                        @csrf

                        {{-- Text Content --}}
                        <div class="mb-3">
                            <label for="text" class="form-label">Post Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('text') is-invalid @enderror" 
                                      id="text" name="text" rows="8" 
                                      placeholder="What's on your mind?" required>{{ old('text') }}</textarea>
                            @error('text')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- URL Field --}}
                        <div class="mb-3">
                            <label for="url" class="form-label">Link (Optional)</label>
                            <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                   id="url" name="url" value="{{ old('url') }}" 
                                   placeholder="https://example.com">
                            @error('url')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-3">
                            <label for="img_dir" class="form-label">Upload Image (Optional)</label>
                            <input type="file" class="form-control @error('img_dir') is-invalid @enderror" 
                                   id="img_dir" name="img_dir" accept="image/*">
                            @error('img_dir')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">Max 2MB (JPEG, PNG, GIF)</div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Basic form validation
        document.getElementById('post-form').addEventListener('submit', function(e) {
            const textContent = document.getElementById('text').value.trim();
            if (!textContent) {
                e.preventDefault();
                alert('Post content cannot be empty!');
                document.getElementById('text').focus();
            }
        });
        
        // URL validation
        document.getElementById('url').addEventListener('blur', function() {
            const urlInput = this.value.trim();
            if (urlInput && !/^https?:\/\//i.test(urlInput)) {
                this.value = 'http://' + urlInput;
            }
        });
    });
</script>
@endpush
@endsection