<div class="btn-group" aria-label="button action">

    @officeCan($this_perm . 'edit')
        <a class="nav-link edit-modal" role="button" data-bs-placement="bottom" title="Edit Project"
            href="{{ route($this_route . 'edit', ['id' => $obj->id]) }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $obj->id]) }}" data-name="{{ $obj->name }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan
</div>
