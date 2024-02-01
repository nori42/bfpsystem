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
        $selectOptions = [
            'natureOfPayment' => $natureOfPayment,
            'registrationStatus' => $regStatus,
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

        <x-form.select label="Issued For" name="issued_For{{ $key }}" placeholder="--Select Issued For--"
            customAttr="{{ $inputAttr }}">
            {{-- <x-options.issuedFor /> --}}
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
        <button class="d-none btn btn-warning px-4" type="submit" name="action" value="addandprintoccupancy"
            id="btnPrintOccupancy">
            <i class="bi bi-printer-fill mr-3"></i>
            Print Occupancy
        </button>
        <button class="btn btn-primary px-4" type="submit" name="action" value="addandprint">
            <i class="bi bi-printer-fill mr-3"></i>
            Print
        </button>
    </div>
</form>

<script></script>
