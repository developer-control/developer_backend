@extends('layouts.main', ['menu' => 'menu_facility'])
@section('style')
    <link rel="stylesheet" href="{{ url('/') }}/assets/choices/css/choices.min.css">
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

        .choices__inner {
            border-radius: 8px;
            padding: .5rem .75rem;
        }

        .choices__list--multiple .choices__item {
            border-radius: 8px;
        }
    </style>
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('edit_facility', $facility) }}
@endsection
@section('page-title')
    Edit Facility
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">Edit Facility</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('update_facility', ['id' => $facility->id]) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="" class="col-form-label">Project:</label>
                                <select class="form-select @error('project_id') is-invalid @enderror" aria-label=""
                                    name="project_id" id="project_id" required>
                                    <option value="{{ $facility->project_id }}"selected>{{ $facility->project->name }}
                                    </option>
                                </select>
                                @error('project_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="title" class="col-form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Input title"
                                    value="{{ old('title') ?? $facility->title }}">

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
                                        $image = old('image') ?? $facility->image;
                                    @endphp
                                    <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                        src="{{ storage_url($image) }}" alt="Image Preview">
                                    <p class="fw-bold d-none" id="loading-image">Uploading...</p>
                                </div>
                                <input type="file" accept="image/*" onchange="uploadImage(this)" hidden>
                                <input type="hidden" name="image" value="{{ old('image') ?? $facility->image }}">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-floating">
                                <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Leave a description here"
                                    id="description" name="description" style="height: 200px">{{ old('description') ?? $facility->description }}</textarea>
                                <label for="description">Description</label>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch ps-0">
                                    <input class="form-check-input ms-auto" type="checkbox" id="is_active" name="is_active"
                                        value="1"
                                        {{ old('is_active') ? 'checked' : ($facility->is_active ? 'checked' : null) }}>
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0"
                                        for="is_active">Facility Active</label>
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
    <script src="{{ url('/') }}/assets/js/custom-choices.js"></script>
    <script src="{{ url('/') }}/assets/choices/js/choices.min.js"></script>
    <script>
        let projectOption;
        document.addEventListener('DOMContentLoaded', function() {
            setInputChoices('/projects/option-projects').then(choices => {
                // set input for filter project for get area
                // set option for create and update area for get option projects
                const optionProject = document.getElementById('project_id');
                projectOption = initializeChoice(optionProject, choices);
            }).catch(error => {
                console.error('Error:', error);
            });
        })
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

                fetch("/images/facility-image", {
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
