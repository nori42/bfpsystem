@extends('layouts.layout')


@section('content')
<div class="page-content">
    <form class="add-record-form mt-5" action="/establishments" method="POST">
        {{-- Cross-site request forgeries  --}}
        {{-- Add @csrf every form --}}
        @csrf

        

        <div class="w-75 mx-auto position-absolute" style="bottom: 25;">
            <input class="btn btn-secondary d-block float-start" name="submit" type="submit" value="Submit">
        </div>

        <div class="d-flex w-75 mx-auto">
                
            <fieldset class="mx-4">
                <h2 class="">Owner Information</h2>
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName">

                    <label for="middleName">Middle Name:</label>
                    <input type="text" id="middleName" name="middleName">

                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName">

                    <label for="contactNo">Contact No.:</label>
                    <input type="text" id="contactNo" name="contactNo">
            </fieldset>

            <fieldset class="mx-4">
                <h2 class="mx-4">Building Information</h2>
                <div class="d-flex">
                    <div class="mx-4">
                        <label for="establishmentName">Establishment Name:</label>
                        <input type="text" id="establishmentName" name="establishmentName">

                        <label for="corporateName">Corporate Name:</label>
                        <input type="text" id="corporateName" name="corporateName">

                        <label for="buildingType">Building Type:</label>
                        <input type="text" id="buildingType" name="buildingType">

                        <label for="subType">SubType:</label>
                        <input type="text" id="subType" name="subType">
 
                        <label for="substation">Substation:</label>
                        <input type="text" id="substation" name="substation">
                    </div>

                    <div class="mx-4">
                        <label for="height">Height:</label>
                        <input type="text" id="height" name="height">

                        <label for="noOfStory">No. Of Story:</label>
                        <input type="text" id="noOfStory" name="noOfStory">

                        <label for="buildingPermitNo">Building Permit No.:</label>
                        <input type="text" id="buildingPermitNo" name="buildingPermitNo">

                        <label for="fireInsuranceCo">Name of Fire Insurance Co/Co-Insurer:</label>
                        <input type="text" id="fireInsuranceCo" name="fireInsuranceCo">

                        <label for="latestPermit">Latest Mayor's/Business Permit:</label>
                        <input type="text" id="latestPermit" name="latestPermit">

                        <label for="barangay">Barangay:</label>
                        <input type="text" id="barangay" name="barangay">

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address">

                        <label for="status">Status:</label>
                        <input type="text" id="status" name="status">
                    </div>

                </div>
            </fieldset>
        </div>
    </form>
</div>
@endsection