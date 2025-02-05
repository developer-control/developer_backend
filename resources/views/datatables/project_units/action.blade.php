<div class="btn-group" aria-label="button action">
    <a class="nav-link" href="{{ route('menu_detail_unit', ['id' => $unit->id]) }}">
        <span class="fas fa-eye text-secondary mx-2"></span>
    </a>
    <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
        data-bs-placement="bottom" title="Edit Project" data-url="{{ route('update_unit', ['id' => $unit->id]) }}"
        data-name="{{ $unit->name }}" data-project_bloc_id="{{ $unit->project_bloc_id }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_unit', ['id' => $unit->id]) }}" data-name="{{ $unit->name }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
