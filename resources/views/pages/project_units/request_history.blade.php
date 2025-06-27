<div>
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
</div>
@extends('layouts.main')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_history_claim_unit') }}
@endsection
@section('page-title')
    History Claim Project Unit
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">

            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>History Claim Unit</h6>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route($this_route . 'history.index') }}" method="get">
                                    <div class="row">
                                        <div class="form-group mb-1 col-8">
                                            <select class="rounded form-select @error('status') is-invalid @enderror"
                                                aria-label="" name="status" id="filter-status">
                                                <option value=""@if ($request->status == '') selected @endif>All
                                                </option>
                                                <option value="claimed" @if ($request->status == 'claimed') selected @endif>
                                                    Diklaim
                                                </option>
                                                <option value="request" @if ($request->status == 'request') selected @endif>
                                                    Menunggu
                                                    Konfirmasi
                                                </option>
                                                <option value="failed" @if ($request->status == 'failed') selected @endif>
                                                    Ditolak
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1 col-4">
                                            <label for="" class="col-form-label"></label>
                                            <button type="submit" class="btn bg-gradient-primary"><i
                                                    class="fas fa-search"></i> Filter</button>
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
                                            Project
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Area
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bloc
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Unit
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ownership
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name User
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Catatan
                                        </th>
                                        <th class="text-secondary text-xs font-weight-bolder opacity-7">Status</th>
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
                    data: 'project.name',
                    name: 'project.name'
                },
                {
                    data: 'projectarea.name',
                    name: 'projectarea.name'
                },
                {
                    data: 'projectbloc.name',
                    name: 'projectbloc.name'
                },
                {
                    data: 'projectunit.name',
                    name: 'projectunit.name'
                },
                {
                    data: 'ownershipunit.name',
                    name: 'ownershipunit.name'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'notes',
                    name: 'notes',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                }
            ];
            let url = {
                url: "{{ route($this_route . 'history.data') }}",
                data: function(d) {
                    d.status = document.getElementById('filter-status').value;
                }
            };
            initializeDatatable('.datatable', url, columnData)

        });
    </script>
@endsection
