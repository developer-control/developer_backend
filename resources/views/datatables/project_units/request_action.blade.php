<a class="btn-approve-modal btn btn-sm btn-primary px-2" data-bs-target="#modal-approve" data-bs-toggle="modal"
    data-url="{{ route('approve_claim_unit', ['id' => $unit->id]) }}" data-name="{{ $unit?->projectunit?->name }}"
    data-ownership_unit_id="{{ $unit->ownership_unit_id }}" data-owner="{{ $unit?->user?->name }}">
    Approve
</a>
<a class="btn-reject-modal btn btn-sm btn-warning px-2" data-bs-target="#modal-reject" data-bs-toggle="modal"
    data-url="{{ route('reject_claim_unit', ['id' => $unit->id]) }}" data-name="{{ $unit?->projectunit?->name }}"
    data-ownership_unit_id="{{ $unit->ownership_unit_id }}" data-owner="{{ $unit?->user?->name }}">
    Reject
</a>
