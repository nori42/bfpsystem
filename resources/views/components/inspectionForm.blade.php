@props(['establishment', 'inputAttr' => '', 'key' => '', 'isDetail' => false])

<form id="inspectionForm" action="/establishments/fsic/{{ $establishment->id }}" method="POST">
    @csrf
    @if ($isDetail)
        @method('PUT')
    @endif
    <fieldset class="d-flex flex-column">
        <legend>Inspection</legend>
        {{-- This is hidden, only used for post request --}}
        <input class="info d-none" type="text" id="establishmentId" name="establishmentId"
            value="{{ $establishment->id }}">
        <input class="info d-none" type="text" id="payor" name="payor"
            value="{{ $establishment->owner->person->first_name }} {{ $establishment->owner->person->last_name }}">
        <input class="info d-none" type="text" id="receiptFor" name="receiptFor"
            value="Fire Safety Inspection Certificate(FSIC)">

        <x-form.input name="inspectionDate{{ $key }}" label="Inspection Date" customAttr="{{ $inputAttr }}"
            type="date" class="w-50" />
        <x-form.input name="buildingConditions{{ $key }}" input-inspect label="Building Condtions"
            type="text" customAttr="{{ $inputAttr }}" />
        <x-form.input name="buildingStructures{{ $key }}" input-inspect label="Building Structures"
            type="text" customAttr="{{ $inputAttr }}" />

    </fieldset>
    <hr>
    <fieldset>
        <legend>Certificate Issuance</legend>

        <x-form.input name="orNo{{ $key }}" label="OR No." input-inspect type="text" />

        <x-form.select label="Nature Of Payment" name="natureOfPayment{{ $key }}"
            customAttr="{{ $inputAttr }}" placeholder="Select Nature Of Payment" />
        <div class="d-flex gap-2">
            <x-form.input name="amountPaid{{ $key }}" label="Amount Paid" customAttr="{{ $inputAttr }}"
                type="text" />
            <x-form.input name="fsicNo{{ $key }}" label="Fire Safety Inspection No. (FSIC No.)"
                customAttr="{{ $inputAttr }}" type="text" />
        </div>
        <x-form.input name="dateOfPayment{{ $key }}" label="Date Of Payment" customAttr="{{ $inputAttr }}"
            type="date" class="w-50" />
        <x-form.select label="Registration Status" name="registrationStatus{{ $key }}"
            customAttr="{{ $inputAttr }}" placeholder="Select Registration Status" />
        <x-form.select label="Issued For" name="issuedFor{{ $key }}" placeholder="Select Issued For"
            customAttr="{{ $inputAttr }}" />
    </fieldset>

    @if (!$isDetail)
        <div class="d-flex justify-content-end mt-3 gap-2">
            <button class="btn btn-success" type="submit" name="action" value="add">Add</button>
            <button class="btn btn-success" type="submit" name="action" value="addandprint">Add and Print</button>
        </div>
    @else
        <div class="d-flex justify-content-end mt-3 gap-2">
            <button class="btn btn-success" type="submit" name="action" value="save">Save</button>
            <button class="btn btn-success" type="submit" name="action" value="saveandprint">Save and Print</button>
        </div>
    @endif
</form>
