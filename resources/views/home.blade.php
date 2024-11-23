@extends('layouts.main')
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
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Authors table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-3">

                            <div id="quill-editor">
                                <p>Select the image button from the toolbar</p>
                                <p><br /></p>
                                <p>The file will be past to your <b>Upload</b> function.</p>
                                <p><br /></p>
                                <p>Return a <b>Promise</b> that resolves as a url of an image</p>
                                <p><br /></p>
                                <p>
                                    This demo has a timeout to simulate uploading to a server and resolves
                                    as as url to an image
                                </p>
                            </div>
                            <textarea name="quill-content" id="quill-content" class="form-control d-none" rows="5"></textarea>
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
