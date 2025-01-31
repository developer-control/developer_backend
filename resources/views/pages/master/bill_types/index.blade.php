@extends('layouts.main', ['menu' => 'menu_bill_type'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_bill_type') }}
@endsection
@section('page-title')
    Master Type Tagihan
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Master Type Tagihan</h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create"><i class="fas fa-plus me-sm-2"></i> Add
                                    Type Tagihan</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table class="table align-items-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No.
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Modify Title
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Premium Type
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Input Start Value
                                        </th>
                                        <th class="text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create-->
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="createModalRole"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Type Tagihan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('store_bill_type') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="" class="col-form-label">Name:</label>
                            <input class="form-control @error('name') is-invalid @enderror" placeholder="Input Name..."
                                type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Subscribtion Type:</label>
                            <input class="form-control @error('premium_type') is-invalid @enderror"
                                placeholder="Subscription type..." type="text" name="premium_type"
                                value="{{ old('premium_type') }}">
                            @error('premium_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_premium" name="is_premium"
                                value="1">
                            <label class="form-check-label" for="is_premium">Premium Type</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_edit" name="is_edit" value="1">
                            <label class="form-check-label" for="is_edit">Edit Title</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="with_start_value" name="with_start_value"
                                value="1">
                            <label class="form-check-label" for="with_start_value">Input Start Value</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Create-->
    <!-- Modal Edit-->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="editModalRole"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Type Tagihan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" id="edit-form" method="POST">
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <label for="bill_type-name" class="col-form-label">Nama:</label>
                            <input class="form-control @error('name') is-invalid @enderror" placeholder="" type="text"
                                id="bill_type-name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Subscribtion Type:</label>
                            <input class="form-control @error('premium_type') is-invalid @enderror" placeholder=""
                                type="text" name="premium_type" id="bill_type-premium_type"
                                value="{{ old('premium_type') }}">
                            @error('premium_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="bill_type-is_premium" name="is_premium"
                                value="1">
                            <label class="form-check-label" for="bill_type-is_premium">Premium Type</label>

                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="bill_type-is_edit" name="is_edit"
                                value="1">
                            <label class="form-check-label" for="bill_type-is_edit">Edit Title</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="bill_type-with_start_value"
                                name="with_start_value" value="1">
                            <label class="form-check-label" for="bill_type-with_start_value">Input Start Value</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Edit-->
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
                        <button type="button" class="btn bg-gradient-info ml-auto"
                            data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Delete-->
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/responsive.bootstrap5.js') }}"></script>
    <script>
        $(function() {
            let columnData = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'is_edit',
                    name: 'is_edit',
                    searchable: false
                },
                {
                    data: 'premium_type',
                    name: 'premium_type'
                },
                {
                    data: 'with_start_value',
                    name: 'with_start_value',
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ];
            let url = {
                url: "/bill-types/datatable"
            };
            initializeDatatable('.datatable', url, columnData)

        });
        $(document).on("click", ".edit-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            $("#bill_type-name").val(name);
            let premium_type = $(this).data('premium_type');
            $("#bill_type-premium_type").val(premium_type);
            let is_edit = $(this).data('is_edit');
            if (is_edit == 1) {
                $("#bill_type-is_edit").prop("checked", true);
            }
            let is_premium = $(this).data('is_premium');
            if (is_premium == 1) {
                $("#bill_type-is_premium").prop("checked", true);
            }
            let with_start_value = $(this).data('with_start_value');
            if (with_start_value == 1) {
                $("#bill_type-with_start_value").prop("checked", true);
            }
            $('#edit-form').attr('action', url);
        });
        $(document).on("click", ".delete-modal", function() {
            let url = $(this).data('url');
            let title = $(this).data('title');
            $("#delete-text").html(`Apa anda yakin menghapus type tagihan ${title}?`);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection
