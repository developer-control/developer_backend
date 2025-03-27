@canany(['manage permission'])
    <div class="btn-group" aria-label="button action">

        <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
            data-bs-placement="bottom" title="Edit permission"
            data-url="{{ route('update_permission', ['id' => $permission->id]) }}" data-name="{{ $permission->name }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route('delete_permission', ['id' => $permission->id]) }}" data-name="{{ $permission->name }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    </div>
@endcanany
