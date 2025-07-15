@extends('layouts.main', ['menu' => 'menu_unit'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_detail_unit', $unit) }}
@endsection
@section('page-title')
    Detail Project Unit
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header pb-0 border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Data Unit</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mb-1">
                                <label for="project">Proyek</label>
                                <input type="email" class="form-control border-0" id="project"
                                    value="{{ $unit?->projectBloc?->projectArea?->project->name }}" readonly>
                            </div>
                            <div class="form-group mb-1">
                                <label for="area">Kawasan</label>
                                <input type="email" class="form-control border-0" id="area"
                                    value="{{ $unit?->projectBloc?->projectArea->name }}" readonly>
                            </div>
                            <div class="form-group mb-1">
                                <label for="area">Blok</label>
                                <input type="email" class="form-control border-0" id="area"
                                    value="{{ $unit?->projectBloc->name }}" readonly>
                            </div>
                            <div class="form-group mb-1">
                                <label for="area">Unit</label>
                                <input type="email" class="form-control border-0" id="area"
                                    value="{{ $unit->name }}" readonly>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header pb-0 border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Data Pemilik</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                @if (!$userUnit)
                                    @officeCan($this_perm . 'request>create')
                                        <button type="button" class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modal-create"><i class="fas fa-plus me-sm-2"></i> Add
                                            Pemilik</button>
                                    @endofficeCan
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group mb-1">
                                <label for="project">Nama</label>
                                <input type="email" class="form-control border-0" id="project"
                                    value="{{ $userUnit?->user->name ?? 'Belum diklaim' }}" readonly>
                            </div>
                            <div class="form-group mb-1">
                                <label for="area">NIK</label>
                                <input type="email" class="form-control border-0" id="area"
                                    value="{{ $userUnit?->user->identity_number ?? 'Belum diklaim' }}" readonly>
                            </div>
                            <div class="form-group mb-1">
                                <label for="area">Tanggal Lahir</label>
                                <input type="email" class="form-control border-0" id="area"
                                    value="{{ $userUnit?->user->date_of_birth ?? 'Belum diklaim' }}" readonly>
                            </div>
                            <div class="form-group mb-1">
                                <label for="area">Nomor Telepon</label>
                                <input type="email" class="form-control border-0" id="area"
                                    value="{{ $userUnit?->user->phone_number ?? 'Belum diklaim' }}" readonly>
                            </div>

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
    <script></script>
@endsection
