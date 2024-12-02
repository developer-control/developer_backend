@extends('layouts.main', ['menu' => 'menu_project'])
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
    {{ Breadcrumbs::render('menu_project') }}
@endsection
@section('page-title')
    Data Projects
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Data Projects</h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create"><i class="fas fa-plus me-sm-2"></i> Add
                                    Projects</button>
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
                                            City
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
                    <h5 class="modal-title" id="exampleModalLabel">New Project</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('store_project') }}" method="POST">
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
                            <label for="" class="col-form-label">City:</label>
                            <select class="form-select @error('city_id') is-invalid @enderror" aria-label="" name="city_id"
                                id="city_id">
                            </select>
                            @error('city_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Project Name:</label>
                            <input class="form-control @error('name') is-invalid @enderror" placeholder="Project Name..."
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
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="editModalRole" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
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
                            <label for="" class="col-form-label">City:</label>
                            <select class="form-select @error('city_id') is-invalid @enderror" aria-label=""
                                name="city_id" id="city_id-edit">

                            </select>
                            @error('city_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="project-name" class="col-form-label">Project Name:</label>
                            <input class="form-control @error('name') is-invalid @enderror" placeholder="Project Name..."
                                type="text" id="project-name" name="name" value="{{ old('name') }}" required>
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
        let cityCreate, cityEdit, developerCreate, developerEdit;
        document.addEventListener('DOMContentLoaded', function() {
            setInputChoices('/api/locations/cities').then(choices => {
                const optionCityCreate = document.getElementById('city_id');
                const optionCityEdit = document.getElementById('city_id-edit');
                cityCreate = initializeChoice(optionCityCreate, choices);
                cityEdit = initializeChoice(optionCityEdit, choices);
            }).catch(error => {
                console.error('Error:', error);
            });
            const optionDeveloperCreate = document.getElementById('developer_id');
            const optionDeveloperEdit = document.getElementById('developer_id-edit');
            if (optionDeveloperCreate && optionDeveloperEdit) {
                setInputChoices('/developers/option-developers').then(choices => {
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
                    data: 'city.name',
                    name: 'city.name'
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
            initializeDatatable('.datatable', "/projects/datatable", columnData)

        });
        $(document).on("click", ".edit-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            let city_id = $(this).data('city_id');
            let developer_id = $(this).data('developer_id');
            $("#project-name").val(name);
            // set value option city id
            cityEdit.setChoiceByValue(city_id);
            if (developerEdit) {
                developerEdit.setChoiceByValue(developer_id);
            }
            $('#edit-form').attr('action', url);
        });
        $(document).on("click", ".delete-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            $("#delete-text").html(`Apa anda yakin menghapus project ${name}?`);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection
