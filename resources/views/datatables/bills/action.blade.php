<div class="btn-group" aria-label="button action">

    <a class="nav-link" href="{{ route('edit_bill', ['id' => $row->id]) }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_bill', ['id' => $row->id]) }}" data-name="{{ $row->title }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
