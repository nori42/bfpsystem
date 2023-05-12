@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        <x-pageWrapper>
            <form class="p-4 form-wrapper" action="">
                <fieldset class="my-3">
                    <legend>Permit Applicant</legend>
                    <hr>
                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="Last Name" name="lastName" />
                        <x-form.input type="text" label="First Name" name="firstName" />
                        <x-form.input type="text" label="Middle Name" name="middleName" />
                    </div>
                    <legend>OR</legend>
                    <x-form.input type="text" label="Company" name="company" />
                </fieldset>

                <fieldset>
                    <legend>Building</legend>
                    <hr>
                    {{-- <x-form.input type="text" label="Name of building/structure/facility" name="buildingName" /> --}}
                    <label class="info-label">
                        Name of building/structure/facility
                    </label>
                    <textarea class="form-control" name="nameOfBuilding" id="nameOfBuilding" value="" cols="30" rows="10">

                    </textarea>
                    <x-form.inputWrapper>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="w-100">
                                <label class="info-label">Occupancy</label>
                                <select class="form-control" name="occupancy" id="occupancy" data-establishment-input
                                    required>
                                    <option value="" disabled selected>Select Occupancy</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>
                            <div class="w-100">
                                <label class="info-label">Sub Type</label>
                                <select class="form-control" name="subType" id="subType" data-establishment-input
                                    required>
                                    <option value="" disabled selected>Select Occupancy First</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>
                            <x-form.input type="text" label="Building Story" name="noOfStory" />
                        </div>
                    </x-form.inputWrapper>

                    <x-form.input type="text" label="Address" name="address" />
                </fieldset>
                <fieldset>
                    <legend>Permit</legend>
                    <hr>
                    <x-form.input class="w-50" type="date" label="Date Received" name="dateReceived" />
                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="Series No." name="seriesNo" />
                        <x-form.input type="text" label="Building Permit Application No. (BP APP#)" name="seriesNo" />
                    </div>

                    <div class="d-flex gap-2">

                        <x-form.input type="text" label="Remarks" name="remarks" />
                        <x-form.input type="text" label="Bill Of Materials (BOQ)" name="billOfMaterials" />
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Certificate</legend>
                    <hr>
                    <x-form.input type="text" label="FSEC No." name="fsecNo" />
                    <x-form.input class="w-50" type="date" label="Date Released" name="dateRelease" />
                    <x-form.input class="w-50" type="date" label="Date Printed" name="datePrinted" />
                </fieldset>

                <fieldset>
                    <legend>Receipt Information</legend>
                    <hr>
                    <x-form.input type="text" label="OR No." name="orNo" />
                    <div class="d-flex gap-2">
                        <x-form.input type="date" label="Date Paid" name="datePaid" />
                        <x-form.input type="text" label="Amount Paid" name="amountPaid" />
                    </div>
                </fieldset>
            </form>
        </x-pageWrapper>
    </div>
@endsection
