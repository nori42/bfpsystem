{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <h1>Edit Establishment</h1>
            <form class="form-wrapper p-5" action="/establishments/{{ $establishment->id }}/update" method="POST">
                @csrf
                <x-form.input type="text" label="Establishment Name" name="establishmentName" :value="$establishment->establishment_name" />
                <x-form.input type="text" label="Business Permit No." name="businessPermitNo" :value="$establishment->business_permit_no" />

                <x-form.inputWrapper>
                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <label class="info-label">Occupancy</label>
                            <select class="form-select" name="occupancy" id="occupancy" data-establishment-input required>
                                <option value="" disabled selected>Select Occupancy</option>
                                {{-- Options is populated in script --}}
                            </select>
                        </div>
                        <div class="w-100">
                            <label class="info-label">Sub Type</label>
                            <select class="form-select" name="subType" id="subType" data-establishment-input required>
                                {{-- Options is populated in script --}}
                            </select>
                        </div>

                    </div>
                </x-form.inputWrapper>

                <x-form.inputWrapper>
                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <label class="info-label">Substation</label>
                            <select class="form-select" name="substation" id="substation" data-establishment-input required>
                                <option value="" disabled selected>Select Substation</option>
                                {{-- @foreach ($stations as $station)
                        <option value="{{$station}}">{{$station}}</option>
                    @endforeach --}}
                            </select>
                        </div>

                        <div class="w-100">
                            <label class="info-label">Building Structure</label>
                            <select class="form-select" name="buildingType" id="buildingType" data-establishment-input
                                required>
                                <option value="" disabled selected>Select Building Structure</option>
                                {{-- @foreach ($building_type as $btype)
                        <option value="{{$btype}}">{{$btype}}</option>
                    @endforeach --}}
                            </select>
                        </div>
                    </div>
                </x-form.inputWrapper>

                <div class="d-flex gap-2">
                    <x-form.input type="text" label="No. of Story" name="noOfStory" :value="$establishment->no_of_storey" />
                    <x-form.input type="text" label="Height" name="height" :value="$establishment->height" />
                    <x-form.input type="text" label="Floor Area" name="floorArea" :value="$establishment->floor_area" />
                </div>
                <div class="d-flex gap-2">
                    <x-form.input type="text" label="Name of Fire Insurance Co/Co-Insurer" name="fireInsuranceCo"
                        :value="$establishment->fire_insurance_co" />
                    <x-form.input type="text" label="Latest Mayor's/Business Permit" name="latestPermit"
                        :value="$establishment->latest_mayors_permit" />
                </div>

                <x-form.inputWrapper>
                    <label class="info-label">Barangay</label>
                    {{-- <input type="text" id="barangay" name="barangay" class="input" data-establishment-input required> --}}
                    <select class="form-select" name="barangay" id="barangay">
                        <option value="" disabled selected>Select Barangay</option>
                    </select>
                </x-form.inputWrapper>
                <x-form.input type="text" label="Address" name="address" :required="true" :value="$establishment->address" />

                <div class="d-flex justify-content-between">
                    <a href="/establishments/{{ $establishment->id }}" class="btn btn-outline-secondary mt-3 px-3"
                        type="submit">Cancel</a>
                    <button class="btn btn-success mt-3 px-5" type="submit">Save</button>
                </div>
            </form>
        </x-pageWrapper>
    </div>

    {{-- Import Scripts --}}
    <script src="{{ asset('js/script.create.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
    {{-- Import the select options --}}
    <script src="{{ asset('js/selectOptions.js') }}"></script>

    {{-- Page Script --}}
    <script>
        // Populate Select Options
        const barangaySelect = document.querySelector("#barangay")
        const occupancySelect = document.querySelector("#occupancy")
        const subtypeSelect = document.querySelector("#subType")
        const substationSelect = document.querySelector("#substation")
        const buildingTypeSelect = document.querySelector("#buildingType")

        populateSelect(barangaySelect, barangays)
        populateSelect(occupancySelect, occupancy)
        populateSelect(substationSelect, stations)
        populateSelect(buildingTypeSelect, buildingType)

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

        // Reset Selects After Populating
        barangaySelect.value = '{{ $establishment->barangay }}'
        occupancySelect.value = '{{ $establishment->occupancy }}'
        substationSelect.value = '{{ $establishment->substation }}'
        buildingTypeSelect.value = '{{ $establishment->building_type }}'

        // Set the value for the sub type
        const subTypesObj = subtype.filter(option => option.OCCUPANCY_TYPE === '{{ $establishment->occupancy }}')
        const subTypes = subTypesObj.map(obj => obj.SUBTYPE)
        populateSelect(subtypeSelect, subTypes)

        subtypeSelect.value = '{{ $establishment->sub_type }}'
    </script>
@endsection
