@extends('layouts.main', ['menu' => 'menu_bill'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/choices/css/choices.min.css') }}">
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('edit_bill', $bill) }}
@endsection
@section('page-title')
    Edit Tagihan
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">Edit Tagihan</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('bill.update', ['id' => $bill->id]) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @include('pages.bills.partials.form', ['obj' => $bill])


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/custom-choices.js') }}"></script>
    <script src="{{ asset('assets/js/custom-numeric.js') }}"></script>
    <script src="{{ asset('assets/choices/js/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/Auto-Numeric/auto-numeric.js') }}"></script>
@endsection
