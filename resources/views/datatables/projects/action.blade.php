<div class="btn-group" aria-label="button action">
    {{-- <a class="nav-link" href="{{ route('menu_area', ['project_id' => $project->id]) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" title="Project Area">
        <span class="fas fa-layer-group text-secondary mx-2"></span>
    </a> --}}
    @officeCan($this_perm . 'edit')
        <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
            data-bs-placement="bottom" title="Edit Project"
            data-url="{{ route($this_route . 'update', ['id' => $project->id]) }}" data-name="{{ $project->name }}"
            data-city_id="{{ $project->city_id }}" data-developer_id="{{ $project->developer_id }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $project->id]) }}" data-name="{{ $project->name }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan
</div>
{{-- 
<div class="dropdown">
    <button class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-ellipsis-h fs-4 text-primary"></i>
    </button>

    <ul class="dropdown-menu">
        <li>
            <button class="dropdown-item edit-modal" data-bs-toggle="modal" data-bs-target="#modal-edit"
                data-url="{{ route('update_project', ['id' => $project->id]) }}" data-name="{{ $project->name }}"
                data-city_id="{{ $project->city_id }}" data-developer_id="{{ $project->developer_id }}"><i
                    class="fas fa-edit me-3"></i> Edit</button>
        </li>
        <li>
            <button class="dropdown-item delete-modal" data-bs-toggle="modal" data-bs-target="#modal-delete"
                data-url="{{ route('delete_project', ['id' => $project->id]) }}" data-name="{{ $project->name }}">
                <i class="fas fa-trash me-3"></i>
                Delete</button>
        </li>
    </ul>
</div> --}}
