@extends('layouts.main')
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
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('edit_banner', $banner) }}
@endsection
@section('page-title')
    Edit Banner
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">Edit Banner</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route($this_route . 'update', ['id' => $banner->id]) }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Input title"
                                    value="{{ old('title') ?? $banner->title }}">
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
                                    @php
                                        $image = old('image') ?? $banner->image;
                                    @endphp
                                    <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                        src="{{ storage_url($image) }}" alt="Image Preview">
                                    <p class="fw-bold d-none" id="loading-image">Uploading...</p>
                                </div>
                                <input type="file" accept="image/*" onchange="uploadImage(this)" hidden>
                                <input type="hidden" name="image" value="{{ old('image') ?? $banner->image }}">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-floating">
                                <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Leave a description content here"
                                    id="content" name="content" style="height: 200px">{{ old('content') ?? $banner->content }}</textarea>
                                <label for="content">Content</label>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch ps-0">
                                    <input class="form-check-input ms-auto" type="checkbox" id="is_active" name="is_active"
                                        value="1"
                                        {{ old('is_active') ? 'checked' : ($banner->is_active ? 'checked' : null) }}>
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                        for="is_active">Banner Active</label>
                                </div>
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

                fetch("/images/banner-image", {
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
