@extends('layouts.main', ['menu' => 'menu_bill'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/choices/css/choices.min.css') }}">
    <style>
        .choices__inner {
            border-radius: 8px;
            padding: .5rem .75rem;
        }

        .choices__list--multiple .choices__item {
            border-radius: 8px;
        }
    </style>
@endsection
@section('breadcrumb')
    {{ Breadcrumbs::render('create_bill') }}
@endsection
@section('page-title')
    Create Tagihan
@endsection
@section('content')
    <div class="container py-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9 col-12 mt-4">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">Create Tagihan</h6>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('store_bill') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="" class="form-control-label">Unit:</label>
                                <select class="form-select @error('project_unit_id') is-invalid @enderror" aria-label=""
                                    name="project_unit_id" id="project_unit_id" required>
                                </select>
                                <input type="hidden" id="old_project" value="{{ old('project_unit_id') }}">
                                @error('project_unit_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="bill_type_id" class="form-control-label">Type Tagihan</label>
                                <select class="form-control" id="bill_type_id" name="bill_type_id" onchange="showInput()"
                                    required>
                                    <option value="">Pilih Type Tagihan...</option>
                                    @if ($billTypes)
                                        @foreach ($billTypes as $type)
                                            <option value="{{ $type->id }}" data-input-title="{{ $type->is_edit }}"
                                                data-start-value="{{ $type->with_start_value }}"
                                                @if (old('bill_type_id') == $type->id) selected @endif>{{ $type->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="usage_period_at" class="form-control-label">Periode Penggunaan</label>
                                <input class="form-control" type="month"
                                    value="{{ old('usage_period_at') ?? date('Y-m') }}" id="usage_period_at"
                                    name="usage_period_at" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="billed_at" class="form-control-label">Bulan Penagihan</label>
                                <input class="form-control" type="month" value="{{ old('billed_at') ?? date('Y-m') }}"
                                    id="billed_at" name="billed_at" required>
                            </div>
                            <div class="form-group mb-3 d-none" id="group-title">
                                <label for="title" class="form-control-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="Input title" value="{{ old('title') }}">
                            </div>
                            <div class="form-group mb-3 d-none" id="group-start-value">
                                <label for="start_value" class="form-control-label">Meter Awal</label>
                                <input type="text" class="form-control @error('start_value') is-invalid @enderror"
                                    id="start_value" name="start_value" placeholder="" value="{{ old('start_value') }}">
                            </div>
                            <div class="form-group mb-3 d-none" id="group-end-value">
                                <label for="end_value" class="form-control-label">Meter Terakhir</label>
                                <input type="text" class="form-control @error('end_value') is-invalid @enderror"
                                    id="end_value" name="end_value" placeholder="" value="{{ old('end_value') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="bill_value" class="form-control-label">Nilai Tagihan</label>
                                <input type="text" class="form-control text-end @error('value') is-invalid @enderror"
                                    id="bill_value" name="value" placeholder="" value="{{ old('value') ?? 0 }}"
                                    oninput="sumTotalValue()" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tax_value" class="form-control-label">Nilai Pajak</label>
                                <input type="text" class="form-control text-end @error('tax') is-invalid @enderror"
                                    id="tax_value" name="tax" placeholder="" value="{{ old('tax') ?? 0 }}"
                                    oninput="sumTotalValue()">
                            </div>
                            <div class="form-group mb-3">
                                <label for="penalty_value" class="form-control-label">Denda</label>
                                <input type="text" class="form-control text-end @error('penalty') is-invalid @enderror"
                                    id="penalty_value" name="penalty" placeholder="" value="{{ old('penalty') ?? 0 }}"
                                    oninput="sumTotalValue()">
                            </div>
                            <div class="form-group mb-3">
                                <label for="discount_value" class="form-control-label">Diskon</label>
                                <input type="text"
                                    class="form-control text-end @error('discount') is-invalid @enderror"
                                    id="discount_value" name="discount" placeholder=""
                                    value="{{ old('discount') ?? 0 }}" oninput="sumTotalValue()">
                            </div>
                            <div class="form-group mb-3">
                                <label for="bill_release_value" class="form-control-label">Pemutihan Tagihan</label>
                                <input type="text"
                                    class="form-control text-end @error('bill_release') is-invalid @enderror"
                                    id="bill_release_value" name="bill_release" placeholder=""
                                    value="{{ old('bill_release') ?? 0 }}" oninput="sumTotalValue()">
                            </div>
                            <div class="form-group mb-3">
                                <label for="penalty_release_value" class="form-control-label">Pemutihan Denda</label>
                                <input type="text"
                                    class="form-control text-end @error('penalty_release') is-invalid @enderror"
                                    id="penalty_release_value" name="penalty_release" placeholder=""
                                    value="{{ old('penalty_release') ?? 0 }}" oninput="sumTotalValue()">
                            </div>
                            <div class="form-group mb-3">
                                <label for="paid_value" class="form-control-label">Terbayar</label>
                                <input type="text" class="form-control text-end @error('paid') is-invalid @enderror"
                                    id="paid_value" name="paid" placeholder="" value="{{ old('paid') ?? 0 }}"
                                    oninput="sumTotalValue()">
                            </div>
                            <div class="form-group mb-3">
                                <label for="total_value" class="form-control-label">Total</label>
                                <input type="text" class="form-control text-end @error('total') is-invalid @enderror"
                                    id="total_value" name="total" placeholder="" value="{{ old('total') }}"
                                    readonly>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5" id="submit-form"><i
                                        class="fa fa-save"></i>
                                    Submit</button>
                            </div>
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
    <script>
        var billValue = initalizeNumericInput('#bill_value');
        var taxValue = initalizeNumericInput('#tax_value');
        var penaltyValue = initalizeNumericInput('#penalty_value');
        var discountValue = initalizeNumericInput('#discount_value');
        var billReleaseValue = initalizeNumericInput('#bill_release_value');
        var penaltyReleaseValue = initalizeNumericInput('#penalty_release_value');
        var paidValue = initalizeNumericInput('#paid_value');
        var totalValue = initalizeNumericInput('#total_value');

        function sumTotalValue() {
            let total = billValue.getNumber() + taxValue.getNumber() + penaltyValue.getNumber();
            let decrease = discountValue.getNumber() + billReleaseValue.getNumber() + penaltyReleaseValue.getNumber() +
                paidValue.getNumber();
            totalValue.set(total - decrease);
        }

        let unitOption;
        document.addEventListener('DOMContentLoaded', function() {
            showInput()
            sumTotalValue()
            setInputChoices('/units/option-units').then(choices => {
                // set option for create and update area for get option projects
                const optionUnit = document.getElementById('project_unit_id');
                const oldUnit = document.getElementById('old_project');
                let id = oldUnit.value ? Number(oldUnit.value) : null;
                unitOption = initializeChoice(optionUnit, choices, id);
            }).catch(error => {
                console.error('Error:', error);
            });
        })

        function showInput() {
            // Sembunyikan semua input
            document.getElementById('group-title').classList.add('d-none');
            document.getElementById('group-start-value').classList.add('d-none');
            document.getElementById('group-end-value').classList.add('d-none');
            // Ambil elemen opsi yang dipilih
            var selectedOption = document.getElementById('bill_type_id').selectedOptions[0];
            // Ambil nilai atribut data
            var editTitle = selectedOption.dataset.inputTitle;
            var startValue = selectedOption.dataset.startValue;
            // Jika editTitle = 1, tampilkan input sesuai value opsi
            if (editTitle === "1") {
                document.getElementById('group-title').classList.remove('d-none');
            }
            if (startValue === "1") {
                document.getElementById('group-start-value').classList.remove('d-none');
                document.getElementById('group-end-value').classList.remove('d-none');
            }
        }
    </script>
@endsection
