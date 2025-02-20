<div class="btn-group" aria-label="button action">

    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_developer_subscription', ['id' => $row->id]) }}"
        data-name="{{ $row->subscription->name }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
