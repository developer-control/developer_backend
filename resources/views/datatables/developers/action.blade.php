<div class="btn-group" aria-label="button action">
    {{-- <a href="{{ route('developer_subscription', ['id' => $developer->id]) }}" class="nav-link">
        <span class="fas fa-eye text-secondary mx-2"></span>
    </a> --}}
    @officeCan($this_perm . 'permission.edit')
        <a class="nav-link" role="button" data-bs-placement="bottom" title="Permission"
            href="{{ route($this_route . 'permission.edit', $developer->id) }}">
            <span class="bi bi-person-fill-lock text-secondary mx-2 fw-bold"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'edit')
        <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
            data-bs-placement="bottom" title="Edit developer"
            data-url="{{ route($this_route . 'update', ['id' => $developer->id]) }}" data-name="{{ $developer->name }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $developer->id]) }}" data-name="{{ $developer->name }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan

</div>
