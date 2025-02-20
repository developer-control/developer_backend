<div class="btn-group" aria-label="button action">
    <a href="{{ route('developer_subscription', ['id' => $developer->id]) }}" class="nav-link">
        <span class="fas fa-eye text-secondary mx-2"></span>
    </a>
    <a class="nav-link edit-modal" role="button" data-bs-target="#modal-edit" data-bs-toggle="modal"
        data-bs-placement="bottom" title="Edit developer"
        data-url="{{ route('update_developer', ['id' => $developer->id]) }}" data-name="{{ $developer->name }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_developer', ['id' => $developer->id]) }}" data-name="{{ $developer->name }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
