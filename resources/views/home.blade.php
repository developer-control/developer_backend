@extends('layouts.main', ['menu' => 'home'])
@section('style')
    <!-- Theme included stylesheets -->
    {{-- <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script> --}}
    {{-- <link href="https://unpkg.com/quill-image-uploader@1.2.4/dist/quill.imageUploader.min.css" rel="stylesheet" /> --}}
    {{-- <script src="https://unpkg.com/quill-image-uploader@1.2.4/dist/quill.imageUploader.min.js"></script> --}}

    <link href="{{ url('/') }}/assets/quill/image-uploader/dist/quill.snow.css" rel="stylesheet" />
    <link href="{{ url('/') }}/assets/quill/image-uploader/dist/quill.imageUploader.min.css" rel="stylesheet" />
    <script src="{{ url('/') }}/assets/quill/image-uploader/dist/quill.min.js"></script>
    <script src="{{ url('/') }}/assets/quill/image-uploader/dist/quill.imageUploader.min.js"></script>
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('home') }}
@endsection
@section('page-title')
    Dashboard
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-md-9 col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Authors table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-3">
                            <div id="quill-editor">
                            </div>
                            <textarea name="content" id="quill-content" class="form-control mt-2 d-none" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ url('/') }}/assets/js/quill-main.js"></script>
@endsection
