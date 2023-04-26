@props(['key'])

<tr class="bg-secondary-subtle">
    <td class="p-5 rounded-2 fw-bold">2023-CCSF-123</td>
    <td>
        <table class="w-100">
            <thead class="text-center">
                <th>1ST</th>
                <th>2ND</th>
                <th>3RD</th>
                <th>4TH</th>
            </thead>
            <tbody class="text-center">
                <td>&#x2713</td>
                <td>&#x2713</td>
                <td>&#x2713</td>
                <td>&#x2713</td>
            </tbody>
        </table>
    </td>
    <td class="text-center">
        <button class="btn btn-success" onclick="openModal(`{{ $key }}`)">
            View Firedrill
        </button>
    </td>
</tr>

<x-modal id="{{ $key }}" width="50" topLocation="2">
    <form>
        {{-- For Reference Input --}}
        <input class="d-none" id="natureOfPayment" type="text" value="">
        <input class="d-none" id="payor" type="text" value="">
        <input class="d-none" id="receiptFor" type="text" value="">
        <input class="d-none" id="year" type="text" value="">

        <fieldset>
            <Legend>Firedrill</Legend>
            <x-form.input name="controlNumber" label="Control No." type="text" class="w-50" value="2023-CCSF-1"
                :readonly="true" />
        </fieldset>
        <button class="btn btn-success mt-3 w-25 ml-auto" id="addInspectionBtn"
            onclick="openModal('addInspectionModal')">
            <span class="material-symbols-outlined align-middle">
                add
            </span>
            Add Firedrill
        </button>
        <fieldset>
            <legend>Add Firedrill</legend>
            <div style="display:grid; grid-template-columns: 80px 80px 80px 80px;">
                <div>1ST</div>
                <div>2ND</div>
                <div>3RD</div>
                <div>4TH</div>
                <div><input type="checkbox"></div>
                <div><input type="checkbox"></div>
                <div><input type="checkbox"></div>
                <div><input type="checkbox"></div>
            </div>
            <x-form.input name="orNo" label="OR No." type="text" class="w-50" />

            <x-form.input name="inspectionDateDetail" label="Inspection Date" type="date" class="w-50"
                value="" />
        </fieldset>
    </form>
    <div class="mt-4">
        <h4>Firedrill Payment</h4>
    </div>
</x-modal>
