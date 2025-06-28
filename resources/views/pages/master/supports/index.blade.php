@extends('layouts.main')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/choices/css/choices.min.css') }}">
    <style>
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
    {{ Breadcrumbs::render('menu_support') }}
@endsection
@section('page-title')
    Data Kontak Bantuan
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Data Kontak Bantuan</h6>
                            </div>
                            <div class="col-md-6 text-end">
                                @officeCan($this_perm . 'create')
                                    <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-create"><i class="fas fa-plus me-sm-2"></i> Add
                                        Bantuan</button>
                                @endofficeCan
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
                                            Develoepr
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Type
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kontak Bantuan
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
                    <h5 class="modal-title" id="exampleModalLabel">Buat Bantuan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route($this_route . 'store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @hasrole('superadmin')
                            <div class="form-group">
                                <label for="" class="col-form-label">Developer:</label>
                                <select class="form-select @error('developer_id') is-invalid @enderror" aria-label=""
                                    name="developer_id" id="developer_id">
                                </select>
                                @error('developer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endhasrole

                        <div class="form-group">
                            <label for="" class="col-form-label">Judul:</label>
                            <input class="form-control @error('title') is-invalid @enderror" placeholder="Title Bantuan..."
                                type="text" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Type:</label>
                            <select class="form-select @error('type') is-invalid @enderror" aria-label="" name="type"
                                id="type" required>
                                <option value=""@if (old('type') == '') selected @endif>Pilih Type
                                    Bantuan...
                                </option>
                                <option value="email"@if (old('type') == 'email') selected @endif>Email</option>
                                <option value="whatsapp"@if (old('type') == 'whatsapp') selected @endif>Whatsapp</option>
                                <option value="telegram"@if (old('type') == 'telegram') selected @endif>Telegram</option>
                                <option value="number"@if (old('type') == 'number') selected @endif>Nomor Telepon
                                </option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Kontak Bantuan:</label>
                            <input class="form-control @error('value') is-invalid @enderror" placeholder="Kontak Bantuan..."
                                type="text" name="value" value="{{ old('value') }}" required>
                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Bantuan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" id="edit-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        @hasrole('superadmin')
                            <div class="form-group">
                                <label for="" class="col-form-label">Developer:</label>
                                <select class="form-select @error('developer_id') is-invalid @enderror" aria-label=""
                                    name="developer_id" id="developer_id-edit">
                                </select>
                                @error('developer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endhasrole

                        <div class="form-group">
                            <label for="title" class="col-form-label">Judul:</label>
                            <input class="form-control @error('title') is-invalid @enderror"
                                placeholder="Title Bantuan..." type="text" id="title-edit" name="title"
                                value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Type:</label>
                            <select class="form-select @error('type') is-invalid @enderror" aria-label=""
                                name="type" id="type-edit" required>
                                <option value="">Pilih Type Bantuan...</option>
                                <option value="email">Email</option>
                                <option value="whatsapp">Whatsapp</option>
                                <option value="telegram">Telegram</option>
                                <option value="number">Nomor Telepon</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Kontak Bantuan:</label>
                            <input class="form-control @error('value') is-invalid @enderror"
                                placeholder="Kontak Bantuan..." type="text" name="value" id="value-edit"
                                value="{{ old('value') }}" required>
                            @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

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
    <script src="{{ asset('assets/js/custom-choices.js') }}"></script>
    <script src="{{ asset('assets/choices/js/choices.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/responsive.bootstrap5.js') }}"></script>
    <script>
        let developerCreate, developerEdit;
        document.addEventListener('DOMContentLoaded', function() {
            const optionDeveloperCreate = document.getElementById('developer_id');
            const optionDeveloperEdit = document.getElementById('developer_id-edit');
            if (optionDeveloperCreate && optionDeveloperEdit) {
                setInputChoices("{{ route('developer.option') }}").then(choices => {
                    developerCreate = initializeChoice(optionDeveloperCreate, choices);
                    developerEdit = initializeChoice(optionDeveloperEdit, choices);
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
        })
        $(function() {
            let columnData = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'developer.name',
                    name: 'developer.name'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'value',
                    name: 'value'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ];
            initializeDatatable('.datatable', "{{ route($this_route . 'data') }}", columnData)

        });
        $(document).on("click", ".edit-modal", function() {
            let url = $(this).data('url');
            let title = $(this).data('title');
            let type = $(this).data('type');
            let value = $(this).data('value');
            let developer_id = $(this).data('developer_id');
            $("#title-edit").val(title);
            $("#type-edit").val(type);
            $("#value-edit").val(value);
            if (developerEdit) {
                developerEdit.setChoiceByValue(developer_id);
            }
            $('#edit-form').attr('action', url);
        });
        $(document).on("click", ".delete-modal", function() {
            let url = $(this).data('url');
            let title = $(this).data('title');
            $("#delete-text").html(`Apa anda yakin menghapus bantuan ${title}?`);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection
