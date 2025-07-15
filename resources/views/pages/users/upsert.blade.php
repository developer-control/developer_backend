@extends('layouts.main')
@section('style')
@endsection
@section('breadcrumb')
    {{ !isset($obj) ? Breadcrumbs::render('create_user') : Breadcrumbs::render('edit_user', $obj) }}
@endsection
@section('page-title')
    {{ !isset($obj) ? 'Create User' : 'Edit User' }}
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">{{ !isset($obj) ? 'Create User' : 'Edit User' }}</h6>
                    </div>
                    <div class="card-body p-3">
                        @include('pages.users.partials.form', [
                            'action' => !isset($obj)
                                ? route($this_route . 'store')
                                : route($this_route . 'update', ['id' => $obj->id]),
                            'type' => !isset($obj) ? 'create' : 'edit',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
