<div class="btn-group" aria-label="button action">
    <a class="nav-link edit-modal" role="button" data-bs-placement="bottom" title="Edit Project"
        href="{{ route('edit_facility', ['id' => $facility->id]) }}">
        <span class="fas fa-edit text-secondary mx-2"></span>
    </a>
    <a class="nav-link delete-modal" href="" data-bs-toggle="modal" data-bs-target="#modal-delete"
        data-url="{{ route('delete_facility', ['id' => $facility->id]) }}" data-title="{{ $facility->title }}">
        <span class="fas fa-trash text-secondary mx-2"></span>
    </a>

</div>
