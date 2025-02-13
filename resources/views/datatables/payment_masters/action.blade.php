<div class="btn-group" aria-label="button action">
    <a class="nav-link edit-modal" href="" data-bs-placement="bottom" data-bs-toggle="modal"
        data-bs-target="#modal-edit" title="Edit Project"
        data-url="{{ route('update_payment_master', ['id' => $row->id]) }}" data-title="{{ $row->title }}"
        data-type="{{ $row->type }}" data-description="{{ $row->description }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_payment_master', ['id' => $row->id]) }}" data-title="{{ $row->title }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
