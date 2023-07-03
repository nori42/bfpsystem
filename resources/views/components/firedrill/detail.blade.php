@props(['establishment', 'firedrill', 'key'])

<x-modal id="{{ $key }}" width="50" topLocation="2">

    @php
        $yearNow = date('Y');
        if ($establishment->owner->person) {
            $personName = $establishment->owner->person->first_name . ' ' . $establishment->owner->person->last_name;
        }
        $payer = $establishment->owner->person !== null ? $personName : $establishment->owner->corporate->corporate_name;
        $issued = $firedrill->issued_on != null;
        $claimed = $firedrill->date_claimed != null;
        [$number, $term] = explode(' ', $firedrill->validity_term);
        
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

            @if (!$issued)
                <x-form.select name="validity" label="Validity Term" placeholder="Select Firedrill Term"
                    :readonly="$issued" customAttr="validity">
                    <option value="QUARTERLY" {{ $term == 'QUARTER' ? 'selected' : '' }}>QUARTERLY</option>
                    <option value="SEMESTER" {{ $term == 'SEMESTER' ? 'selected' : '' }}>SEMESTER</option>
                    {{-- <option value="ANNUAL">ANNUAL</option> --}}
                </x-form.select>
                <div class="py-3" validity-quarter
                    style="display:{{ $term == 'QUARTER' ? 'grid' : 'none' }}; grid-template-columns: 80px 80px 80px 80px;">
                    <div>1ST</div>
                    <div>2ND</div>
                    <div>3RD</div>
                    <div>4TH</div>
                    <div><input value="1ST QUARTER" type="radio" name="validityTerm"
                            {{ $issued && $firedrill->validity_term != '1ST QUARTER' ? 'disabled' : '' }}
                            {{ $firedrill->validity_term == '1ST QUARTER' ? 'checked' : '' }}></div>
                    <div><input value="2ND QUARTER" type="radio" name="validityTerm"
                            {{ $issued && $firedrill->validity_term != '2ND QUARTER' ? 'disabled' : '' }}
                            {{ $firedrill->validity_term == '2ND QUARTER' ? 'checked' : '' }}></div>
                    <div><input value="3RD QUARTER" type="radio" name="validityTerm"
                            {{ $issued && $firedrill->validity_term != '3RD QUARTER' ? 'disabled' : '' }}
                            {{ $firedrill->validity_term == '3RD QUARTER' ? 'checked' : '' }}></div>
                    <div><input value="4TH QUARTER" type="radio" name="validityTerm"
                            {{ $issued && $firedrill->validity_term != '4TH QUARTER' ? 'disabled' : '' }}
                            {{ $firedrill->validity_term == '4TH QUARTER' ? 'checked' : '' }}></div>
                </div>
                <div class="py-3" validity-semester
                    style="display:{{ $term == 'SEMESTER' ? 'grid' : 'none' }}; grid-template-columns: 80px 80px">
                    <div>1ST</div>
                    <div>2ND</div>
                    <div><input value="1ST SEMESTER" type="radio" name="validityTerm"
                            {{ $issued && $firedrill->validity_term != '1ST SEMESTER' ? 'disabled' : '' }}
                            {{ $firedrill->validity_term == '1ST SEMESTER' ? 'checked' : '' }}></div>
                    <div><input value="2ND SEMESTER" type="radio" name="validityTerm"
                            {{ $issued && $firedrill->validity_term != '2ND SEMESTER' ? 'disabled' : '' }}
                            {{ $firedrill->validity_term == '2ND SEMESTER' ? 'checked' : '' }}></div>
                </div>
            @else
                <x-form.input name="validity" label="Validity" type="text" value="{{ $firedrill->validity_term }}"
                    :readonly="true" />
            @endif

            {{-- <x-form.input name="issuedOn" label="Issued On" type="date" class="w-50" /> --}}
            <x-form.input name="dateMade" label="Date of Drill" type="date" class="w-50" :readonly="$issued"
                value="{{ $firedrill->date_made }}" />

            @if ($issued)
                <x-form.input name="issuedOn" label="Issued On" type="date" class="w-50" :readonly="true"
                    value="{{ $firedrill->issued_on }}" />
            @endif

            @if ($claimed)
                <div class="d-flex gap-2">
                    <x-form.input name="dateClaimed" label="Date Claimed" type="date" :readonly="$issued"
                        value="{{ $firedrill->date_claimed }}" />
                    <x-form.input name="claimedBy" label="Claimed By" type="text" :readonly="$issued"
                        value="{{ $firedrill->claimed_by }}" />
                </div>
            @endif
            @if (!$issued)
                {{-- <x-form.input name="nameExtension" label="Name Extension" type="text" /> --}}
            @endif
        </fieldset>
        <fieldset class="py-3">
            <legend>Receipt Information</legend>
            <x-form.input name="orNo" label="OR No." type="text" value="{{ $firedrill->receipt->or_no }}"
                :readonly="$issued" />
            <div class="d-flex gap-2">
                <x-form.input name="amountPaid" label="₱ Amount Paid" type="text" :readonly="$issued"
                    value="{{ $firedrill->receipt->amount }}" />
                <x-form.input name="dateOfPayment" label="Date of Payment" type="date" class="w-50"
                    :readonly="$issued" value="{{ $firedrill->receipt->date_of_payment }}" />
            </div>
        </fieldset>
        <div class="d-flex justify-content-end mt-3 gap-2">
            <div class="d-flex align-items-center gap-2">
                @if ($firedrill->date_claimed == null && $firedrill->issued_on != null)
                    <x-form.input name="claimedBy" label="Claimed By" />
                    <button class="btn btn-success" type="submit" name="action" value="claimcertificate">Claim
                        Certificate</button>
                @endif

                @if ($firedrill->issued_on != null)
                    <a class="btn btn-success" href="/establishments/firedrill/print/{{ $firedrill->id }}">Preview
                        Certificate</a>
                @endif
            </div>
            {{--             
            @if ($firedrill->date_claimed == null && $firedrill->issued_on != null)
                <div class="d-flex align-items-center gap-2">
                    <x-form.input name="claimedBy" label="Claimed By" />
                    <button class="btn btn-success" type="submit" name="action" value="claimcertificate">Claim
                        Certificate</button>
                    <button class="btn btn-success" type="submit" name="action" value="preview">Preview
                        Certificate</button>
                </div>
            @endif

            @if ($firedrill->date_claimed != null && $firedrill->issued_on != null)
                <button class="btn btn-success" type="submit" name="action" value="preview">Preview
                    Certificate</button>
            @endif --}}

            @if ($firedrill->issued_on == null)
                <button class="btn btn-success" type="submit" name="action" value="save">Save</button>
                <button class="btn btn-success" type="submit" name="action" value="saveandprint">Print</button>
            @endif
        </div>
    </form>
</x-modal>
