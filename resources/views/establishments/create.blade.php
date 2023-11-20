@extends('layouts.app')

@section('stylesheet')
    @vite('resources/css/pages/establishmentcreate.css')
@endsection

@section('content')
    <div class="page-content">
        <x-pageWrapper>
            <div class="mx-auto">
                <h1>New Establishment</h1>
                <div class="text-secondary fs-5">Complete the 2 steps to add new establishment</div>
            </div>

            <form class="form-wrapper mt-3 boxshadow" action="/establishments" method="POST" autocomplete="off">
                <div class="d-flex justify-content-evenly mx-auto steps-title mt-3" id="steps-title">
                    <div class="step current-step text-center flex-grow-1 py-3" step="1">
                        <i class="bi bi-circle fs-4 align-middle" step-icon="1"></i>
                        <span id="ownerTitle" class="fw-bold align-middle">Owner</span>
                    </div>
                    <div class="step text-center flex-grow-1 py-3" step="2">
                        <i class="bi bi-circle fs-4 align-middle" step-icon="2"></i>
                        <span id="establishmentTitle" class="fw-bold">Establishment</span>
                    </div>
                </div>
                {{-- Cross-site request forgeries  --}}
                {{-- Add @csrf every form --}}
                @csrf

                {{-- Owner Info --}}
                <div class="mx-auto mt-3 py-3 px-5 rounded-2 form-wrapper" id="ownerDetails" data-step="owner">
                    <div class="header">
                        <h4 id="validateMssgOwner" class="text-danger d-none">Fill in the name or corporate field</h4>
                        <h2>Owner Information</h2>
                        <hr />
                    </div>

                    <fieldset>
                        <div class="d-flex gap-2">
                            <x-form.input type="text" label="Last Name" name="lastName" />
                            <x-form.input type="text" label="First Name" name="firstName" />
                            <x-form.input type="text" label="Middle Name" name="middleName" />
                            <x-form.input type="text" label="Name Suffix" name="nameSuffix" class="w-50" />
                        </div>

                    </fieldset>
                    {{-- Corporate --}}
                    <fieldset>
                        <x-form.input type="text" label="Corporate Name" name="corporateName" />
                        <x-form.input type="text" label="Contact No." name="contactNo" class="w-50"
                            customAttr="maxlength=25" />
                    </fieldset>

                    {{-- <x-form.input type="text" label="Contact No." name="contactNoPerson" /> --}}
                </div>

                {{-- Establishment Info --}}
                <div class="mx-auto mt-3 py-3 px-5 rounded-2 form-wrapper d-none" id="establishmentDetails"
                    data-step="establishment">
                    <div class="header">
                        <h2>Establishment Information</h2>
                    </div>
                    <hr>

                    <x-form.input type="text" label="Establishment Name" name="establishmentName" :required="true" />
                    <label class="fw-bold fs-6 my-2" for="isCompanyName"><input class="form-check-inline" type="checkbox"
                            name="isCompanyName" id="isCompanyName">Establishment
                        Name is
                        Corporate Name</label>

                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="Business Permit No." name="businessPermitNo" />
                        <x-form.input type="text" label="Building Permit No." name="buildingPermitNo" />
                    </div>

                    <x-form.inputWrapper>
                        <div class="d-flex gap-2">
                            <div class="w-100">
                                <label class="info-label">Occupancy</label>
                                <select class="form-select" name="occupancy" id="occupancy" data-establishment-input
                                    required>
                                    <option value="" disabled selected>--Select Occupancy--</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>
                            <div class="w-100">
                                <label class="info-label">Sub Type</label>
                                <select class="form-select" name="subType" id="subType" data-establishment-input>
                                    <option value="" disabled selected>--Select Occupancy First--</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>

                        </div>
                    </x-form.inputWrapper>

                    <x-form.inputWrapper>
                        <div class="d-flex gap-2">
                            <div class="w-100">
                                <label class="info-label">Substation</label>
                                <select class="form-select" name="substation" id="substation" data-establishment-input>
                                    <option value="" selected>--Select Substation--</option>
                                </select>
                            </div>

                            <div class="w-100">
                                <label class="info-label">Building Structure</label>
                                <select class="form-select" name="buildingType" id="buildingType" data-establishment-input>
                                    <option value="" selected>--Select Building Structure--</option>
                                </select>
                            </div>
                        </div>
                    </x-form.inputWrapper>

                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="Building Story" name="noOfStory" />
                        <x-form.input type="text" label="Floor Area(sq m)" name="floorArea" />
                        <x-form.input type="text" label="Height(m)" name="height" />
                        <div class="w-100">
                            <label class="info-label">Hazard Note</label>
                            <select class="form-select" name="hazardNote" id="hazardNote" data-establishment-input>
                                <option value="" selected>--Select Note--</option>
                                <option value="LOW HAZARD">LOW HAZARD</option>
                                <option value="HIGH HAZARD">HIGH HAZARD</option>
                                <option value="NO HAZARD">NO HAZARD</option>
                            </select>
                        </div>
                        {{-- <x-form.inputWrapper>
                            <label class="info-label">Note</label>
                            <select class="form-control " name="note" id="note">
                                <option value="" selected disabled>--Select Note--</option>
                                <option value="">LOW HARZARD</option>
                                <option value="">HIGH HAZARD</option>
                                <option value="">NO HAZARD</option>
                            </select>
                        </x-form.inputWrapper> --}}
                    </div>

                    <x-form.input type="text" label="Name of Fire Insurance Co/Co-Insurer" name="fireInsuranceCo" />

                    <x-form.inputWrapper>
                        <label class="info-label">Barangay</label>
                        {{-- <input type="text" id="barangay" name="barangay" class="input" data-establishment-input required> --}}
                        <select class="form-control " name="barangay" id="barangay">
                            <option value="" selected>--Select Barangay--</option>
                        </select>
                    </x-form.inputWrapper>

                    <x-form.input type="text" label="Address" name="address" customAttr='maxlength=80'
                        :required="true" />
                </div>

                <div class="form-footer mx-auto mt-3 py-3 px-5 rounded-2 d-flex justify-content-between" id="btnsForm">
                    <input type="button" value="Cancel" id="cancelBtn" class="btn btn-outline-primary font-bold">

                    {{-- hidden in first step --}}
                    <input type="button" value="Back" id="backBtn"
                        class="btn btn-outline-primary font-bold d-none">

                    {{-- hidden in second step --}}
                    <input type="button" value="Next" id="nextBtn" class="btn btn-primary font-bold px-5">

                    {{-- hidden in first step --}}
                    <input type="submit" value="Save" id="saveBtn" class="btn btn-primary font-bold px-5 d-none">
                </div>
                <div class="d-none py-5" id="loadingMssg">
                    <div class="d-flex justify-content-center">
                        <x-spinner2 :hidden="false" />
                    </div>
                    <h4 class="text-secondary text-center mt-2">Registering Establishment...</h4>
                </div>
            </form>
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @vite('resources/js/pages/establishments/create.js')
@endsection
