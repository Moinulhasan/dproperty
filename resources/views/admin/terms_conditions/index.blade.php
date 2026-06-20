@extends('admin.master')

@section('content')
    @include('admin.include.alert')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Terms &amp; Conditions</h5>
            <small class="text-muted">Shown on the property details page based on whether the property is for Buy or Sell.</small>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.terms-conditions.update') }}" method="POST">
                @csrf

                <ul class="nav nav-tabs mb-3" id="termsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy-pane" type="button" role="tab" aria-controls="buy-pane" aria-selected="true">
                            <i class="ti ti-shopping-cart me-1"></i> Buy Terms
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sell-tab" data-bs-toggle="tab" data-bs-target="#sell-pane" type="button" role="tab" aria-controls="sell-pane" aria-selected="false">
                            <i class="ti ti-coin me-1"></i> Sell Terms
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="termsTabContent">
                    <div class="tab-pane fade show active" id="buy-pane" role="tabpanel" aria-labelledby="buy-tab">
                        <label class="form-label" for="buy-editor">Buy Terms &amp; Conditions</label>
                        <textarea id="buy-editor" name="buy_terms">{{ old('buy_terms', $terms['buy']->content ?? '') }}</textarea>
                        @error('buy_terms')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="tab-pane fade" id="sell-pane" role="tabpanel" aria-labelledby="sell-tab">
                        <label class="form-label" for="sell-editor">Sell Terms &amp; Conditions</label>
                        <textarea id="sell-editor" name="sell_terms">{{ old('sell_terms', $terms['sell']->content ?? '') }}</textarea>
                        @error('sell_terms')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Save Terms
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor { background: #fff; }
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            const summernoteOptions = {
                tabsize: 2,
                height: 360,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            };

            // Init both at once. Summernote handles being inside a hidden
            // tab pane fine; if a sizing glitch shows up the first time the
            // Sell tab is opened, the shown.bs.tab handler below pokes it
            // to reflow.
            $('#buy-editor').summernote(summernoteOptions);
            $('#sell-editor').summernote(summernoteOptions);

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
                $(window).trigger('resize');
            });
        });
    </script>
@endsection
