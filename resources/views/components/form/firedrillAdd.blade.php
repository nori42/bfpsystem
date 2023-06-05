@props(['establishment', 'controlNo'])

<x-modal id="addFiredrillModal" width="50" topLocation="2">

    @php
        $yearNow = date('Y');
        $personName = $establishment->owner->person->first_name . ' ' . $establishment->owner->person->last_name;
        $payer = $establishment->owner->person !== null ? $personName : $establishment->owner->corporate->corporate_name;
    @endphp

    <form action="/establishments/firedrill/{{ $establishment->id }}" method="POST">
        @csrf
        {{-- For Reference Input --}}
        <input type="hidden" name="natureOfPayment" type="text" value="Firedrill">
        <input type="hidden" name="payor" type="text" value="{{ $establishment->owner->id }}">
        <input type="hidden" name="receiptFor" type="text" value="Firedrill">
        <input type="hidden" name="estabId" id="estabId" type="text" value="{{ $establishment->id }}">
        <input type="hidden" name="year" type="text" value="{{ $yearNow }}">
        <legend class="mb-3">Add Firedrill</legend>
        <fieldset>
            <Legend>Firedrill</Legend>

            <x-form.select name="validity" label="Validity Term" placeholder="Select Firedrill Term"
                customAttr="validity required">
                <option value="QUARTERLY">QUARTERLY</option>
                <option value="SEMESTER">SEMESTER</option>
            </x-form.select>

            <fieldset>

                <div class="py-3" validity-quarter style="display:none; grid-template-columns: 80px 80px 80px 80px;">
                    <div>1ST</div>
                    <div>2ND</div>
                    <div>3RD</div>
                    <div>4TH</div>
                    <div><input value="1ST QUARTER" type="radio" name="validityTerm"></div>
                    <div><input value="2ND QUARTER" type="radio" name="validityTerm"></div>
                    <div><input value="3RD QUARTER" type="radio" name="validityTerm"></div>
                    <div><input value="4TH QUARTER" type="radio" name="validityTerm"></div>
                </div>

                <div class="py-3" validity-semester style="display:none; grid-template-columns: 80px 80px">
                    <div>1ST</div>
                    <div>2ND</div>
                    <div><input value="1ST SEMESTER" type="radio" name="validityTerm"></div>
                    <div><input value="2ND SEMESTER" type="radio" name="validityTerm"></div>
                </div>
            </fieldset>

            {{-- <x-form.input name="issuedOn" label="Issued On" type="date" class="w-50" /> --}}
            <x-form.input name="dateMade" label="Date of Drill" type="date" class="w-50" :required="true" />
            {{-- <x-form.input name="nameExtension" label="Name Extension" type="text" value="" /> --}}
        </fieldset>
        <fieldset class="py-3">
            <legend>Receipt Information</legend>
            <x-form.input name="orNo" label="OR No." type="text" :required="true" />
            <div class="d-flex gap-2">
                <x-form.input name="amountPaid" label="Amount Paid" type="text" value="" :required="true" />
                <x-form.input name="dateOfPayment" label="Date of Payment" type="date" class="w-50" value=""
                    :required="true" />
            </div>
        </fieldset>
        <div class="d-flex justify-content-end mt-3 gap-2">
            <button class="btn btn-success" type="submit" name="action" value="add">Add</button>
            <button class="btn btn-success" type="submit" name="action" value="addandprint">Print</button>
        </div>
    </form>
</x-modal>

<script>
    const firedrillQuarter = document.querySelectorAll("[validity-quarter]")
    const firedrillSemester = document.querySelectorAll("[validity-semester]")
    const firedrillTerm = document.querySelectorAll("[validity]")

    firedrillTerm.forEach((element, index) => {
        element.addEventListener("change", () => {
            (element.value === "QUARTERLY") ? firedrillQuarter[index].style.display = "grid":
                firedrillQuarter[index].style.display = "none";

            (element.value === "SEMESTER") ? firedrillSemester[index].style.display = "grid":
                firedrillSemester[index].style.display = "none";
        })
    });
</script>
