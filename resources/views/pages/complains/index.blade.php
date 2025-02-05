@extends('layouts.main', ['menu' => 'menu_complain'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_complain') }}
@endsection
@section('page-title')
    Complain Users
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Complain Users</h6>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('menu_complain') }}" method="get">
                                    <div class="row">
                                        <div class="form-group mb-1 w-75">
                                            <select class="rounded form-select @error('status') is-invalid @enderror"
                                                aria-label="" name="status" id="filter-status">
                                                <option value=""@if ($request->status == '') selected @endif>All
                                                </option>
                                                <option value="request" @if ($request->status == 'request') selected @endif>
                                                    Menunggu
                                                </option>
                                                <option value="finished" @if ($request->status == 'finished') selected @endif>
                                                    Selesai
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1 w-25">
                                            <label for="" class="col-form-label"></label>
                                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
                                            Judul
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama User
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Type
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Deskripsi
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Catatan Penyelesaian
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
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'description',
                    name: 'description',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'solved_notes',
                    name: 'solved_notes',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            let url = {
                url: "/complains/datatable",
                data: function(d) {
                    d.status = document.getElementById('filter-status').value;
                }
            };
            initializeDatatable('.datatable', url, columnData)

        });
    </script>
@endsection
