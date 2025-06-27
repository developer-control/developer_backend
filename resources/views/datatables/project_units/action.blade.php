<div class="btn-group" aria-label="button action">
    <a class="nav-link" href="{{ route($this_route . 'detail', ['id' => $unit->id]) }}">
        <span class="fas fa-eye text-secondary mx-2"></span>
    </a>
    @officeCan($this_perm . 'edit')
        <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
            data-bs-placement="bottom" title="Edit Project"
            data-url="{{ route($this_route . 'update', ['id' => $unit->id]) }}" data-name="{{ $unit->name }}"
            data-project_bloc_id="{{ $unit->project_bloc_id }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $unit->id]) }}" data-name="{{ $unit->name }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan
</div>
