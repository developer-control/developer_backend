@extends('layouts.main')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_request_claim_unit') }}
@endsection
@section('page-title')
    Request Claim Project Unit
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Request Claim Unit</h6>
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
                                            Bukti Kepemilikan
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
    <!-- Modal Approve Request Unit-->
    <div class="modal fade" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="editModalRole"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Approve Klaim Unit</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" id="approve-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="unit-name" class="col-form-label">Unit Name:</label>
                            <input class="form-control" placeholder="Unit Name..." type="text" id="unit-name" readonly>

                        </div>
                        <div class="form-group">
                            <label for="unit-name" class="col-form-label">Nama Pemilik:</label>
                            <input class="form-control" placeholder="Unit Name..." type="text" id="unit-user" readonly>

                        </div>
                        <div class="form-group">
                            <label for="ownership-unit">Status Kepemilikan: </label>
                            <select class="form-control" id="ownership-unit" readonly disabled>
                                @foreach ($ownerships as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Approve Request Unit-->

    <!-- Modal Reject Request Unit-->
    <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="editModalRole"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Klaim Unit</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" id="reject-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="reject-name" class="col-form-label">Unit Name:</label>
                            <input class="form-control" placeholder="Unit Name..." type="text" id="reject-name"
                                readonly>

                        </div>
                        <div class="form-group">
                            <label for="reject-name" class="col-form-label">Nama Pemilik:</label>
                            <input class="form-control" placeholder="Unit Name..." type="text" id="reject-user"
                                readonly>

                        </div>
                        <div class="form-group">
                            <label for="ownership-reject">Status Kepemilikan: </label>
                            <select class="form-control" id="ownership-reject" readonly disabled>
                                @foreach ($ownerships as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan Reject</label>
                            <textarea class="form-control" id="notes" name="notes" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-warning">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Reject Request Unit-->
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
                    data: 'evidence_file',
                    name: 'evidence_file',
                    orderable: false,
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
                    d.status = 'request';
                }
            };
            initializeDatatable('.datatable', url, columnData)

        });

        $(document).on("click", ".btn-approve-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            let owner = $(this).data('owner');
            let ownership_unit_id = $(this).data('ownership_unit_id');

            $("#unit-name").val(name);
            $("#unit-user").val(owner);
            $("#ownership-unit").val(ownership_unit_id);

            $('#approve-form').attr('action', url);
        });
        $(document).on("click", ".btn-reject-modal", function() {
            let url = $(this).data('url');
            let name = $(this).data('name');
            let owner = $(this).data('owner');
            let ownership_unit_id = $(this).data('ownership_unit_id');

            $("#reject-name").val(name);
            $("#reject-user").val(owner);
            $("#ownership-reject").val(ownership_unit_id);

            $('#reject-form').attr('action', url);
        });
    </script>
@endsection
