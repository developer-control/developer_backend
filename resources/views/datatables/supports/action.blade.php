<div class="btn-group" aria-label="button action">
    @officeCan($this_perm . 'edit')
        <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
            data-bs-placement="bottom" title="Edit Bantuan"
            data-url="{{ route($this_route . 'update', ['id' => $support->id]) }}" data-title="{{ $support->title }}"
            data-developer_id="{{ $support->developer_id }}" data-type="{{ $support->type }}"
            data-value="{{ $support->value }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $support->id]) }}" data-title="{{ $support->title }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan
</div>
