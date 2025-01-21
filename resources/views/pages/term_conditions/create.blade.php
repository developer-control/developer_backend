@extends('layouts.main', ['menu' => 'menu_term_condition'])
@section('style')
    <style>
    </style>
    <link href="{{ asset('assets/quill/image-uploader/dist/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/quill/image-uploader/dist/quill.imageUploader.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/quill/image-uploader/dist/quill.min.js') }}"></script>
    <script src="{{ asset('assets/quill/image-uploader/dist/quill.imageUploader.min.js') }}"></script>
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('create_term_condition') }}
@endsection
@section('page-title')
    Create Term Condition
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">Create Term Condition</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('store_term_condition') }}" enctype="multipart/form-data" method="POST">
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
                                <div id="quill-editor">{!! old('description') !!}
                                </div>
                                <textarea name="description" id="quill-content"
                                    class="form-control mt-2 d-none @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
    <script src="{{ asset('assets/js/quill-main.js') }}"></script>
@endsection
