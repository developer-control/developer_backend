@extends('layouts.main', ['menu' => 'menu_article'])
@section('style')
    <style>
        .image-preview {
            border: 2px dashed #ccc;
            cursor: pointer;
            position: relative;
            width: 100%;
            /* padding-top: 33.33%; */
            /* Rasio 3:1 */
            padding-top: 56.25%;
            /* Rasio 16:9 */
            overflow: hidden;
        }
    </style>
    <link href="{{ url('/') }}/assets/quill/image-uploader/dist/quill.snow.css" rel="stylesheet" />
    <link href="{{ url('/') }}/assets/quill/image-uploader/dist/quill.imageUploader.min.css" rel="stylesheet" />
    <script src="{{ url('/') }}/assets/quill/image-uploader/dist/quill.min.js"></script>
    <script src="{{ url('/') }}/assets/quill/image-uploader/dist/quill.imageUploader.min.js"></script>
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('create_article') }}
@endsection
@section('page-title')
    Create Article
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">Create Article</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('store_article') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Input title" value="{{ old('title') }}">
                                <label for="title">Title</label>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="image-preview form-control @error('image') is-invalid @enderror"
                                    onclick="triggerFileInput(this)">
                                    <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                        src="{{ storage_url(old('image'), null, url('/') . '/assets/images/choose_file_3x1.jpg') }}"
                                        alt="Image Preview">
                                    <p class="fw-bold d-none" id="loading-image">Uploading...</p>
                                </div>
                                <input type="file" accept="image/*" onchange="uploadImage(this)" hidden>
                                <input type="hidden" name="image" value="{{ old('image') }}">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-floating">
                                <textarea class="form-control @error('short_content') is-invalid @enderror"
                                    placeholder="Leave a description content here" id="short_content" name="short_content" style="height: 100px">{{ old('short_content') }}</textarea>
                                <label for="short_content">Short Content</label>
                                @error('short_content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div id="quill-editor">{!! old('content') !!}
                                </div>
                                <textarea name="content" id="quill-content" class="form-control mt-2 d-none" rows="5">{{ old('content') }}</textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5" id="submit-form"><i
                                        class="fa fa-save"></i>
                                    Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url('/') }}/assets/js/quill-main.js"></script>
    <script>
        // fungsi trigger untuk upload image
        function triggerFileInput(previewDiv) {
            const fileInput = previewDiv.nextElementSibling;
            fileInput.click();
        }
        // Function to preview the selected image
        function uploadImage(input) {
            const file = input.files[0];
            const previewDiv = input.previousElementSibling;
            let inputImage = input.nextElementSibling;
            const previewImage = previewDiv.querySelector("img");
            const buttonSubmit = document.getElementById("submit-form");
            // const removeBtn = input.nextElementSibling;

            if (file) {
                const loadingMessage = document.getElementById('loading-image');
                loadingMessage.classList.remove('d-none');
                previewImage.classList.add('d-none');
                buttonSubmit.classList.add('d-none');

                const formData = new FormData();
                formData.append("image", file);

                fetch("/images/article-image", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        // console.log('Success:', data);
                        loadingMessage.classList.add('d-none');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewImage.classList.remove('d-none'); // Show the image
                            buttonSubmit.classList.remove('d-none'); // Show button Submit
                        };
                        reader.readAsDataURL(file);
                        inputImage.value = data.path;
                    })
                    .catch((error) => {
                        previewImage.classList.remove('d-none');
                        console.error("Error:", error);
                    });
            }
        }
    </script>
@endsection
