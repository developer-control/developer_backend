<div class="btn-group" aria-label="button action">
    <a class="nav-link edit-modal" href="" data-bs-placement="bottom" data-bs-toggle="modal"
        data-bs-target="#modal-edit" title="Edit Project" data-url="{{ route('update_faq', ['id' => $faq->id]) }}"
        data-title="{{ $faq->title }}" data-description="{{ $faq->description }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_faq', ['id' => $faq->id]) }}" data-title="{{ $faq->title }}"
        data-description="{{ $faq->description }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
