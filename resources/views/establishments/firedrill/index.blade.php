@extends('layouts.layout')

@section('content')

<div class="page-content">
    {{-- Put page content here --}}
    {{-- FSIC Action --}}
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <a href="" id="" class="btn btn-action rounded-0 fs-5 fsic-active">Example</a>
        <a href=""  id="" class="btn btn-action rounded-0 fs-5">Example</a>
        <a href=""  id="" class="btn btn-action rounded-0 fs-5">Example</a>
    </div>
    {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto mt-5">
        <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
        <div class="fs-5">Record No.: {{$establishment->id}}</div>
        <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Establishment: </span>{{$establishment->establishment_name}}</div>
    </div>
 
    {{-- Establishment Info --}}
    <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page" style="background-color: #EFEFEF;" id="establismentDetails">
        <div class="header">
            <h2>Establishment Information</h2>
        </div>
        <hr>
        <div class="my-2">
            <label class="info-label">Establishment Name</label>
            <input class="form-control input-lg" type="text" id="establishmentName" name="establishmentName" class="input" required>
        </div>
        
        <div class="my-2">
            <label class="info-label">Address</label>
            <input class="form-control input-lg" type="text" id="corporateName" name="corporateName" class="input">
        </div>
 
        <div class="d-flex gap-2">
            <div class="my-2 w-100">
                <label class="info-label">Date Drill</label>
                <input type="text" id="noOfStory" name="noOfStory"  class="form-control input-lg" required>
            </div>

            <div class="my-2 w-100">
                <label class="info-label">Issued on</label>
                <input type="text" id="height" name="height" class="form-control input-lg" required>
            </div>
        </div>

        <div class="d-flex gap-2">
            <div class="my-2 w-100">
                <label class="info-label">Validity</label>
                <input type="text" id="buildingPermitNo" name="buildingPermitNo" class="form-control input-lg" required>
            </div>

            <div class="my-2 w-100">
                <label class="info-label">Amount</label>
                <input type="text" id="fireInsuranceCo" name="fireInsuranceCo" class="form-control input-lg" required>
            </div>
        </div>

        <div class="d-flex gap-2">
            <div class="my-2 w-100">
                <label class="info-label">OR Number</label>
                <input type="text" id="latestPermit" name="latestPermit" class="form-control input-lg" required>
            </div>

            <div class="my-2 w-100">
                <label class="info-label">Date Paid</label>
                <input type="text" id="barangay" name="barangay" class="form-control input-lg" required>
            </div>
        </div>

        <div class="my-2">
            <label class="info-label">Type</label>
            <input type="text" id="address" name="address" class="form-control input-lg" required>
        </div>
        <div class="my-2">
            <label class="info-label">Claimed By</label>
            <input type="text" id="address" name="address" class="form-control input-lg" required>
        </div>
        <div class="my-2">
            <label class="info-label">Date</label>
            <input type="text" id="address" name="address" class="form-control input-lg" required>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <input class="btn btn-success" type="submit" value="Save"/>
        </div>
        
    </div>
</div>
@endsection