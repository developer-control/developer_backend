<div class="btn-group" aria-label="button action">
    <a class="nav-link edit-modal" role="button" data-bs-placement="bottom"
        href="{{ route('edit_developer_bank', ['id' => $row->id]) }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_developer_bank', ['id' => $row->id]) }}" data-title="{{ $row->name }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
