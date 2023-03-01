@extends('layouts.layout')
@section('content')
<div class="page-content">
    <form class="add-record-form mt-5" action="/establishments" method="POST">
        {{-- Cross-site request forgeries  --}}
        {{-- Add @csrf every form --}}
        @csrf
        <style>
            .input {`
                border: 1px solid gray;
                padding: .4rem .3rem;
                background: white;
                border-radius: .5rem;
                width: 100%;
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
        {{-- Details Action --}}
        <div class="d-flex justify-content-center w-75 mx-auto mt-5 page-container" id="page-container">
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
            <div class="my-2">
                <label class="info-label">First Name</label>
                <input type="text" id="firstName" name="firstName" class="input" required>
            </div>
            
            <div class="my-2">
                <label class="info-label">Middle Name</label>
                <input type="text" id="middleName" name="middleName" class="input" required>
            </div>
            <div class="my-2">
                <label class="info-label">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="input" required>
            </div>
            <div class="my-2">
                <label class="info-label">Contact No.</label>
                <input type="text" id="contactNo" name="contactNo" class="input" required>
            </div>
            <div class="my-2">
                <label class="info-label">Address</label>
                <input type="text" id="address" name="address" class="input" required>
            </div>
        </div>

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
                <label class="info-label">Corporate Name</label>
                <input type="text" id="corporateName" name="corporateName" class="input" required>
            </div>

            <div class="my-2">
                <label class="info-label">Substation</label>
                <input type="text" id="substation" name="substation" class="input" required>
            </div>
    
            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">Sub Type</label>
                    <input type="text" id="subType" name="subType" class="input" required>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Building Type</label>
                    <input type="text" id="buildingType" name="buildingType" class="input" required>
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
<script src="/js/script.create.js"></script>
@endsection
