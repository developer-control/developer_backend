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
    {{ Breadcrumbs::render('menu_facility') }}
@endsection
@section('page-title')
    Facility Project
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h4 class="ps-0">Filter Facility Project</h4>
                        <hr class="horizontal gray-light">
                    </div>
                    <form action="{{ route($this_route . 'index') }}" method="get">
                        <div class="card-body row px-4 pt-0">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="hidden" id="project" value="{{ $request->project_id }}">
                                    <select class="rounded form-select @error('project_id') is-invalid @enderror"
                                        aria-label="" name="project_id" id="filter-project">
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
                                <h6>Data Facility</h6>
                            </div>
                            <div class="col-md-6 text-end">
                                @officeCan($this_perm . 'create')
                                    <a href="{{ route($this_route . 'create') }}" class="btn bg-gradient-primary"><i
                                            class="fas fa-plus me-sm-2"></i> Add
                                        Facility</a>
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
                                            Title
                                        </th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Project
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
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
    <script src="{{ asset('assets/js/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/js/custom-choices.js') }}"></script>
    <script src="{{ asset('assets/choices/js/choices.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/responsive.bootstrap5.js') }}"></script>
    <script>
        let optionProject;
        document.addEventListener('DOMContentLoaded', function() {
            setInputChoices("{{ route('project.option') }}").then(choices => {
                // set input for filter project for get area
                const filterProject = document.getElementById('filter-project');
                const project_id = parseInt(document.getElementById('project').value);
                optionProject = initializeChoice(filterProject, choices, project_id);
            }).catch(error => {
                console.error('Error:', error);
            });
        })

        $(function() {
            let columnData = [{
                    data: 'title_view',
                    name: 'title',
                },
                {
                    data: 'project.name',
                    name: 'project.name'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
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
                url: "{{ route($this_route . 'data') }}",
                data: function(d) {
                    d.project_id = document.getElementById('project').value;
                }
            };
            initializeDatatable('.datatable', url, columnData)

        });

        $(document).on("click", ".delete-modal", function() {
            let url = $(this).data('url');
            let title = $(this).data('title');
            $("#delete-text").html(`Apa anda yakin menghapus fasilitas ${title}?`);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection
