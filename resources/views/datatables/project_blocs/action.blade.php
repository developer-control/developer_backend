<div class="btn-group" aria-label="button action">
    <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
        data-bs-placement="bottom" title="Edit Project" data-url="{{ route('update_bloc', ['id' => $bloc->id]) }}"
        data-name="{{ $bloc->name }}" data-project_area_id="{{ $bloc->project_area_id }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_bloc', ['id' => $bloc->id]) }}" data-name="{{ $bloc->name }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
