@extends('layouts.main', ['menu' => 'menu_unit'])
@section('style')
    <link rel="stylesheet" href="{{ url('/') }}/assets/src/plugins/datatables/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/src/plugins/datatables/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/choices/css/choices.min.css">
    <style>
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
    {{ Breadcrumbs::render('menu_unit') }}
@endsection
@section('page-title')
    Project Unit
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h4 class="ps-0">Filter Project Unit</h4>
                        <hr class="horizontal gray-light">
                    </div>
                    <form action="{{ route('menu_unit') }}" method="get">
                        <div class="card-body row px-4 pt-0">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="hidden" id="bloc" value="{{ $request->project_bloc_id }}">
                                    <select class="rounded form-select @error('project_bloc_id') is-invalid @enderror"
                                        aria-label="" name="project_bloc_id" id="filter-bloc">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 text-end">
                                <div class="form-group">
                                    <label for="" class="col-form-label"></label>
                                    <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Data Unit</h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create"><i class="fas fa-plus me-sm-2"></i> Add
                                    Unit</button>
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
                                            Bloc
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
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
                    <h5 class="modal-title" id="exampleModalLabel">New Unit</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('store_unit') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="" class="col-form-label">Project Bloc:</label>
                            <select class="form-select @error('project_bloc_id') is-invalid @enderror" aria-label=""
                                name="project_bloc_id" id="project_bloc_id">
                            </select>
                            @error('project_bloc_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Unit Name:</label>
                            <input class="form-control @error('name') is-invalid @enderror" placeholder="Unit Name..."
                                type="text" name="name" value="{{ old('name') }}" required>
                            @error('name')
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Unit</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" id="edit-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="" class="col-form-label">Project Bloc:</label>
                            <select class="form-select @error('project_bloc_id') is-invalid @enderror" aria-label=""
                                name="project_bloc_id" id="project_bloc_id-edit" required>

                            </select>
                            @error('project_bloc_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="unit-name" class="col-form-label">Unit Name:</label>
                            <input class="form-control @error('name') is-invalid @enderror" placeholder="Unit Name..."
                                type="text" id="unit-name" name="name" value="{{ old('name') }}" required>
                            @error('name')
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
    <script src="{{ url('/') }}/assets/js/custom-datatable.js"></script>
    <script src="{{ url('/') }}/assets/js/custom-choices.js"></script>
    <script src="{{ url('/') }}/assets/choices/js/choices.min.js"></script>
    <script src="{{ url('/') }}/assets/src/plugins/datatables/js/dataTables.min.js"></script>
    <script src="{{ url('/') }}/assets/src/plugins/datatables/js/dataTables.bootstrap5.js"></script>
    <script src="{{ url('/') }}/assets/src/plugins/datatables/js/dataTables.responsive.js"></script>
    <script src="{{ url('/') }}/assets/src/plugins/datatables/js/responsive.bootstrap5.js"></script>
    <script>
        let optionBloc, blocCreate, blocEdit;
        document.addEventListener('DOMContentLoaded', function() {
            setInputChoices('/blocs/option-blocs').then(choices => {
                // set input for filter bloc for get bloc
                const filterBloc = document.getElementById('filter-bloc');
                const project_bloc_id = parseInt(document.getElementById('bloc').value);
                optionBloc = initializeChoice(filterBloc, choices, project_bloc_id);
                // set option for create and update bloc for get option projects
                const optionBlocCreate = document.getElementById('project_bloc_id');
                const optionBlocEdit = document.getElementById('project_bloc_id-edit');
                blocCreate = initializeChoice(optionBlocCreate, choices);
                blocEdit = initializeChoice(optionBlocEdit, choices);
            }).catch(error => {
                console.error('Error:', error);
            });
        })

        $(function() {
            let columnData = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'projectbloc.name',
                    name: 'projectbloc.name'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ];
            let url = {
                url: "/units/datatable",
                data: function(d) {
                    d.project_bloc_id = document.getElementById('bloc').value;
                }
            };
            initializeDatatable('.datatable', url, columnData)

        });
        $(document).on("click", ".edit-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            let project_bloc_id = $(this).data('project_bloc_id');
            let developer_id = $(this).data('developer_id');
            $("#unit-name").val(name);
            // set value option city id
            blocEdit.setChoiceByValue(project_bloc_id);
            $('#edit-form').attr('action', url);
        });
        $(document).on("click", ".delete-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            $("#delete-text").html(`Apa anda yakin menghapus unit ${name}?`);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection
