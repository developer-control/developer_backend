<div class="btn-group" aria-label="button action">
    {{-- <a class="nav-link" href="{{ route('menu_area', ['project_id' => $project->id]) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" title="Project Area">
        <span class="fas fa-layer-group text-secondary mx-2"></span>
    </a> --}}
    @officeCan($this_perm . 'edit')
        <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
            data-bs-placement="bottom" title="Edit Project" data-url="{{ route($this_route . 'update', ['id' => $area->id]) }}"
            data-name="{{ $area->name }}" data-project_id="{{ $area->project_id }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $area->id]) }}" data-name="{{ $area->name }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan
</div>
