@extends('layouts.main')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/src/plugins/datatables/css/responsive.bootstrap5.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('developer_permission', $developer) }}
@endsection
@section('page-title')
    Master Permission Developers Admin Page
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Permission Developer Admin Page</h6>
                            </div>
                            <div class="col-md-6 text-end">

                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <form action="{{ route($this_route . 'update', ['developer' => $developer->id]) }}"
                            id="form-role_permission" method="POST">
                            @csrf
                            <div class="row table-responsive p-4">
                                <table class="table align-items-center mb-0 ">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                width="40%">Menu</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">View</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Create</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Update</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Delete</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                style="text-align: center;">Approve/Publish</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $menu => $menus)
                                            {{-- Row header menu --}}
                                            <tr style="">
                                                <td class="fw-bold"><strong>{{ $menu }}</strong></td>
                                                @php
                                                    $types = [1, 2, 3, 4, 5];
                                                @endphp

                                                @foreach ($types as $type)
                                                    @php
                                                        $perm = $menus->firstWhere('type', $type);
                                                    @endphp
                                                    <td style="text-align: center;">
                                                        @if ($perm)
                                                            <div
                                                                class="form-check form-switch mx-auto d-flex justify-content-center">

                                                                <input class="form-check-input"
                                                                    type="checkbox"name="permissions[]"
                                                                    id="{{ $perm->name }}" value="{{ $perm->name }}"
                                                                    @if ($developer->hasPermissionTo($perm->name)) checked @endif>

                                                            </div>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-4 mt-5 row">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-5" id="submit-form"><i
                                            class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                        </form>
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
