@extends('layouts.main', ['menu' => 'menu_article'])
@section('style')
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_article') }}
@endsection
@section('page-title')
    Article
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-1">Article</h6>
                            <p class="text-sm">Latest News</p>
                            <form action="{{ route('menu_article') }}" method="GET" class="">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="input-group">
                                            <span class="input-group-text text-body"><i class="fas fa-search"
                                                    aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" placeholder="Type here..."
                                                name="keyword" value="{{ old('keyword') ?? $request->keyword }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-dark" id="submit-form">
                                            Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('create_article') }}" class="btn bg-gradient-primary"><i
                                    class="fas fa-plus me-sm-2"></i> Add
                                Article</a>
                        </div>
                    </div>

                </div>
                <div class="card-body p-3">
                    <div class="row">
                        @if (!count($articles))
                            <div class="col-12 d-flex justify-content-center">
                                <img src="{{ url('/') }}/assets/images/404.svg" class="img-fluid mb-2 w-50"
                                    alt="404" />

                            </div>
                        @endif
                        @foreach ($articles as $article)
                            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                <div class="card card-blog card-plain">
                                    <div class="position-relative">
                                        <a class="d-block ratio ratio-16x9">
                                            <img src="{{ storage_url($article->image) }}" alt="img-blur-shadow"
                                                class="shadow border-radius-md object-fit-cover">
                                        </a>
                                        <div class="position-absolute top-100 end-0 btn-group">
                                            <a href="{{ route('edit_article', ['id' => $article->id]) }}"
                                                class="btn btn-link text-dark btn-sm mb-0 px-1"><span
                                                    class="fas fs-5 fa-edit"></span></a>
                                            <button type="button"
                                                class="btn btn-link text-dark btn-sm mb-0 px-1 delete-modal"
                                                data-bs-toggle="modal" data-bs-target="#modal-delete"
                                                data-url="{{ route('delete_article', ['id' => $article->id]) }}"
                                                data-title="{{ $article->title }}"><span
                                                    class="fas fs-5 fa-trash"></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body px-1 pb-0">
                                        {{-- <p class="text-secondary mb-0 text-sm">Project #2</p> --}}
                                        <a href="javascript:;">
                                            <h5 class="font-weight-bolder">
                                                {{ str($article->title)->limit(50) }}
                                            </h5>
                                        </a>

                                        <p class="mb-4 text-sm">
                                            {{ str($article->short_content)->limit(120) }}

                                        </p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            {{-- <button type="button"
                                                class="btn btn-outline-primary btn-sm mb-0 mx-2">Detail</button> --}}

                                            <div class="avatar-group mt-2">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12 d-flex justify-content-end">
                            {{ $articles->appends(request()->except('page'))->onEachSide(0)->links() }}
                        </div>
                        {{-- <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                            <div class="card h-100 card-plain border">
                                <div class="card-body d-flex flex-column justify-content-center text-center">
                                    <a href="javascript:;">
                                        <i class="fa fa-plus text-secondary mb-3"></i>
                                        <h5 class=" text-secondary"> New project </h5>
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete-->
    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="fas fa-exclamation-circle ni-3x"></i>
                        <h4 class="text-gradient text-danger mt-4 " id="delete-text">Apa Anda Yakin Menghapus Data ini?
                        </h4>

                    </div>
                </div>
                <div class="modal-footer">
                    <form action="" method="POST" id="delete-form">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn bg-gradient-info ml-auto" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End Modal Delete-->
@endsection
@section('scripts')
    <script>
        $(document).on("click", ".delete-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            $("#delete-text").html(`Apa anda yakin menghapus artikel ${name}?`);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection
