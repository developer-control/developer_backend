@extends('layouts.main')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/choices/css/choices.min.css') }}">
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
            background-color: #fff !important;
        }

        .choices__list--multiple .choices__item {
            border-radius: 8px;
        }
    </style>
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('create_developer_bank') }}
@endsection
@section('page-title')
    Create Developer Bank
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">Create Developer Bank</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route($this_route . 'store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <div class="form-group">
                                        <div class="image-preview form-control @error('image') is-invalid @enderror"
                                            onclick="triggerFileInput(this)">
                                            <img class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                                src="{{ storage_url(old('image'), null, asset('/assets/images/choose_file_3x1.jpg')) }}"
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
                                </div>
                                <div class="col-md-7 mb-3">

                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Input nama bank"
                                            value="{{ old('name') }}" required>
                                        <label for="name">Nama Bank</label>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text"
                                            class="form-control @error('account_name') is-invalid @enderror"
                                            id="account_name" name="account_name" placeholder="Input nama akun"
                                            value="{{ old('account_name') }}" required>
                                        <label for="account_name">Nama Akun</label>
                                        @error('account_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-floating mb-2">
                                        <input type="text"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            id="account_number" name="account_number" placeholder="Input Nomor Rekening"
                                            value="{{ old('account_number') }}" required>
                                        <label for="account_number">Nomor Rekening</label>
                                        @error('account_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    @hasrole('superadmin')
                                        <div class="form-group">
                                            <label for="" class="col-form-label">Developer:</label>
                                            <select class="form-select @error('developer_id') is-invalid @enderror"
                                                aria-label="" name="developer_id" id="developer_id">
                                            </select>
                                            <input type="hidden" id="old_developer" value="{{ old('developer_id') }}">
                                            @error('developer_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endhasrole
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
    <script src="{{ asset('assets/js/custom-choices.js') }}"></script>
    <script src="{{ asset('assets/choices/js/choices.min.js') }}"></script>
    <script>
        let developerOption;
        document.addEventListener('DOMContentLoaded', function() {
            const optionDeveloper = document.getElementById('developer_id');

            if (optionDeveloper) {
                setInputChoices("{{ route('developer.option') }}").then(choices => {
                    const oldDeveloper = document.getElementById('old_developer');
                    let id = oldDeveloper.value ? Number(oldDeveloper.value) : null;
                    developerOption = initializeChoice(optionDeveloper, choices, id);
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
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

                fetch("/images/developer-bank-image", {
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
