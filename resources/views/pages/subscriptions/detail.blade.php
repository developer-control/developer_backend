@extends('layouts.main', ['menu' => 'menu_subscription'])
@section('style')
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('detail_subscription', $subscription) }}
@endsection
@section('page-title')
    Detail Subscription
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
                                    Detail Subscription
                                </h4>
                            </div>
                            <div class="col-md-6 text-end">

                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-2">
                        <div class="row d-flex align-items-stretch">
                            <div class="col-md-3 ">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Nama Subscription</h6>
                                                <p class="mb-0">{{ $subscription->name }}</p>
                                            </div>
                                        </div>

                                    </li>
                                    <li class="list-group-item border-0 ">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Harga</h6>
                                                <p class="mb-0">Rp. {{ number_format($subscription->price) }}</p>
                                            </div>
                                        </div>

                                    </li>
                                    <li class="list-group-item border-0 ">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-dark text-sm">Durasi</h6>
                                                <p class="mb-0">{{ $subscription->duration }} bulan</p>
                                            </div>
                                        </div>

                                    </li>

                                    @if ($subscription->description)
                                        <li class="list-group-item border-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">Description</h6>
                                                    <p class="mb-0">{{ $subscription->description }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <form action="{{ route('subscription_feature', ['id' => $subscription->id]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="row ">
                                        <h4 class="mt-2">Daftar Fitur yang tersedia</h4>
                                        @isset($features)
                                            @foreach ($features as $feature)
                                                <div class="col-md-3 mt-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="{{ $feature->name . '-' . $feature->group }}" name="features[]"
                                                            value="{{ $feature->id }}"
                                                            @if (in_array($feature->id, $featSubs)) checked @endif>
                                                        <label class="form-check-label"
                                                            for="{{ $feature->name . '-' . $feature->group }}">{{ $feature->name . ' (' . $feature->group . ')' }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endisset

                                        <div class="col-md-12 d-flex justify-content-end align-items-end mt-3">
                                            <button type="submit" class="btn btn-primary px-5" id="submit-form"><i
                                                    class="fa fa-save"></i>
                                                Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
