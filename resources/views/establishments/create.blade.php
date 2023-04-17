@extends('layouts.app')
@section('content')
<div class="page-content">


    @if($owner == null)
        <form class="add-record-form mt-5" action="/establishments" method="POST">
    @else
        <form class="add-record-form mt-5" action="/establishments/store_from_owner/{{$owner->id}}" method="POST">
    @endif
        {{-- Cross-site request forgeries  --}}
        {{-- Add @csrf every form --}}
        @csrf
        <style>
            .input {
                border: 1px solid gray;
                padding: .4em .3em;
                background: white;
                border-radius: .5em;
                width: 100%;
                text-transform: uppercase;
                font-size: .9rem
            }

            select{
                width: 100%;
                padding: .4em .3em;
                border-radius: .5em;
                font-size: .9rem
            }
            #establishmentDetails, #backBtn, #saveBtn, #validateMssg1{
                display: none;
            }

            .info {
                border: 1px solid gray;
                padding: .4rem .3rem;
                background: white;
                border-radius: .5rem
            }

            .info-label {
                font-weight: 700;
                font-size: .875rem
            }

            .finished-page{
                background-color: #0F2D55;
                color: #ffffff;
            }

            .current-page{
                color: #0F2D55;
                font-weight: bold;
                border:3px solid #0F2D55 !important;
            }

            .steps-title span{
                border: 1px solid #000;
                width: 100%;
                text-align: center;
                vertical-align: middle;
            }

        </style>
        <a href="/establishments" class="material-symbols-outlined btn-back">
            arrow_back
        </a>
        {{-- Details Action --}}
        <div class="d-flex justify-content-center w-75 mx-auto steps-title" id="steps-title">
            <span id="ownerTitle" class="py-2 current-page">Owner</span>
            <span id="establishmentTitle" class="py-2">Establishment</span>
            {{-- <span class="py-2">Attachments</span> --}}
        </div>


        {{-- Owner Info --}}
        <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page" style="background-color: #EFEFEF;" id="ownerDetails" data-step="owner">
            <div class="header">
                <h2>Owner Information</h2>
                <h4 id="validateMssg1" class="text-danger">Fill in the required field</h4>
            </div>
            <hr>

            @if ($owner == null)
                {{-- This is hidden only use for reference --}}
                <input type="text" id="ownerId" name="ownerId" hidden value="">

                <x-form.input type="text" label="Corporate Name" name="corporateName"/>
                
                {{-- <div class="my-2">
                    <label class="info-label">Corporate Name</label>
                    <input type="text" id="corporateName" name="corporateName" value="" class="input" data-owner-input required>
                </div> --}}

                <div class="my-2">
                    <label class="info-label">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="input" value="" data-owner-input required>
                </div>

                <datalist id="listNames">
                    {{-- @foreach ($nameList as $name )
                        <option value="{{$name}}"></option>
                    @endforeach --}}
                </datalist>

                <div class="my-2">
                    <label class="info-label">Middle Name</label>
                    <input type="text" id="middleName" name="middleName" class="input" value="" data-owner-input>
                </div>
                
                <div class="my-2">
                    <label class="info-label">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="input" value="" data-owner-input required>
                </div>

                <div class="my-2">
                    <label class="info-label">Contact No.</label>
                    <input type="text" id="contactNo" name="contactNo" value="" class="input" data-owner-input>
                </div>
            @else
                <div class="my-2">
                    <label class="info-label">Corporate Name</label>
                    <input type="text" id="contactNo" name="corporateName" value="{{$owner->corporate_name}}" data-owner-input class="form-control input" disabled>
                </div>

                <div class="my-2">
                    <label class="info-label">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="form-control input" value="{{$owner->first_name}}" data-owner-input disabled>
                </div>
                
                <div class="my-2">
                    <label class="info-label">Middle Name</label>
                    <input type="text" id="middleName" name="middleName" class="form-control input" value="{{$owner->middle_name}}" data-owner-input disabled>
                </div>

                <div class="my-2">
                    <label class="info-label">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="form-control input" value="{{$owner->last_name}}" data-owner-input disabled>
                </div>

                <div class="my-2">
                    <label class="info-label">Contact No.</label>
                    <input type="text" id="contactNo" name="contactNo" value="{{$owner->contact_no}}" class="form-control input" data-owner-input disabled>
                </div>
            @endif
            
        </div>

        {{-- Establishment Info --}}
        <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page" style="background-color: #EFEFEF;" id="establishmentDetails" data-step="establishment">
            <div class="header">
                <h2>Establishment Information</h2>
            </div>
            <hr>
            <div class="my-2">
                <label class="info-label">Establishment Name</label>
                <input type="text" id="establishmentName" name="establishmentName" class="input" data-establishment-input required>
            </div>
            
            <div class="my-2">
                <label class="info-label">Building Permit No.</label>
                <input type="text" id="buildingPermitNo" name="buildingPermitNo" class="input" data-establishment-input>
            </div>

            <div class="my-2">
                <label class="info-label">Occupancy</label>
                <select class="form-select px-5" name="occupancy" id="occupancy" data-establishment-input required>
                    <option value="" disabled selected>Select Occupancy</option>
                    {{-- @foreach ($occupancies as $occupancy)
                        <option value="{{$occupancy['OCCUPANCY_TYPE']}}">{{$occupancy['OCCUPANCY_TYPE']}}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="my-2 w-100">
                <label class="info-label">Sub Type</label>
                <select class="form-select px-5" name="subType" id="subType" data-establishment-input required>
                    <option value="" disabled selected>Select Occupancy First</option>
                    {{-- @foreach ($occupancies as $occupancy)
                        <option value="{{$occupancy['OCCUPANCY_TYPE']}}">{{$occupancy['OCCUPANCY_TYPE']}}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">Substation</label>
                    <select class="form-select px-5" name="substation" id="substation" data-establishment-input required>
                        <option value="" disabled selected>Select Substation</option>
                        {{-- @foreach ($stations as $station)
                            <option value="{{$station}}">{{$station}}</option>
                        @endforeach --}}
                    </select>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Building Type</label>
                    <select class="form-select px-5" name="buildingType" id="buildingType" data-establishment-input required>
                        <option value="" disabled selected>Select Building Type</option>
                        {{-- @foreach ($building_type as $btype)
                            <option value="{{$btype}}">{{$btype}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">No Of Storey</label>
                    <input type="text" id="noOfStory" name="noOfStory" class="input" data-establishment-input>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Height</label>
                    <input type="text" id="height" name="height" class="input" data-establishment-input>
                </div>
            </div>
    
            <div class="my-2">
                <label class="info-label">Name of Fire Insurance Co/Co-Insurer</label>
                <input type="text" id="fireInsuranceCo" name="fireInsuranceCo" class="input" data-establishment-input>
            </div>
    
            <div class="my-2">
                <label class="info-label">Latest Mayor's/Business Permit</label>
                <input type="text" id="latestPermit" name="latestPermit" class="input" data-establishment-input>
            </div>

            <div class="my-2">
                <label class="fs-5" for="">Is Located Inside Another Establishment:  <input class="form-check-input fs-5" type="checkbox"></label>
                <label class="info-label">Establishment</label>
                <input type="text" id="buildingPermitNo" name="buildingPermitNo" class="input" data-establishment-input>
            </div>
    
            <div class="my-2">
                <label class="info-label">Barangay</label>
                {{-- <input type="text" id="barangay" name="barangay" class="input" data-establishment-input required> --}}
                <select class="form-select px-5" name="barangay" id="barangay">
                    <option value="" disabled selected>Select Barangay</option>
                </select>
            </div>
    
            <div class="my-2">
                <label class="info-label">Address</label>
                <input type="text" id="address" name="address" class="input" data-establishment-input required>
            </div>
        </div>

        {{-- Attachments --}}
        {{-- <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page"  style="background-color: #EFEFEF;" id="attachmentsDetails">
            <div class="header">
                <h2>Attachments</h2>
            </div>
            <div class="my-2">
                <input type="file">
            </div>
            <hr>
        </div>
        --}}
        <div class="form-footer w-75 mx-auto mt-3 py-3 px-5 rounded-2 d-flex justify-content-between">
            <input type="button" value="Cancel" id="cancelBtn" class="btn btn-outline-success font-bold" onclick="cancel()">
            <input type="button" value="Back" id="backBtn" class="btn btn-outline-success font-bold" onclick="prevStep()">
            <input type="button" value="Next" id="nextBtn" class="btn btn-success font-bold px-5" onclick="nextStep()">
            <input type="submit" value="Save" id="saveBtn" class="btn btn-success font-bold px-5">
        </div>
    </form>
</div>

{{-- Import Scripts --}}
<script src="{{ asset('js/script.create.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>
{{--Import the select options--}}
<script src="{{ asset('js/selectOptions.js') }}"></script>

 {{-- Page Script --}}
 <script>
    // Autocomplte
    // const firstName = document.querySelector("#firstName")
    // const datalist = document.querySelector("#listNames")
    // firstName.addEventListener("input",(ev)=>{
    //     populateSearchSuggestion("{{env('APP_URL')}}",ev.target.value,datalist)
    // })

    // Populate Select Options
    const barangaySelect = document.querySelector("#barangay")
    const occupancySelect = document.querySelector("#occupancy")
    const subtypeSelect = document.querySelector("#subType")
    const substationSelect = document.querySelector("#substation")
    const buildingTypeSelect = document.querySelector("#buildingType")

    populateSelect(barangaySelect,barangays)
    populateSelect(occupancySelect,occupancy)
    populateSelect(substationSelect,stations)
    populateSelect(buildingTypeSelect,buildingType)
    
    occupancySelect.addEventListener("change", function(){
        // Reset Subtype
        subtypeSelect.innerHTML = ""

        const subTypesObj = subtype.filter(option => option.OCCUPANCY_TYPE === occupancySelect.value)
        const subTypes = subTypesObj.map(obj => obj.SUBTYPE)
        populateSelect(subtypeSelect,subTypes)

        //Remove the subtype placeholder
        if(subtypeSelect.children[0].value === "")
        subtypeSelect.removeChild(subtypeSelect.children[0]);
    })

    // Reset Selects After Populating
    barangaySelect.selectedIndex = 0
    occupancySelect.selectedIndex = 0
    subtypeSelect.selectedIndex = 0

    // //Show the list of recorded owners when typed
    //     const allOwners = {}
    //     const arrNames = [];

    //     const firstName = document.getElementById('firstName')
    //     firstName.onchange = () =>{
        
    //     var arrName = firstName.value.split(",").map(word => word.trim());

    //     //Get the selected owner that exist in record
    //     const resOwner = allOwners.find(owner => owner.first_name === arrName[0] && owner.middle_name === arrName[1] && owner.last_name === arrName[2])
    //     // Auto fill if owner exist in the record
    //     if(resOwner)
    //     {
    //         const ownerId = document.getElementById('ownerId')
    //         const lastName = document.getElementById('lastName');
    //         const middleName = document.getElementById('middleName'); 
    //         const contactNo = document.getElementById('contactNo');
    //         const corporateName = document.getElementById('corporateName');

    //         firstName.value = resOwner.first_name
    //         middleName.value = resOwner.middle_name
    //         lastName.value = resOwner.last_name
    //         contactNo.value = resOwner.contact_no
    //         corporateName.value = resOwner.corporate_name
    //         ownerId.value = resOwner.id
    //     }

        
    // }
</script>

@endsection