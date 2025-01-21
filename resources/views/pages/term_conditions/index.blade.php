@extends('layouts.main', ['menu' => 'menu_term_condition'])
@section('style')
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_term_condition') }}
@endsection
@section('page-title')
    Setting Term & Condition
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-1">Term & Condition</h6>
                        </div>
                        @if ($term)
                            <div class="col-md-6 text-end">
                                <a href="{{ route('edit_term_condition', ['id' => $term->id]) }}"
                                    class="btn btn-outline-primary btn-sm px-2"><span class="fas fs-5 fa-edit"></span> Edit
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="card-body p-3" style="min-height: 50vh">
                    <div class="row">
                        @if (!$term)
                            <div class="col-12 d-flex justify-content-center mt-4">
                                <img src="{{ url('/') }}/assets/images/404.svg" class="img-fluid mb-2 w-50"
                                    alt="404" />
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <a href="{{ route('create_term_condition') }}" class="btn bg-gradient-primary"><i
                                        class="fas fa-plus me-sm-2"></i> Add
                                    Term & Condition</a>
                            </div>
                        @endif
                        @if ($term)
                            <div class="col-12 px-4">
                                {!! $term->description !!}
                            </div>
                        @endif

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
