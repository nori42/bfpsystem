@props(['establishment', 'inputAttr' => '', 'key', 'inspection'])


<div class="modal fade" id="{{ $key }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width:780px;">
        <div class="modal-content px-5 py-4">
            @php
                $printed = $inspection->expiry_date != null;

                //load json files
                $natureOfPayment = json_decode(file_get_contents(public_path() . '/json/selectOptions/natureOfPayment.json'), true);
                $regStatus = json_decode(file_get_contents(public_path() . '/json/selectOptions/registrationStatus.json'), true);
                $issuedFor = json_decode(file_get_contents(public_path() . '/json/selectOptions/issuedFor.json'), true);
                $selectOptions = [
                    'natureOfPayment' => $natureOfPayment,
                    'registrationStatus' => $regStatus,
                    'issuedFor' => $issuedFor,
                ];
            @endphp
            <form id="{{ $key }}" action="/establishments/{{ $establishment->id }}/fsic" method="POST">
                @csrf
                @method('PUT')
                {{-- Hidden, Only used for id --}}
                <input class="d-none" name="inspectionId" type="text" value="{{ $inspection->id }}">
                <input class="d-none" name="receiptId" type="text" value="{{ $inspection->receipt_id }}">

                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        @if ($printed)
                            <div class="px-2 py-1 text-bg-success rounded-1">Printed</div>
                        @endif
                        @if ($inspection->status == 'Expired')
                            <div class="px-2 py-1 text-bg-danger rounded-1">Expired</div>
                        @endif
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <fieldset class="d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <legend class="mb-3">Add Inspection</legend>

                        @if (true)
                            <div dropdown>
                                <button class="btn btn-danger text-nowrap" type="button" dropdown-btn name="action"
                                    value="delete">
                                    <i class="bi bi-x-circle-fill mr-2"></i>Delete</button>
                                <div class="dropdown-menu mt-1 p-3" dropdown-menu style="width: 100px">
                                    <div class="fw-bold text-nowrap">Do you confirm?</div>
                                    <div>
                                        <button class="btn btn-secondary py-0" type="button"
                                            dropdown-btn-dismiss>No</button>
                                        <button class="btn btn-danger py-0" dropdown-btn name="action"
                                            value="delete">Yes</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- This is hidden, only used for post request --}}
                    <input class="info d-none" type="text" id="establishmentId" name="establishmentId"
                        value="{{ $establishment->id }}">
                    <input class="info d-none" type="text" id="payor" name="payor"
                        value="{{ $establishment->owner->first_name }} {{ $establishment->owner->last_name }}">
                    <input class="info d-none" type="text" id="receiptFor" name="receiptFor"
                        value="Fire Safety Inspection Certificate(FSIC)">

                    <x-form.input name="inspectionDateDetail" label="Inspection Date" customAttr="{{ $inputAttr }}"
                        type="date" class="w-50" value="{{ $inspection->inspection_date }}" :readonly="$printed" />
                    {{-- <x-form.input name="noteDetail" input-inspect label="Note" type="text"
                        customAttr="{{ $inputAttr }}" value="{{ $inspection->note }}" :readonly="$printed" /> --}}
                    {{-- <x-form.input name="buildingStructuresDetail" input-inspect label="Building Structures" type="text"
                    customAttr="{{ $inputAttr }}" value="{{ $inspection->building_structures }}" :readonly="$printed" /> --}}

                </fieldset>
                <hr>
                <fieldset>
                    <legend>Certificate Issuance</legend>
                    <x-form.input name="fsicNoDetail" label="Fire Safety Inspection No. (FSIC No.)"
                        customAttr="{{ $inputAttr }}" type="text" value="{{ $inspection->fsic_no }}"
                        :readonly="$printed" />

                    @if ($inspection->expiry_date != null)
                        <x-form.input name="expiryDate" customAttr="{{ $inputAttr }}" label="Expiry Date"
                            value="{{ date('m/d/Y', strtotime($inspection->expiry_date)) }}" type="text"
                            :readonly="$printed" />
                        <x-form.input name="issuedOn" customAttr="{{ $inputAttr }}" label="Issued On"
                            value="{{ date('m/d/Y', strtotime($inspection->issued_on)) }}" type="text"
                            :readonly="$printed" />
                    @endif

                    {{-- @dd($inspection->registration_status) --}}
                    <x-form.select label="Registration Status" name="registrationStatusDetail"
                        placeholder="Select Registration Status" :isDetail="true" :readonly="$printed" :value="$inspection->registration_status">
                        <x-options.registrationStatus />
                    </x-form.select>

                    <x-form.input name="issuedFor" label="Issued For" input-inspect type="text"
                        value="{{ $inspection->issued_for }}" :readonly="$printed" />
                </fieldset>
                <hr>
                <fieldset>
                    <legend>Receipt Details</legend>
                    <x-form.input name="orNoDetail" label="OR No." input-inspect type="text"
                        value="{{ $inspection->receipt->or_no }}" :readonly="$printed" />
                    <div class="d-flex gap-2">
                        <x-form.input name="amountPaidDetail" label="₱ Amount Paid" customAttr="{{ $inputAttr }}"
                            type="text" value="{{ $inspection->receipt->amount }}" :readonly="$printed" />

                        <x-form.input name="dateOfPaymentDetail" label="Date Of Payment"
                            customAttr="{{ $inputAttr }}" type="date" class="w-50"
                            value="{{ $inspection->receipt->date_of_payment }}" :readonly="$printed" />
                    </div>
                    <x-form.select label="Nature Of Payment" name="natureOfPaymentDetail"
                        placeholder="Select Nature Of Payment" :isDetail="true" :readonly="$printed"
                        value="{{ $inspection->receipt->nature_of_payment }}">
                        <x-options.natureOfPayment />
                    </x-form.select>
                </fieldset>
                @if ($inspection->expiry_date == null)
                    <div class="d-flex justify-content-end mt-3 gap-2">
                        {{-- <button class="btn btn-primary" type="submit" name="action" value="save"><i
                                class="bi bi-floppy-fill mr-2"></i>Save</button> --}}
                        <button class="btn btn-primary" type="submit" name="action" value="saveandprint"><i
                                class="bi bi-printer-fill mr-2"></i>Print</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
