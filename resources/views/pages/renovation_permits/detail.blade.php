@extends('layouts.main', ['menu' => 'menu_renovation_permit'])
@section('style')
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_detail_renovation_permit', $permit) }}
@endsection
@section('page-title')
    Detail Izon Renovasi
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Detail Izin Renovasi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-12 mb-4">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Judul</div>

                                    </div>
                                    <span class=""> {{ $permit->title }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Nama User</div>
                                    </div>
                                    <span>
                                        {{ $permit->user->name }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Unit</div>
                                    </div>
                                    <span>
                                        {{ $permit->projectunit->name }}

                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Foto KTP</div>
                                    </div>
                                    @if ($permit->id_card_photo)
                                        <span>
                                            <a href="{{ storage_url($permit->id_card_photo) }}" class="btn-link"
                                                target="_blank">Lihat File KTP <i
                                                    class="fas fa-long-arrow-alt-right"></i></a>
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Denah Unit</div>
                                    </div>
                                    @if ($permit->unit_layout)
                                        <span>
                                            <a href="{{ storage_url($permit->unit_layout) }}" class="btn-link"
                                                target="_blank">Lihat Denah Unit <i
                                                    class="fas fa-long-arrow-alt-right"></i></a>
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Surat Keterangan RT</div>
                                    </div>
                                    @if ($permit->neighborhood_certificate)
                                        <span>
                                            <a href="{{ storage_url($permit->neighborhood_certificate) }}" class="btn-link"
                                                target="_blank">Lihat Keterangan RT <i
                                                    class="fas fa-long-arrow-alt-right"></i></a>
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Surat Kuasa</div>
                                    </div>
                                    @if ($permit->power_of_attorney)
                                        <span>
                                            <a href="{{ storage_url($permit->power_of_attorney) }}" class="btn-link"
                                                target="_blank">Lihat Kuasa <i class="fas fa-long-arrow-alt-right"></i></a>
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Surat Izin</div>
                                    </div>
                                    @if ($permit->permit_letter)
                                        <span>
                                            <a href="{{ storage_url($permit->permit_letter) }}" class="btn-link"
                                                target="_blank">Lihat Surat Izin <i
                                                    class="fas fa-long-arrow-alt-right"></i></a>
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Surat Pernyataan Deposit</div>
                                    </div>
                                    @if ($permit->deposit_statement)
                                        <span>
                                            <a href="{{ storage_url($permit->deposit_statement) }}" class="btn-link"
                                                target="_blank">Lihat Pernyataan Deposit <i
                                                    class="fas fa-long-arrow-alt-right"></i></a>
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Surat Informasi Tetangga</div>
                                    </div>
                                    @if ($permit->neighbor_information)
                                        <span>
                                            <a href="{{ storage_url($permit->neighbor_information) }}" class="btn-link"
                                                target="_blank">Lihat Surat Informasi Tetangga <i
                                                    class="fas fa-long-arrow-alt-right"></i></a>
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Status</div>
                                    </div>
                                    @if ($permit->status == 'request')
                                        <span class="text-warning"><i class="fas fa-history"></i> Menunggu</span>
                                    @elseif($permit->status == 'reject')
                                        <span class="text-warning"><i class="far fa-times-circle"></i> Ditolak</span>
                                    @else
                                        <span class="text-success"><i class="far fa-check-circle"></i> Diterima</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Catatan</div>
                                    </div>
                                    <span>
                                        {{ $permit->notes }}

                                    </span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-12 row d-flex justify-content-between border-top py-3">
                            <div class="col-6">
                                <a class="btn btn-warning px-2 my-1" href="{{ route('menu_complain') }}">
                                    Kembali
                                </a>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <button type="button" class="btn btn-danger px-2 my-1 me-3"
                                    data-bs-target="#modal-approved" data-bs-toggle="modal"
                                    @if ($permit->status != 'request') disabled @endif>
                                    Reject
                                </button>
                                <button type="button" class="btn btn-success px-2 my-1" data-bs-target="#modal-approved"
                                    data-bs-toggle="modal" @if ($permit->status != 'request') disabled @endif>
                                    Approve
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Approve Permit Renovation-->
    <div class="modal fade" id="modal-approved" tabindex="-1" role="dialog" aria-labelledby="editModalRole"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selesaikan Komplain</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('solve_complain', ['id' => $permit->id]) }}" id="solved-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="unit-name" class="col-form-label">Judul Komplain:</label>
                            <input class="form-control" type="text" id="unit-name" value="{{ $permit->title }}"
                                readonly>

                        </div>
                        <div class="form-group">
                            <label for="solved_notes">Catatan:</label>
                            <textarea class="form-control" id="solved_notes" name="solved_notes" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-success">Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Approve Permit Renovation-->
@endsection
@section('scripts')
@endsection
