@props(['establishment', 'inputAttr' => '', 'key', 'inspection'])

<div class="modal fade" id="{{ $key }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width:780px;">
        <div class="modal-content px-5 py-4">
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="d-flex justify-content-between align-items-center gap-2">
                <div class="fw-bold text-dark mb-3 align-self-center fs-5">Inspection Detail</div>
                <div class="d-flex gap-2">
                    @if (true)
                        <div dropdown>
                            <button class="btn btn-danger text-nowrap" type="button" dropdown-btn name="action"
                                value="delete">
                                <i class="bi bi-x-circle-fill mr-2"></i>Delete</button>
                            <div class="dropdown-menu mt-1 p-3" dropdown-menu style="width: 100px">
                                <div class="fw-bold text-nowrap">Do you confirm?</div>
                                <div>
                                    <form action="/establishments/fsic/{{ $inspection->id }}/archive">
                                        @csrf
                                        <button class="btn btn-secondary py-0" type="button"
                                            dropdown-btn-dismiss>No</button>
                                        <button class="btn btn-danger py-0" dropdown-btn name="action" value="delete"
                                            data-bs-dismiss="modal">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($inspection->status != 'Error')
                        <div dropdown>
                            <button class="btn btn-warning text-nowrap" type="button" dropdown-btn name="action"
                                value="markerror">
                                <i class="bi bi-x-circle-fill mr-2"></i>Mark as Error</button>
                            <div class="dropdown-menu mt-1 p-3" dropdown-menu style="width: 100px">
                                <div class="fw-bold text-nowrap">Do you confirm?</div>
                                <div>
                                    <form action="/establishments/fsic/{{ $inspection->id }}/markerror">
                                        @csrf
                                        <button class="btn btn-secondary py-0" type="button"
                                            dropdown-btn-dismiss>No</button>
                                        <button class="btn btn-warning py-0" dropdown-btn name="action"
                                            value="markerror" data-bs-dismiss="modal">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 mb-3">
                @if ($inspection->expiry_date != null)
                    <div class="px-2 py-1 text-bg-success rounded-1">Printed</div>
                @endif
                @if ($inspection->status == 'Expired')
                    <div class="px-2 py-1 text-bg-danger rounded-1">Expired</div>
                @endif
                @if ($inspection->status == 'Error')
                    <div class="px-2 py-1 text-bg-danger rounded-1">Error</div>
                @endif
            </div>

            {{-- Inspection Info --}}

            <x-inspection.info label="FSIC No." value="{{ $inspection->fsic_no }}" />

            <div class="d-flex">
                <x-inspection.info label="Issued Date" value="{{ date('m-d-Y', strtotime($inspection->issued_on)) }}" />
                <x-inspection.info label="Expiry Date"
                    value="{{ date('m-d-Y', strtotime($inspection->expiry_date)) }}" />

                <x-inspection.info label="Inspection Date"
                    value="{{ date('m-d-Y', strtotime($inspection->inspection_date)) }}" />
            </div>

            <x-inspection.info label="Registration Status" value="{{ $inspection->registration_status }}" />
            <x-inspection.info label="Issued For" value="{{ $inspection->issued_for }}" />
            <div class="fs-6 fw-bold my-2">Receipt Details</div>

            <div class="d-flex gap-2">
                <x-inspection.info label="OR No." value="{{ $inspection->receipt->or_no }}" />
                <x-inspection.info label="Amount" value="₱{{ $inspection->receipt->amount }}" />
                <x-inspection.info label="Date of Payment"
                    value="{{ date('m/d/Y', strtotime($inspection->receipt->date_of_payment)) }}" />
            </div>
            <x-inspection.info label="Nature OF Payment" value="{{ $inspection->receipt->nature_of_payment }}" />
        </div>
    </div>
</div>
