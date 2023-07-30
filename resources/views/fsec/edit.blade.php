@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    @php
        $receipt = $buildingPlan->receipt;
        $building = $buildingPlan->building;
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <h1>Edit Building Plan Application</h1>
            <form class="form-wrapper p-5" action="/fsec/{{ $buildingPlan->id }}" method="POST">
                @csrf
                @method('PUT')

                <fieldset>
                    <legend>Building</legend>
                    <hr>
                    <x-form.inputWrapper>
                        <x-form.input type="text" label="Name of Building/Structure/Facility" name="buildingName"
                            :value="$buildingPlan->name_of_building" />
                        <x-form.input type="text" label="Project Title" name="projectTitle" :value="$buildingPlan->project_title" />
                        <div class="d-flex gap-2 align-items-center">
                            <div class="w-100">
                                <label class="info-label">Occupancy</label>
                                <select class="form-select" name="occupancy" id="occupancy" data-establishment-input
                                    required>
                                    <option value="" disabled selected>Select Occupancy</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>
                            <div class="w-100">
                                <label class="info-label">Sub Type</label>
                                <select class="form-select" name="subType" id="subType" data-establishment-input required>
                                    <option value="" disabled selected>Select Occupancy First</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>
                        </div>
                    </x-form.inputWrapper>

                    <div class="d-flex gap-2 w-50">
                        <x-form.input type="text" label="Building Story" name="buildingStory" :value="$building->building_story" />
                        <x-form.input type="text" label="Floor Area" name="floorArea" :value="$building->floor_area" />
                    </div>
                    <x-form.input type="text" label="Bill Of Materials (BOQ)" name="billOfMaterials" :value="$buildingPlan->bill_of_materials" />
                    <x-form.input type="text" label="Address" name="address" :value="$building->address"
                        customAttr="maxlength=60" />
                </fieldset>

                <fieldset>
                    <legend>Receipt Information</legend>
                    <hr>
                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="OR No." name="orNo" :value="$receipt->or_no" />
                        <x-form.input type="text" label="Amount Paid" name="amountPaid" :value="$receipt->amount" />
                        <x-form.input type="date" label="Date of Payment" name="dateOfPayment" :value="$receipt->date_of_payment" />
                    </div>
                </fieldset>
                <div class="d-flex justify-content-between">
                    <a href="/fsec/{{ $buildingPlan->id }}" class="btn btn-outline-secondary mt-3 px-3"
                        type="submit">Cancel</a>
                    <button class="btn btn-success mt-3 px-5" type="submit">Update</button>
                </div>
            </form>

        </x-pageWrapper>
    </div>
    {{-- Import the select options --}}
    <script src="{{ asset('js/selectOptions.js') }}"></script>

    <script>
        // Populate Select Options
        const occupancySelect = document.querySelector("#occupancy")
        const subtypeSelect = document.querySelector("#subType")
        populateSelect(occupancySelect, occupancy)

        occupancySelect.addEventListener("change", function() {
            // Reset Subtype
            subtypeSelect.innerHTML = ""

            const subTypesObj = subtype.filter(option => option.OCCUPANCY_TYPE === occupancySelect.value)
            const subTypes = subTypesObj.map(obj => obj.SUBTYPE)
            populateSelect(subtypeSelect, subTypes)

            //Remove the subtype placeholder
            if (subtypeSelect.children[0].value === "")
                subtypeSelect.removeChild(subtypeSelect.children[0]);
        })

        // Set Value After Populating
        occupancySelect.value = '{{ $building->occupancy }}'
        // Set the value for the sub type
        const subTypesObj = subtype.filter(option => option.OCCUPANCY_TYPE === '{{ $building->occupancy }}')
        const subTypes = subTypesObj.map(obj => obj.SUBTYPE)
        populateSelect(subtypeSelect, subTypes)

        subtypeSelect.value = '{{ $building->sub_type }}'
    </script>
@endsection
