@extends('layouts.main')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_payment') }}
@endsection
@section('page-title')
    Pembayaran Tagihan Unit
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Pembayaran Tagihan Unit</h6>
                                <form action="{{ route($this_route . 'index') }}" method="get">
                                    <div class="row">
                                        <div class="form-group mb-1 col-8">
                                            <select class="rounded form-select @error('status') is-invalid @enderror"
                                                aria-label="" name="status" id="filter-status">
                                                <option value=""@if ($request->status == '') selected @endif>All
                                                </option>
                                                <option value="pending" @if ($request->status == 'pending') selected @endif>
                                                    Menunggu Bayar
                                                </option>
                                                <option value="request" @if ($request->status == 'request') selected @endif>
                                                    Menunggu Validasi
                                                </option>
                                                <option value="paid" @if ($request->status == 'paid') selected @endif>
                                                    Dibayar
                                                </option>
                                                <option value="reject" @if ($request->status == 'reject') selected @endif>
                                                    Ditolak
                                                </option>
                                                <option value="cancel" @if ($request->status == 'cancel') selected @endif>
                                                    Dibatalkan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-1 col-4">
                                            <label for="" class="col-form-label"></label>
                                            <button type="submit" class="btn bg-gradient-primary"> <i
                                                    class="fas fa-search me-1"></i>filter</button>
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
                                            Invoice
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Unit
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            User
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Bayar
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bukti Bayar </th>
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
                    data: 'invoice_code',
                    name: 'invoice_code'
                },
                {
                    data: 'projectunit.name',
                    name: 'projectunit.name'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'file_payment',
                    name: 'file_payment',
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
                url: "{{ route($this_route . 'data') }}",
                data: function(d) {
                    d.status = document.getElementById('filter-status').value;
                }
            };
            initializeDatatable('.datatable', url, columnData)

        });
        $(document).on("click", ".delete-modal", function() {
            let url = $(this).data('url');
            let invoice_code = $(this).data('invoice_code');
            $("#delete-text").html(`Apa anda yakin menghapus pembayaran ${invoice_code}?`);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection
