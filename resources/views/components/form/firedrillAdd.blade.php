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
        <input class="d-none" name="natureOfPayment" type="text" value="Firedrill">
        <input class="d-none" name="payor" type="text" value="{{ $payer }}">
        <input class="d-none" name="receiptFor" type="text" value="Firedrill">
        <input class="d-none" name="estabId" id="estabId" type="text" value="{{ $establishment->id }}">
        <input class="d-none" name="year" type="text" value="{{ $yearNow }}">

        <fieldset>
            <Legend>Firedrill</Legend>
            <x-form.input name="controlNo" label="Control No." type="text" value="{{ $controlNo }}"
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
                <div><input value="1ST QUARTER" type="radio" name="quarter"></div>
                <div><input value="2ND QUARTER" type="radio" name="quarter"></div>
                <div><input value="3RD QUARTER" type="radio" name="quarter"></div>
                <div><input value="4TH QUARTER" type="radio" name="quarter"></div>
            </div>

            <div class="py-3" id="firedrillSemester" style="display:none; grid-template-columns: 80px 80px">
                <div>1ST</div>
                <div>2ND</div>
                <div><input value="1ST SEMESTER" type="radio" name="semester"></div>
                <div><input value="2ND SEMESTER" type="radio" name="semester"></div>
            </div>

            {{-- <x-form.input name="issuedOn" label="Issued On" type="date" class="w-50" /> --}}
            <x-form.input name="dateMade" label="Date Made" type="date" class="w-50" />
        </fieldset>
        <fieldset class="py-3">
            <legend>Receipt Information</legend>
            <x-form.input name="orNo" label="OR No." type="text" :required="true" />
            <div class="d-flex gap-2">
                <x-form.input name="amountPaid" label="Amount Paid" type="text" value="" />
                <x-form.input name="dateOfPayment" label="Date of Payment" type="date" class="w-50"
                    value="" />
            </div>
        </fieldset>
        <div class="d-flex justify-content-end mt-3 gap-2">
            <button class="btn btn-success" type="submit" name="action" value="add">Add</button>
            <button class="btn btn-success" type="submit" name="action" value="addandprint">Add and Print</button>
        </div>
    </form>
</x-modal>

<script>
    // const firedrillQuarter = document.querySelector("#firedrillQuarter")
    // const firedrillSemester = document.querySelector("#firedrillSemester")
    // const firedrillTerm = document.querySelector("#validity")

    // firedrillTerm.addEventListener("change", () => {
    //     (firedrillTerm.value === "QUARTERLY") ? firedrillQuarter.style.display = "grid": firedrillQuarter.style
    //         .display = "none";

    //     (firedrillTerm.value === "SEMESTER") ? firedrillSemester.style.display = "grid": firedrillSemester.style
    //         .display = "none";
    // })
</script>
