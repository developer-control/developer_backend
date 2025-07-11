<div class="btn-group" aria-label="button action">
    @officeCan($this_perm . 'edit')
        <a class="nav-link" href="{{ route($this_route . 'edit', ['id' => $row->id]) }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $row->id]) }}" data-name="{{ $row->title }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan

</div>
