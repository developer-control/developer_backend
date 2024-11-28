<div class="dropdown">
    <button class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-ellipsis-h fs-4 text-primary"></i>
    </button>

    <ul class="dropdown-menu">
        <li>
            <button class="dropdown-item edit-modal" data-bs-toggle="modal" data-bs-target="#modal-edit"
                data-url="{{ route('update_role', ['id' => $role->id]) }}" data-name="{{ $role->name }}"
                data-developer_id="{{ $role->developer_id }}" data-developer_name="{{ @$role->developer->name }}"><i
                    class="fas fa-edit me-3"></i> Edit</button>
        </li>
        <li>
            <button class="dropdown-item delete-modal" data-bs-toggle="modal" data-bs-target="#modal-delete"
                data-url="{{ route('delete_role', ['id' => $role->id]) }}" data-name="{{ $role->name }}"> <i
                    class="fas fa-trash me-3"></i>
                Delete</button>
        </li>
    </ul>
</div>