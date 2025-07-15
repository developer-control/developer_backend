@props(['obj' => null, 'action', 'type' => 'create'])
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/choices/css/choices.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/flatpickr/css/flatpickr.min.css') }}">
@endpush
<form action="{{ $action }}" enctype="multipart/form-data" method="POST">
    @csrf
    @hasrole('superadmin')
        <div class="form-group mb-3">
            <label for="" class="col-form-label">Developer <span class="fw-bold">*</span></label>
            <select class="form-select @error('developer_id') is-invalid @enderror" aria-label="" name="developer_id"
                id="developer_id">
            </select>
            <input type="hidden" id="old_developer" value="{{ old('developer_id', optional($obj)->developer_id ?? '') }}">
            @error('developer_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    @endhasrole
    <div class="form-group mb-3">
        <label for="name" class="form-control-label">Name <span class="fw-bold">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            placeholder="Input nama..." value="{{ old('name', optional($obj)->name) ?? '' }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="email" class="form-control-label">Email <span class="fw-bold">*</span></label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            placeholder="Input email..." value="{{ old('email', optional($obj)->email) ?? '' }}">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    @if ($type == 'create')
        <div class="form-group mb-3">
            <label for="password" class="form-control-label">Password <span class="fw-bold">*</span></label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" placeholder="Input password..." value="">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-control-label">Role <span class="fw-bold">*</span></label>
            <select name="role" id="role" class="form-select @error('password') is-invalid @enderror">
                <option value="">Pilih Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            @error('role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    @endif
    <div class="form-group mb-3">
        <label for="identity_number" class="form-control-label">NIK <span class="fw-bold">*</span></label>
        <input type="text" class="form-control @error('identity_number') is-invalid @enderror" id="identity_number"
            name="identity_number" placeholder=""
            value="{{ old('identity_number', optional($obj)->identity_number) ?? '' }}">
        @error('identity_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="row">
        <label for="" class="col-lg-12 form-control-label">Foto KTP <span class="fw-bold">*</span></label>
        <div class="col-lg-12">
            <div class="form-file @error('id_card_image') is-invalid @enderror">
                <input type="file" class="form-control @error('id_card_image') is-invalid @enderror"
                    data-name="id_card_image" onchange="uploadFile(this)">
                <input type="hidden" name="id_card_image" id="id_card_image"
                    value="{{ old('id_card_image', $obj->id_card_image ?? '') }}">
            </div>
            @error('id_card_image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-lg-12">
            <div id="view-progress-id_card_image" class="my-3 progress d-none">
            </div>
        </div>
        <div class="col-lg-12">
            <div id="fileList-id_card_image" class="mt-2 mb-3">
                @if (old('id_card_image'))
                    <div id="old-value-asset"
                        class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                        <a href="{{ storage_url(old('id_card_image')) }}" target="_blank"><i
                                class="fas fa-bars me-2"></i>
                            {{ old('id_card_image') }}</a>
                        <button type="button" class="btn btn-danger btn-sm my-auto" id="btn-remove-asset"
                            onclick="removeAsset('id_card_image')">Remove</button>
                    </div>
                @elseif (optional($obj)->id_card_image)
                    <div id="old-value-asset"
                        class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                        <a href="{{ storage_url($obj->id_card_image) }}" target="_blank"><i
                                class="fas fa-bars me-2"></i>
                            {{ optional($obj)->id_card_image }}</a>
                        <button type="button" class="btn btn-danger btn-sm my-auto" id="btn-remove-asset"
                            onclick="removeAsset('id_card_image')">Remove</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group mb-3">
        <label for="date_of_birth" class="form-control-label">Tanggal Lahir</label>
        <input type="text" class="form-control @error('date_of_birth') is-invalid @enderror date-input"
            id="date_of_birth" name="date_of_birth" placeholder="Tanggal Lahir..."
            value="{{ old('date_of_birth', optional($obj)->date_of_birth) ?? '' }}">
        @error('date_of_birth')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="phone_number" class="form-control-label">Nomer Telepon</label>
        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
            name="phone_number" placeholder="Input Nomor Telepon..."
            value="{{ old('phone_number', optional($obj)->phone_number) ?? '' }}">
        @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="address" class="form-control-label">Alamat</label>
        <textarea name="address" id="address" cols="30" rows="10"
            class="form-control @error('address') is-invalid @enderror">
        {{ old('address', optional($obj)->address) ?? '' }}</textarea>
        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary px-5" id="submit-form"><i class="fa fa-save"></i>
            Submit</button>
    </div>
</form>

@push('js')
    <script src="{{ asset('assets/js/upload-file.js') }}"></script>
    <script src="{{ asset('vendor/flatpickr/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-choices.js') }}"></script>
    <script src="{{ asset('assets/choices/js/choices.min.js') }}"></script>
    <script>
        const urlUploadFile = "{{ route('user.upload-identity') }}"
        $(".date-input").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
        let developerOption;
        document.addEventListener('DOMContentLoaded', function() {
            const optionDeveloper = document.getElementById('developer_id');

            if (optionDeveloper) {
                setInputChoices("{{ route('developer.option') }}").then(choices => {
                    const oldDeveloper = document.getElementById('old_developer');
                    let id = oldDeveloper.value ? Number(oldDeveloper.value) : null;
                    developerOption = initializeChoice(optionDeveloper, choices, id);
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
        })
    </script>
@endpush
