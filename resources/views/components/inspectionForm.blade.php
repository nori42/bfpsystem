@props(['establishment', 'inputAttr' => '', 'key' => '', 'isDetail' => false])

<form id="inspectionForm" action="/establishments/{{ $establishment->id }}/fsic" method="POST" autocomplete="off">
    @csrf
    @if ($isDetail)
        @method('PUT')
    @endif

    @php
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
    <div class="d-flex justify-content-between">
        <legend class="mb-3">Add Inspection</legend>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <fieldset class="d-flex flex-column">
        <legend>Inspection</legend>
        {{-- This is hidden, only used for post request --}}
        <input type="hidden" id="establishmentId" name="establishmentId" value="{{ $establishment->id }}">
        <input type="hidden" id="payor" name="payor" value="{{ $establishment->owner->id }}">
        <input type="hidden" id="receiptFor" name="receiptFor" value="Fire Safety Inspection Certificate(FSIC)">

        <x-form.input name="inspectionDate{{ $key }}" label="Inspection Date" customAttr="{{ $inputAttr }}"
            type="date" class="w-50" :required="true" />

    </fieldset>
    <hr>
    <fieldset>
        <legend>Certificate Issuance</legend>

        <x-form.input name="fsicNo{{ $key }}" label="Fire Safety Inspection No. (FSIC No.)"
            customAttr="{{ $inputAttr }}" type="text" :required="true" />

        <x-form.select label="Registration Status" name="registrationStatus{{ $key }}"
            customAttr="{{ $inputAttr }} required" placeholder="--Select Registration Status--">
            <x-options.registrationStatus />
        </x-form.select>

        <x-form.select label="Issued For" name="issuedFor{{ $key }}" placeholder="--Select Issued For--"
            customAttr="{{ $inputAttr }}">
            <x-options.issuedFor />
        </x-form.select>
    </fieldset>
    <hr>
    <fieldset>
        <legend>Receipt Information</legend>
        <x-form.input name="orNo{{ $key }}" label="OR No." input-inspect type="text" :required="true" />
        <div class="d-flex gap-2">
            <x-form.input name="amountPaid{{ $key }}" label="Amount Paid" customAttr="{{ $inputAttr }}"
                type="text" :required="true" />
            <x-form.input name="dateOfPayment{{ $key }}" label="Date Of Payment"
                customAttr="{{ $inputAttr }}" type="date" class="w-50" :required="true" />
        </div>
        <x-form.select label="Nature Of Payment" name="natureOfPayment{{ $key }}"
            customAttr="{{ $inputAttr }} required" placeholder="Select Nature Of Payment">
            <x-form.selectOptions.options :options="$selectOptions['natureOfPayment']" />
        </x-form.select>

    </fieldset>

    <div class="d-flex justify-content-end mt-3 gap-2">
        {{-- <button class="btn btn-primary px-3 py-0" type="submit" name="action" value="add">
            <i class="bi bi-plus-circle-fill px-2"></i>
            <span>Add</span>
        </button> --}}
        <button class="btn btn-primary px-4" type="submit" name="action" value="addandprint">
            <i class="bi bi-printer-fill mr-3"></i>
            Print
        </button>
    </div>
    {{-- @if (!$isDetail)
    @else
        <div class="d-flex justify-content-end mt-3 gap-2">
            <button class="btn btn-primary" type="submit" name="action" value="save">Save</button>
            <button class="btn btn-primary" type="submit" name="action" value="saveandprint">Save and Print</button>
        </div>
    @endif --}}
</form>

<script>
    const registrationStatus = document.querySelector('#registrationStatus')
    const natureOfPayment = document.querySelector('#natureOfPayment')
    const issuedFor = document.querySelector('#issuedFor')

    const issuedForOpt = {
        NEW: ["THE PURPOSE OF SECURING BUSINESS PERMIT", "NEW BUSINESS PERMIT"],
        RENEWAL: ["RENEWAL OF BUSINESS PERMIT"],
        ACCREDITATION: [
            "RENEWAL OF BUSINESS PERMIT/TESDA ACCREDITATION",
            "RENEWAL OF BUSINESS PERMIT/DOT ACCREDITATION",
        ],
        OTHER: [
            "RENEWAL OF BUSINESS PERMIT/TESDA ACCREDITATION",
            "RENEWAL OF BUSINESS PERMIT/DOT ACCREDITATION",
            "ANNUAL INSPECTION OF PEZA CERTIFICATE",
        ],
        OCCUPANCY: ["PEZA OCCUPANCY PERMIT", "OCCUPANCY PERMIT"],
    };

    function appendOption(selectElem, option) {
        const optionEl = document.createElement("option");
        optionEl.setAttribute("value", option);
        optionEl.innerHTML = option;
        selectElem.appendChild(optionEl);
    }

    registrationStatus.addEventListener('change', () => {
        issuedFor.innerHTML = "";

        switch (registrationStatus.value) {
            case "NEW": {
                natureOfPayment.value = "FSIF(NBP) - FIRE SAFETY INSPECTION FEE - BFP-06"
                issuedForOpt.NEW.forEach(option => {
                    appendOption(issuedFor, option)
                });
            }
            break;
            case "RENEWAL": {
                natureOfPayment.value = "FSIF(RBP) - FIRE SAFETY INSPECTION FEE - BFP-06"
                issuedForOpt.RENEWAL.forEach(option => {
                    appendOption(issuedFor, option)
                });
            }
            break;
            case "OCCUPANCY": {
                natureOfPayment.value = "FSIF(OCC) - FIRE SAFETY INSPECTION FEE - BFP-06"
                issuedForOpt.OCCUPANCY.forEach(option => {
                    appendOption(issuedFor, option)
                });
            }
            break;
            case "ACCREDITATION": {
                natureOfPayment.value = "FSIF(ACCREDITATION) - FIRE SAFETY INSPECTION FEE - BFP-06"
                issuedForOpt.ACCREDITATION.forEach(option => {
                    appendOption(issuedFor, option)
                });
            }
            break;
            case "OTHER": {
                issuedForOpt.OTHER.forEach(option => {
                    appendOption(issuedFor, option)
                });
            }
            break;
        }
    })
</script>
