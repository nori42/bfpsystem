@props(['establishment', 'firedrill', 'key'])

<x-modal id="{{ $key }}" width="50" topLocation="2">

    @php
        $yearNow = date('Y');
        $personName = $establishment->owner->person->first_name . ' ' . $establishment->owner->person->last_name;
        $payer = $establishment->owner->person !== null ? $personName : $establishment->owner->corporate->corporate_name;
        $issued = $firedrill->issued_on != null;
        $claimed = $firedrill->date_claimed != null;
    @endphp

    <form id="firedrillDetail{{ $firedrill->id }}" action="/establishments/firedrill/{{ $establishment->id }}"
        method="POST">
        @method('PUT')
        @csrf
        {{-- For Reference Input --}}
        <input class="d-none" name="firedrillId" type="text" value="{{ $firedrill->id }}">
        <input class="d-none" name="estabId" id="estabId" type="text" value="{{ $establishment->id }}">

        <fieldset>
            <div class="d-flex justify-content-between align-items-center">
                <Legend>Firedrill</Legend>
                @if ($claimed)
                    <h6 class="px-2 py-1 text-bg-success rounded-1 align-middle">Claimed</h6>
                @endif
                @if ($issued && !$claimed)
                    <div class="d-flex gap-1">
                        <h6 class="px-2 py-1 text-bg-success rounded-1 align-middle">Printed</h6>
                        <h6 class="px-2 py-1 text-bg-danger rounded-1 align-middle">Unclaimed</h6>
                    </div>
                @endif
            </div>
            <x-form.input name="controlNo" label="Control No." type="text" value="{{ $firedrill->control_no }}"
                :readonly="true" />
            <x-form.select name="validity" label="Validity Term" placeholder="Select Firedrill Term">
                <option value="QUARTERLY" selected>QUARTERLY</option>
                {{-- <option value="SEMESTER">SEMESTER</option>
                <option value="ANNUAL">ANNUAL</option> --}}
            </x-form.select>
            <div class="py-3" id="firedrillQuarter" style="display:grid; grid-template-columns: 80px 80px 80px 80px;">
                <div>1ST</div>
                <div>2ND</div>
                <div>3RD</div>
                <div>4TH</div>
                <div><input value="1ST QUARTER" type="radio" name="quarter"
                        {{ $issued && $firedrill->validity_term != '1ST QUARTER' ? 'disabled' : '' }}
                        {{ $firedrill->validity_term == '1ST QUARTER' ? 'checked' : '' }}></div>
                <div><input value="2ND QUARTER" type="radio" name="quarter"
                        {{ $issued && $firedrill->validity_term != '2ND QUARTER' ? 'disabled' : '' }}
                        {{ $firedrill->validity_term == '2ND QUARTER' ? 'checked' : '' }}></div>
                <div><input value="3RD QUARTER" type="radio" name="quarter"
                        {{ $issued && $firedrill->validity_term != '3RD QUARTER' ? 'disabled' : '' }}
                        {{ $firedrill->validity_term == '3RD QUARTER' ? 'checked' : '' }}></div>
                <div><input value="4TH QUARTER" type="radio" name="quarter"
                        {{ $issued && $firedrill->validity_term != '4TH QUARTER' ? 'disabled' : '' }}
                        {{ $firedrill->validity_term == '4TH QUARTER' ? 'checked' : '' }}></div>
            </div>

            <div class="py-3" id="firedrillSemester" style="display:none; grid-template-columns: 80px 80px">
                <div>1ST</div>
                <div>2ND</div>
                <div><input value="1ST SEMESTER" type="radio" name="semester"></div>
                <div><input value="2ND SEMESTER" type="radio" name="semester"></div>
            </div>

            {{-- <x-form.input name="issuedOn" label="Issued On" type="date" class="w-50" /> --}}
            <x-form.input name="dateMade" label="Date Made" type="date" class="w-50" :readonly="$issued"
                value="{{ $firedrill->date_made }}" />

            @if ($issued)
                <x-form.input name="issuedOn" label="Issued On" type="date" class="w-50" :readonly="true"
                    value="{{ $firedrill->issued_on }}" />
            @endif

            @if ($claimed)
                <x-form.input name="dateClaimed" label="Date Claimed" type="date" class="w-50" :readonly="$issued"
                    value="{{ $firedrill->date_claimed }}" />
            @endif
        </fieldset>
        <fieldset class="py-3">
            <legend>Receipt Information</legend>
            <x-form.input name="orNo" label="OR No." type="text" value="{{ $firedrill->receipt->or_no }}"
                :readonly="$issued" />
            <div class="d-flex gap-2">
                <x-form.input name="amountPaid" label="Amount Paid" type="text" :readonly="$issued"
                    value="{{ $firedrill->receipt->amount }}" />
                <x-form.input name="dateOfPayment" label="Date of Payment" type="date" class="w-50"
                    :readonly="$issued" value="{{ $firedrill->receipt->date_of_payment }}" />
            </div>
        </fieldset>
        <div class="d-flex justify-content-end mt-3 gap-2">
            @if ($firedrill->date_claimed == null && $firedrill->issued_on != null)
                <button class="btn btn-success" type="submit" name="action" value="claimcertificate">Claim
                    Certificate</button>
            @endif
            @if ($firedrill->issued_on == null)
                <button class="btn btn-success" type="submit" name="action" value="add">Save</button>
                <button class="btn btn-success" type="submit" name="action" value="addandprint">Save and
                    Print</button>
            @endif
        </div>
    </form>
</x-modal>
