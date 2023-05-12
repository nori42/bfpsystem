@extends('layouts.app')
@section('content')
    <div class="page-content">
        <x-backBtn />
        <x-pageWrapper>

            <form class="add-record-form mt-5 " action="/establishments" method="POST">
                {{-- Cross-site request forgeries  --}}
                {{-- Add @csrf every form --}}
                @csrf
                {{-- Details Action --}}
                <div class="d-flex justify-content-center gap-2 mx-auto steps-title" id="steps-title">
                    <div>
                        <div class="indicator"></div>
                        <span id="ownerTitle" class="py-2 fw-bold">Owner</span>
                    </div>
                    <div>
                        <div class="indicator"></div>
                        <span id="establishmentTitle" class="py-2 fw-bold">Establishment</span>
                    </div>
                    {{-- <span class="py-2">Attachments</span> --}}
                </div>


                {{-- Owner Info --}}
                <div class="mx-auto mt-3 py-3 px-5 rounded-2 form-wrapper" id="ownerDetails" data-step="owner">
                    <div class="header">
                        <h4 id="validateMssg1" class="text-danger">Fill in the required field</h4>
                    </div>
                    {{-- This is hidden only use for reference --}}
                    <input type="text" id="ownerId" name="ownerId" hidden value="">
                    <fieldset>
                        <legend>Person</legend>
                        {{-- Name --}}
                        <div class="d-flex gap-2">
                            <x-form.input type="text" label="Last Name" name="lastName" />
                            <x-form.input type="text" label="First Name" name="firstName" />
                            <x-form.input type="text" label="Middle Name" name="middleName" />
                        </div>

                        {{-- Title and Suffix --}}
                        <div class="d-flex gap-2 w-25">
                            {{-- <div>
                                <label class="info-label" for="suffix">Title</label>
                                <select class="form-control" name="suffix" id="suffix">
                                    <option value="" disabled selected>Select Title</option>
                                    <option value="JR.">DR.</option>
                                    <option value="JR.">ATTY.</option>
                                    <option value="JR.">Type value...</option>
                                    <input class="form-control" id="titleInput" name="titleInput" type="text"
                                        style="font-size: 0.8rem">
                                </select>
                            </div>
                            <div>
                                <label class="info-label" for="suffix">Suffix</label>
                                <select class="form-control" name="suffix" id="suffix">
                                    <option value="" disabled selected>Select Suffix</option>
                                    <option value="JR.">JR.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>
                            </div> --}}
                            <x-form.input type="text" label="Title" name="title" />
                            <x-form.input type="text" label="Name Suffix" name="nameSuffix" />
                        </div>
                        <x-form.input type="text" label="Contact No." name="contactNoPerson" />

                    </fieldset>
                    <hr>
                    {{-- Corporate --}}
                    <fieldset>
                        <legend>Corporate</legend>
                        <x-form.input type="text" label="Corporate Name" name="corporateName" />
                        <x-form.input type="text" label="Contact No." name="contactNoCorporate" />
                    </fieldset>

                </div>

                {{-- Establishment Info --}}
                <div class="mx-auto mt-3 py-3 px-5 rounded-2 form-wrapper" id="establishmentDetails"
                    data-step="establishment">
                    <div class="header">
                        <h2>Establishment Information</h2>
                    </div>
                    <hr>

                    <x-form.input type="text" label="Establishment Name" name="establishmentName" />
                    <label class="fw-bold fs-6" for="isCompanyName"><input class="form-check-inline" type="checkbox"
                            name="isCompanyName" id="isCompanyName">Establishment
                        Name is
                        Corporate Name</label>
                    <x-form.input type="text" label="Business Permit No." name="businessPermitNo" />


                    <x-form.inputWrapper>
                        <div class="d-flex gap-2">
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

                    <x-form.inputWrapper>
                        <div class="d-flex gap-2">
                            <div class="w-100">
                                <label class="info-label">Substation</label>
                                <select class="form-select" name="substation" id="substation" data-establishment-input
                                    required>
                                    <option value="" disabled selected>Select Substation</option>
                                    {{-- @foreach ($stations as $station)
                            <option value="{{$station}}">{{$station}}</option>
                        @endforeach --}}
                                </select>
                            </div>

                            <div class="w-100">
                                <label class="info-label">Building Type</label>
                                <select class="form-select" name="buildingType" id="buildingType" data-establishment-input
                                    required>
                                    <option value="" disabled selected>Select Building Type</option>
                                    {{-- @foreach ($building_type as $btype)
                            <option value="{{$btype}}">{{$btype}}</option>
                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </x-form.inputWrapper>

                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="No. of Story" name="noOfStory" />
                        <x-form.input type="text" label="Height" name="height" />
                    </div>
                    <x-form.input class="w-50" type="text" label="Floor Area" name="floorArea" />
                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="Name of Fire Insurance Co/Co-Insurer"
                            name="fireInsuranceCo" />
                        <x-form.input type="text" label="Latest Mayor's/Business Permit" name="latestPermit" />
                    </div>

                    <x-form.inputWrapper>
                        <label class="info-label">Barangay</label>
                        {{-- <input type="text" id="barangay" name="barangay" class="input" data-establishment-input required> --}}
                        <select class="form-control " name="barangay" id="barangay">
                            <option value="" disabled selected>Select Barangay</option>
                        </select>
                    </x-form.inputWrapper>

                    <x-form.input type="text" label="Address" name="address" :required="true" />
                </div>

                <div class="form-footer mx-auto mt-3 py-3 px-5 rounded-2 d-flex justify-content-between">
                    <input type="button" value="Cancel" id="cancelBtn" class="btn btn-outline-success font-bold"
                        onclick="cancel()">
                    <input type="button" value="Back" id="backBtn" class="btn btn-outline-success font-bold"
                        onclick="prevStep()">
                    <input type="button" value="Next" id="nextBtn" class="btn btn-success font-bold px-5"
                        onclick="nextStep()">
                    <input type="submit" value="Save" id="saveBtn" class="btn btn-success font-bold px-5">
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
        const isCompanyName = document.querySelector('#isCompanyName')

        populateSelect(barangaySelect, barangays)
        populateSelect(occupancySelect, occupancy)
        populateSelect(substationSelect, stations)
        populateSelect(buildingTypeSelect, buildingType)

        //if checkbox is checked
        isCompanyName.addEventListener("change", function() {
            if (isCompanyName.checked == true) {
                const CORPORATE_NAME = document.querySelector('#corporateName').value;
                const establishmentName = document.querySelector('#establishmentName');

                establishmentName.setAttribute('readonly', true)
                establishmentName.value = CORPORATE_NAME
            } else {
                establishmentName.removeAttribute('readonly')
                establishmentName.value = ""
            }
        })

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
        barangaySelect.selectedIndex = 0
        occupancySelect.selectedIndex = 0
        subtypeSelect.selectedIndex = 0
    </script>
@endsection
