@extends('layouts.main', ['menu' => 'menu_complain'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('menu_detail_complain', $complain) }}
@endsection
@section('page-title')
    Detail Komplain
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 border-bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Detail Komplain Unit</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Proyek</th>
                                        <td class="align-middle border-0">{{ $complain?->project?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Kawasan</th>
                                        <td class="align-middle border-0">{{ $complain?->projectArea?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Unit</th>
                                        <td class="align-middle border-0">{{ $complain?->projectUnit?->name }}</td>
                                    </tr>

                                    <tr>
                                        <th class="w-25 border-0 align-middle">Alamat</th>
                                        <td class="align-middle border-0">{{ $complain?->address }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Type</th>
                                        <td class="align-middle border-0">{{ $complain?->type }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Judul</th>
                                        <td class="align-middle border-0">{{ $complain?->title }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Nama User</th>
                                        <td class="align-middle border-0">{{ $complain?->user?->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Deskripsi</th>
                                        <td class="align-middle border-0">{{ $complain?->description }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Status</th>
                                        <td class="align-middle border-0">{{ $complain?->status }}</td>
                                    </tr>
                                    <tr>
                                        <th class="w-25 border-0 align-middle">Gambar</th>
                                        <td class="align-middle border-0">
                                            @foreach (@json_decode(@$complain->images, true) ?? [] as $item)
                                                <a class="btn-approve-modal btn btn-sm btn-info px-2 my-1"
                                                    href="{{ storage_url($item) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-info-circle-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                                                    </svg>
                                                    <span class="ms-1">
                                                        Lihat Gambar
                                                    </span>
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @if ($complain->status == 'finished')
                                        <tr>
                                            <th class="w-25 border-0 align-middle">Catatan Selesai</th>
                                            <td class="align-middle border-0">{{ $complain?->solved_notes }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 d-flex justify-content-between">
                            <a class="btn btn-warning px-2 my-1" href="{{ route('menu_complain') }}">
                                Kembali
                            </a>
                            <button type="button" class="btn btn-success px-2 my-1" data-bs-target="#modal-solved"
                                data-bs-toggle="modal" @if ($complain->status == 'finished') disabled @endif>
                                {{ $complain->status == 'finished' ? 'Komplain Telah Selesai' : 'Selesaikan Komplain' }}
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Solved Complain-->
    <div class="modal fade" id="modal-solved" tabindex="-1" role="dialog" aria-labelledby="editModalRole"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selesaikan Komplain</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('solve_complain', ['id' => $complain->id]) }}" id="solved-form" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="unit-name" class="col-form-label">Judul Komplain:</label>
                            <input class="form-control" type="text" id="unit-name" value="{{ $complain->title }}"
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
    <!-- End Modal Solved Complain-->
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/src/plugins/datatables/js/responsive.bootstrap5.js') }}"></script>
    <script></script>
@endsection
