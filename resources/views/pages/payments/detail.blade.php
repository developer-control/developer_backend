@extends('layouts.main', ['menu' => 'menu_payment'])
@section('style')
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('detail_payment', $payment) }}
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
                                <h4>
                                    Detail Pembayaran Tagihan
                                </h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <h4>
                                    @if (in_array($payment->status, ['request', 'pending']))
                                        <a class="btn-approve-modal btn btn-primary my-1" data-bs-target="#modal-approve"
                                            data-bs-toggle="modal">
                                            Approve
                                        </a>
                                        <a class="btn-reject-modal btn btn-warning my-1" data-bs-target="#modal-reject"
                                            data-bs-toggle="modal">
                                            Reject
                                        </a>
                                    @endif
                                    @if ($payment->status == 'paid')
                                        <a class="btn btn-success my-1">
                                            Invoice
                                        </a>
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-2 pb-2">
                        <div class="row px-2">
                            <div class="col-md-6">
                                <div class="card py-2">
                                    <div class="card-header mb-0 pt-2 pb-0">
                                        <h4>Data Tagihan</h4>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">Invoice</h6>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                    {{ $payment->invoice_code }}
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">Tanggal</h6>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                    {{ $payment->date }}
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">User</h6>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                    {{ $payment->user->name }}
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">Unit</h6>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                    {{ $payment->projectUnit->name }}
                                                </div>
                                            </li>
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">Status</h6>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">

                                                    @if ($payment->status == 'pending')
                                                        <span class="text-info"><i class="fas fa-info-circle me-1"></i>
                                                            Menunggu
                                                            Pembayaran</span>
                                                    @elseif ($payment->status == 'cancel')
                                                        <span class="text-danger"><i class="far fa-times-circle me-1"></i>
                                                            Dibatalkan</span>
                                                    @elseif ($payment->status == 'request')
                                                        <span class="text-warning"><i class="fas fa-history me-1"></i>
                                                            Menunggu
                                                            Validasi</span>
                                                    @elseif ($payment->status == 'reject')
                                                        <span class="text-danger"><i class="far fa-times-circle me-1"></i>
                                                            Ditolak</span>
                                                    @else
                                                        <span class="text-success"><i class="far fa-check-circle"></i>
                                                            Selesai</span>
                                                    @endif
                                            </li>
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">Total Tagihan</h6>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                    {{ number_format($payment->total) }}
                                                </div>
                                            </li>
                                            @if ($payment->notes)
                                                <li class="list-group-item border-0 mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Catatan Admin</h6>
                                                            <p>{{ $payment->notes }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                        <h4 class="mt-2">Detail Tagihan</h4>
                                        <ul class="list-group">
                                            @foreach ($payment->bills as $bill)
                                                <li class="list-group-item border-0 p-4 mb-3 bg-gray-100 border-radius-lg">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-3 text-sm">Tagihan {{ $bill->title }}
                                                            ({{ $bill->billed_at->format('F Y') }})
                                                        </h6>
                                                        <span class="mb-1 text-xs">Periode Penggunaan <span
                                                                class="text-dark font-weight-bold ms-sm-2 float-end">{{ $bill->usage_period_at->format('F Y') }}</span></span>
                                                        <span class="mb-1 text-xs">Tagihan <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->value) }}</span></span>
                                                        <span class="mb-1 text-xs">PPH <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->tax) }}</span></span>
                                                        <span class="mb-1 text-xs">Denda <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->penalty) }}</span></span>
                                                        <span class="mb-1 text-xs">Diskon <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->discount) }}</span></span>
                                                        <span class="mb-1 text-xs">Pemutihan Tagihan <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->bill_release) }}</span></span>
                                                        <span class="mb-1 text-xs">Pemutihan Denda <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->penalty_release) }}</span></span>
                                                        <span class="mb-1 text-xs">Terbayar <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->paid) }}</span></span>
                                                        <span class="mb-1 text-xs">Total <span
                                                                class="text-dark ms-sm-2 font-weight-bold float-end">{{ number_format($bill->total) }}</span></span>
                                                    </div>
                                                    {{-- <div class="ms-auto text-end">
                                                        <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                            href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                                                        <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                                                class="fas fa-pencil-alt text-dark me-2"
                                                                aria-hidden="true"></i>Edit</a>
                                                    </div> --}}
                                                </li>
                                            @endforeach


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card py-2">
                                    <div class="card-header mb-0 pt-2 pb-0">
                                        <h4>Data Pembayaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            @if ($payment->paymentData)
                                                <li
                                                    class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Tanggal Bayar</h6>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                        {{ $payment->paymentData->paid_at }}
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Bank Pengirim</h6>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                        {{ $payment->paymentData->bank_origin_name }}
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Akun Pengirim</h6>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                        {{ $payment->paymentData->account_origin_name }}
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Nomor Rekening Pengirim</h6>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                        {{ $payment->paymentData->account_origin_number }}
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Unit</h6>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                        {{ $payment->projectUnit->name }}
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item border-0 d-flex justify-content-between mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Bukti Bayar</h6>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center text-dark text-gradient text-sm font-weight-bold">
                                                        @if ($payment->paymentData->file_url)
                                                            <a href="{{ storage_url($payment->paymentData->file_url) }}"
                                                                class="btn-sm btn-link" target="_blank">File Bukti
                                                                <i class="fas fa-long-arrow-alt-right"></i></a>
                                                        @endif
                                                </li>
                                                <li class="list-group-item border-0 mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-dark text-sm">Keterangan</h6>
                                                            <p>{{ $payment->paymentData->description }}</p>
                                                        </div>
                                                    </div>

                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>

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
                <form action="{{ route('approve_payment', ['id' => $payment->id]) }}" id="approve-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="" class="col-form-label">Invoice:</label>
                            <input class="form-control" type="text" value="{{ $payment->invoice_code }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Unit:</label>
                            <input class="form-control" type="text" value="{{ $payment->projectUnit->name }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Tanggal Bayar:</label>
                            <input class="form-control" type="text"
                                value="{{ @$payment->paymentData->paid_at ? date_format(date_create(@$payment->paymentData->paid_at), 'Y-m-d') : $payment->date }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Total:</label>
                            <input class="form-control text-end" type="text" value="{{ $payment->total }}"
                                id="total_approve" readonly>
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
                <form action="{{ route('reject_payment', ['id' => $payment->id]) }}" id="reject-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="" class="col-form-label">Invoice:</label>
                            <input class="form-control" type="text" value="{{ $payment->invoice_code }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Unit:</label>
                            <input class="form-control" type="text" value="{{ $payment->projectUnit->name }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Tanggal Bayar:</label>
                            <input class="form-control" type="text"
                                value="{{ @$payment->paymentData->paid_at ? date_format(date_create(@$payment->paymentData->paid_at), 'Y-m-d') : $payment->date }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label">Total:</label>
                            <input class="form-control text-end" type="text" value="{{ $payment->total }}"
                                id="total_reject" readonly>
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan Reject</label>
                            <textarea class="form-control" id="notes" name="notes" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-warning">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Reject Request Unit-->
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/custom-numeric.js') }}"></script>
    <script src="{{ asset('assets/choices/js/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/Auto-Numeric/auto-numeric.js') }}"></script>
    <script>
        var totalApprove = initalizeNumericInput('#total_approve');
        var totalReject = initalizeNumericInput('#total_reject');
    </script>
@endsection
