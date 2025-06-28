<div class="dropdown">
    <button class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-ellipsis-h fs-4 text-primary"></i>
    </button>

    <ul class="dropdown-menu">
        @officeCan($this_perm . 'edit')
            <li>
                <button class="dropdown-item edit-modal" data-bs-toggle="modal" data-bs-target="#modal-edit"
                    data-url="{{ route($this_route . 'update', ['id' => $province->id]) }}"
                    data-name="{{ $province->name }}"><i class="fas fa-edit me-3"></i> Edit</button>
            </li>
        @endofficeCan
        @officeCan($this_perm . 'delete')
            <li>
                <button class="dropdown-item delete-modal" data-bs-toggle="modal" data-bs-target="#modal-delete"
                    data-url="{{ route($this_route . 'delete', ['id' => $province->id]) }}" data-name="{{ $province->name }}">
                    <i class="fas fa-trash me-3"></i>
                    Delete</button>
            </li>
        @endofficeCan
    </ul>
</div>
