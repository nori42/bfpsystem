@extends('layouts.layout')
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
                padding: .4rem .3rem;
                background: white;
                border-radius: .5rem;
                width: 100%;
                text-transform: uppercase;
            }

            select{
                width: 100%;
                padding: .4rem .3rem;
                border-radius: .5rem;
            }

            .info {
                border: 1px solid gray;
                padding: .4rem .3rem;
                background: white;
                border-radius: .5rem
            }

            .info-label {
                font-weight: 700;
            }


            .page-container{
                border: 1px solid #000;
            }

            .page-container span{
                border: 1px solid #000;
                width: 100%;
                text-align: center;
            }
            
            #ownerDetails{
                display: block;
            }

            #establismentDetails{
                display: none;
            }

            #attachmentsDetails{
                display: none;
            }

            .finished-page{
                background-color: #74B976;
                color: #EFEFEF;
            }

            .current-page{
                background-color: #672424;
                color: #EFEFEF
            }

            #saveBtn{
                display: none;
            }

        </style>
        <a href="/establishments" class="material-symbols-outlined btn-back">
            arrow_back
        </a>
        {{-- Details Action --}}
        <div class="d-flex justify-content-center w-75 mx-auto page-container" id="page-container">
            <span class="py-2 current-page">Owner</span>
            <span class="py-2">Establishment</span>
            <span class="py-2">Attachments</span>
        </div>


        {{-- Owner Info --}}
        <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page" style="background-color: #EFEFEF;" id="ownerDetails">
            <div class="header">
                <h2>Owner Information</h2>
            </div>
            <hr>

            @if ($owner == null)
                <div class="my-2">
                    <label class="info-label">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="input" value="" required>
                </div>
                
                <div class="my-2">
                    <label class="info-label">Middle Name</label>
                    <input type="text" id="middleName" name="middleName" class="input" value="" required>
                </div>
                <div class="my-2">
                    <label class="info-label">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="input" value="" required>
                </div>
                <div class="my-2">
                    <label class="info-label">Contact No.</label>
                    <input type="text" id="contactNo" name="contactNo" value="" class="input" required>
                </div>
            @else
                <div class="my-2">
                    <label class="info-label">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="form-control input" value="{{$owner->middle_name}}" disabled>
                </div>
                
                <div class="my-2">
                    <label class="info-label">Middle Name</label>
                    <input type="text" id="middleName" name="middleName" class="form-control input" value="{{$owner->middle_name}}" disabled>
                </div>
                <div class="my-2">
                    <label class="info-label">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="form-control input" value="{{$owner->last_name}}" disabled>
                </div>
                <div class="my-2">
                    <label class="info-label">Contact No.</label>
                    <input type="text" id="contactNo" name="contactNo" value="{{$owner->contact_no}}" class="form-control input" disabled>
                </div>
            @endif
            
        </div>
        {{-- arrays of sub-stations --}}
        @php
            $stations = [
                'CCSF','CPB','GUADALUPE','LABANGON','LAHUG','MABOLO','PAHINA CENTRAL','PARDO','PARI-AN','SAN NICOLAS','TALAMBAN'
            ];

            $building_type = [
                'Small', 'Medium', 'Large', 'High Rise'
            ]
        @endphp

        {{-- Establishment Info --}}
        <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page" style="background-color: #EFEFEF;" id="establismentDetails">
            <div class="header">
                <h2>Establishment Information</h2>
            </div>
            <hr>
            <div class="my-2">
                <label class="info-label">Establishment Name</label>
                <input type="text" id="establishmentName" name="establishmentName" class="input" required>
            </div>
            
            <div class="my-2">
                <label class="info-label">Occupancy</label>
                <select name="occupancy" id="occupancy" required>
                    <option value="">Select Occupancy</option>
                    @foreach ($occupancies as $occupancy)
                        <option value="{{$occupancy['OCCUPANCY_TYPE']}}">{{$occupancy['OCCUPANCY_TYPE']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="my-2 w-100">
                <label class="info-label">Sub Type</label>
                <select name="subType" id="subType" required>
                    <option value="">Select Sub Type</option>
                    {{-- @foreach ($occupancies as $occupancy)
                        <option value="{{$occupancy['OCCUPANCY_TYPE']}}">{{$occupancy['OCCUPANCY_TYPE']}}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">Substation</label>
                    <select name="substation" id="substation" required>
                        <option value="">Select Substation</option>
                        @foreach ($stations as $station)
                            <option value="{{$station}}">{{$station}}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Building Type</label>
                    <select name="buildingType" id="buildingType" required>
                        <option value="">Select Building Type</option>
                        @foreach ($building_type as $btype)
                            <option value="{{$btype}}">{{$btype}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">No Of Storey</label>
                    <input type="text" id="noOfStory" name="noOfStory" class="input" required>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Height</label>
                    <input type="text" id="height" name="height" class="input" required>
                </div>
            </div>
    
            <div class="my-2">
                <label class="info-label">Building Permit No.</label>
                <input type="text" id="buildingPermitNo" name="buildingPermitNo" class="input" required>
            </div>
    
            <div class="my-2">
                <label class="info-label">Name of Fire Insurance Co/Co-Insurer</label>
                <input type="text" id="fireInsuranceCo" name="fireInsuranceCo" class="input" required>
            </div>
    
            <div class="my-2">
                <label class="info-label">Latest Mayor's/Business Permit</label>
                <input type="text" id="latestPermit" name="latestPermit" class="input" required>
            </div>
    
            <div class="my-2">
                <label class="info-label">Barangay</label>
                <input type="text" id="barangay" name="barangay" class="input" required>
            </div>
    
            <div class="my-2">
                <label class="info-label">Address</label>
                <input type="text" id="address" name="address" class="input" required>
            </div>
        </div>

        {{-- Attachments --}}
        <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page"  style="background-color: #EFEFEF;" id="attachmentsDetails">
            <div class="header">
                <h2>Attachments</h2>
            </div>
            <div class="my-2">
                <input type="file">
            </div>
            <hr>
        </div>

        <div class="form-footer w-75 mx-auto mt-3 py-3 px-5 rounded-2 d-flex justify-content-between">
            <input type="button" value="Cancel" id="cancelBtn" class="btn btn-danger">
            <input type="button" value="Next" id="nextBtn" class="btn btn-primary">
            <input type="submit" value="Save" id="saveBtn" class="btn btn-success">
        </div>
    </form>
</div>
{{-- ADDED JS FOR THIS PAGE ONLY --}}
<script>
    const OCCUPANCY = document.getElementById("occupancy")
    const SUBTYPE = document.getElementById("subType")
    var subtypes = {!! json_encode($subtype) !!}

    //OCCUPANCY EVENT LISTENER
    OCCUPANCY.addEventListener("change", function(){
        var child = [...SUBTYPE.children]
        child.forEach(element => {
            //remove current list of types
            element.remove()
        });

        // populates sub type
        for (let i = 0; i < subtypes.length; i++) {
            // verify if same
            if(subtypes[i]['OCCUPANCY_TYPE'] == OCCUPANCY.value){
                var option = document.createElement("option")
                option.value = subtypes[i]['SUBTYPE']
                option.textContent = subtypes[i]['SUBTYPE']
                SUBTYPE.appendChild(option)
            }
        }
    })
</script>
<script src="/js/script.create.js"></script>
@endsection