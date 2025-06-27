<div class="btn-group" aria-label="button action">
    @officeCan($this_perm . 'edit')
        <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
            data-bs-placement="bottom"
            @isset($row)
        @foreach ($row->setVisible(['name', 'premium_type', 'is_edit', 'is_premium', 'with_start_value'])->toArray() as $key => $item)
            data-{{ $key }}="{{ $item }}"
        @endforeach
    @endisset
            data-url="{{ route($this_route . 'update', ['id' => $row->id]) }}">
            <span class="fas fa-edit text-secondary mx-2"></span>
        </a>
    @endofficeCan
    @officeCan($this_perm . 'delete')
        <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
            data-url="{{ route($this_route . 'delete', ['id' => $row->id]) }}" data-title="{{ $row->name }}">
            <span class="fas fa-trash text-secondary mx-2"></span>
        </a>
    @endofficeCan
</div>
