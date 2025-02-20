<div class="btn-group" aria-label="button action">
    <a href="{{ route('detail_subscription', ['id' => $row->id]) }}" class="nav-link">
        <span class="fas fa-eye text-secondary mx-2"></span>
    </a>
    <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
        data-bs-placement="bottom"
        @isset($data)
        @foreach ($data as $key => $item)
            data-{{ $key }}="{{ $item }}"
        @endforeach
    @endisset
        data-url="{{ route('update_subscription', ['id' => $row->id]) }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_subscription', ['id' => $row->id]) }}" data-name="{{ $row->name }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
