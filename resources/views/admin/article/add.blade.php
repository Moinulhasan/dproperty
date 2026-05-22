@extends('admin.master')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor {
        border-radius: 8px;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add New Article</h5>
                <a href="{{ route('admin.article.list') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
            <div class="card-body">
                @include('admin.include.alert')
                <form action="{{ route('admin.article.add.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label" for="article-title">Title</label>
                        <input type="text" class="form-control" id="article-title" name="title" placeholder="Enter article title" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="article-image">Feature Image</label>
                        <input type="file" class="form-control" id="article-image" name="image">
                        <div class="form-text">Recommended size: 800x600px</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="summernote">Content</label>
                        <textarea class="form-control" id="summernote" name="content">{{ old('content') }}</textarea>
                    </div>

                    <div class="divider divider-primary">
                        <div class="divider-text">SEO Information (Optional)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="meta-title">Meta Title</label>
                        <input type="text" class="form-control" id="meta-title" name="meta_title" value="{{ old('meta_title') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="meta-description">Meta Description</label>
                        <textarea class="form-control" id="meta-description" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="article-order">Order</label>
                            <input type="number" min="0" class="form-control" id="article-order" name="order" value="{{ old('order', 0) }}">
                            <div class="form-text">Lower number = shown first.</div>
                        </div>
                        <div class="col-md-9 mb-3 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                                <label class="form-check-input" for="status">Active Status</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Publish Article</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write your article content here...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
