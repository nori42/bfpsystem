@props(['establishment', 'inputAttr' => '', 'key', 'inspection'])

<x-modal id="{{ $key }}" width="50" topLocation="2">
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
    <form id="{{ $key }}" action="/establishments/fsic/{{ $establishment->id }}" method="POST">
        @csrf
        @method('PUT')
        {{-- Hidden, Only used for id --}}
        <input class="d-none" name="inspectionId" type="text" value="{{ $inspection->id }}">
        <input class="d-none" name="receiptId" type="text" value="{{ $inspection->receipt_id }}">

        <fieldset class="d-flex flex-column">
            <legend>Inspection</legend>
            {{-- This is hidden, only used for post request --}}
            <input class="info d-none" type="text" id="establishmentId" name="establishmentId"
                value="{{ $establishment->id }}">
            <input class="info d-none" type="text" id="payor" name="payor"
                value="{{ $establishment->owner->person->first_name }} {{ $establishment->owner->person->last_name }}">
            <input class="info d-none" type="text" id="receiptFor" name="receiptFor"
                value="Fire Safety Inspection Certificate(FSIC)">

            <x-form.input name="inspectionDateDetail" label="Inspection Date" customAttr="{{ $inputAttr }}"
                type="date" class="w-50" value="{{ $inspection->inspection_date }}" :readonly="$printed" />
            <x-form.input name="buildingConditionsDetail" input-inspect label="Building Condtions" type="text"
                customAttr="{{ $inputAttr }}" value="{{ $inspection->building_conditions }}" :readonly="$printed" />
            <x-form.input name="buildingStructuresDetail" input-inspect label="Building Structures" type="text"
                customAttr="{{ $inputAttr }}" value="{{ $inspection->building_structures }}" :readonly="$printed" />

        </fieldset>
        <hr>
        <fieldset>
            <legend>Certificate Issuance</legend>
            <x-form.input name="fsicNoDetail" label="Fire Safety Inspection No. (FSIC No.)"
                customAttr="{{ $inputAttr }}" type="text" value="{{ $inspection->fsic_no }}"
                :readonly="$printed" />

            <x-form.select label="Registration Status" name="registrationStatusDetail" customAttr="{{ $inputAttr }}"
                placeholder="Select Registration Status" :isDetail="true" :readonly="$printed">
                <x-form.selectOptions.options :options="$selectOptions['registrationStatus']" :selected="$inspection->registration_status" :readonly="$printed" />
            </x-form.select>

            <x-form.select label="Issued For" name="issuedForDetail" placeholder="Select Issued For" :options="$selectOptions"
                customAttr="{{ $inputAttr }}" :readonly="$printed">
                <x-form.selectOptions.options :options="$selectOptions['issuedFor']" :selected="$inspection->issued_for" :readonly="$printed" />
            </x-form.select>

        </fieldset>
        <hr>
        <fieldset>
            <legend>Receipt</legend>
            <x-form.input name="orNoDetail" label="OR No." input-inspect type="text"
                value="{{ $inspection->receipt->or_no }}" :readonly="$printed" />

            <x-form.select label="Nature Of Payment" name="natureOfPaymentDetail" customAttr="{{ $inputAttr }}"
                :readonly="$printed" placeholder="Select Nature Of Payment"
                value="{{ $inspection->receipt->nature_of_payment }}">
                <x-form.selectOptions.options :options="$selectOptions['natureOfPayment']" :selected="$inspection->receipt->nature_of_payment" />
            </x-form.select>

            <x-form.input name="dateOfPaymentDetail" label="Date Of Payment" customAttr="{{ $inputAttr }}"
                type="date" class="w-50" value="{{ $inspection->receipt->date_of_payment }}" :readonly="$printed" />

            <x-form.input name="amountPaidDetail" label="Amount Paid" customAttr="{{ $inputAttr }}" type="text"
                value="{{ $inspection->receipt->amount }}" :readonly="$printed" />
        </fieldset>

        @if ($inspection->expiry_date == null)
            <div class="d-flex justify-content-end mt-3 gap-2">
                <button class="btn btn-success" type="submit" name="action" value="save">Save</button>
                <button class="btn btn-success" type="submit" name="action" value="saveandprint">Save and
                    Print</button>
            </div>
        @endif
    </form>

</x-modal>
