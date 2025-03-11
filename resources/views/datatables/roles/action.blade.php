@canany(['manage roles'])
    <div class="btn-group" aria-label="button action">
        @can('manage users')
            <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
                data-bs-placement="bottom" title="Edit role " data-url="{{ route('update_role', ['id' => $role->id]) }}"
                data-name="{{ $role->name }}" data-developer_id="{{ $role->developer_id }}">
                <span class="fas fa-edit text-secondary mx-2"></span>
            </a>
            <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
                data-url="{{ route('delete_role', ['id' => $role->id]) }}" data-name="{{ $role->name }}">
                <span class="fas fa-trash text-secondary mx-2"></span>
            </a>
        @endcan

    </div>
@endcanany
