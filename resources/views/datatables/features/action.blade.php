<div class="btn-group" aria-label="button action">
    <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
        data-bs-placement="bottom"
        @isset($data)
        @foreach ($data as $key => $item)
            data-{{ $key }}="{{ $item }}"
        @endforeach
    @endisset
        data-url="{{ route('update_feature', ['id' => $feat->id]) }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_feature', ['id' => $feat->id]) }}" data-name="{{ $feat->name }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
