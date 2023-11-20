@extends('layouts.app')

@section('stylesheet')
    @vite('resources/css/pages/fsec/create.css')
@endsection
{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        <x-pageWrapper>
            <div>
                <h1>New Building Plan Application</h1>
                <div class="text-secondary fs-5">Complete the 2 steps to add new application</div>
            </div>
            <form class="form-wrapper boxshadow" action="/fsec" method="POST" autocomplete="off">
                <div class="d-flex justify-content-evenly mx-auto steps-title mt-3" id="steps-title">
                    <div class="step current-step text-center flex-grow-1 py-3" step="1">
                        <i class="bi bi-circle fs-4 align-middle" step-icon="1"></i>
                        <span id="ownerTitle" class="fw-bold align-middle">Applicant</span>
                    </div>
                    <div class="step text-center flex-grow-1 py-3" step="2">
                        <i class="bi bi-circle fs-4 align-middle" step-icon="2"></i>
                        <span id="establishmentTitle" class="fw-bold">Application</span>
                    </div>
                </div>
                @csrf
                <div class="py-3 px-5">
                    <div id="ownerDetails">
                        <div class="header">
                            <h4 id="validateMssgOwner" class="text-danger d-none">Fill in the name or corporate field</h4>
                            <h2>Applicant Information</h2>
                            <hr />
                        </div>
                        <fieldset class="my-3">
                            <div class="d-flex gap-2">
                                <x-form.input type="text" label="Last Name" name="lastName" />
                                <x-form.input type="text" label="First Name" name="firstName" />
                                <x-form.input type="text" label="Middle Name" name="middleName" />
                                <x-form.input type="text" label="Name Suffix" name="nameSuffix" class="w-50" />
                            </div>
                            <x-form.input type="text" label="Corporate Name" name="corporateName" />
                            <x-form.input type="text" label="Contact No." name="contactNoOwner" class="w-50"
                                customAttr="maxlength=11" />
                        </fieldset>
                    </div>
                    <div id="applicantDetails" class="d-none">
                        <div class="header">
                            <h2>Application Information</h2>
                        </div>
                        <hr>
                        {{-- <x-form.input type="text" label="Series-No" name="seriesNo" class="w-50" />e --}}
                        <fieldset>
                            <div class="d-flex gap-2">
                                <x-form.input type="text" label="Building Permit Application No. (BP APP#)"
                                    name="bpApplicationNo" />
                                <x-form.input type="text" label="Bill Of Materials (BOQ)" name="billOfMaterials" />
                                <x-form.input type="date" label="Date Received" name="dateReceived" />
                            </div>
                        </fieldset>
                        <fieldset>
                            <x-form.input type="text" label="Project Title" name="projectTitle" />
                            <x-form.input type="text" label="Name of Building/Structure/Facility" name="buildingName" />
                            <x-form.inputWrapper>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="w-100">
                                        <label class="info-label">Occupancy <span class="text-danger">*</span></label>
                                        <select class="form-select" name="occupancy" id="occupancy" data-establishment-input
                                            required>
                                            <option value="" disabled selected>--Select Occupancy--</option>
                                            {{-- Options is populated in script --}}
                                        </select>
                                    </div>
                                    <div class="w-100">
                                        <label class="info-label">Sub Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="subType" id="subType" data-establishment-input
                                            required>
                                            <option value="" disabled selected>--Select Occupancy First--</option>
                                            <x-options.subtype />
                                            {{-- Options is populated in script --}}
                                        </select>
                                    </div>
                                </div>
                            </x-form.inputWrapper>
                            <div class="d-flex gap-2 w-50">
                                <x-form.input type="text" label="Building Story" name="buildingStory" />
                                <x-form.input type="text" label="Floor Area(sq m)" name="floorArea" />
                            </div>
                            <x-form.input type="text" label="Address" name="address" customAttr="maxlength=52" />
                        </fieldset>
                        <legend>Receipt Information</legend>
                        <hr>
                        <div class="d-flex gap-2">
                            <x-form.input type="text" label="OR No." name="orNo" />
                            <x-form.input type="text" label="Amount Paid" name="amountPaid" />
                            <x-form.input type="date" label="Date of Payment" name="dateOfPayment" />
                        </div>
                        </fieldset>
                    </div>

                    <div class="form-footer mx-auto mt-3 py-3 px-5 rounded-2 d-flex justify-content-between"
                        id="btnsForm">
                        <input type="button" value="Cancel" id="cancelBtn" class="btn btn-outline-primary font-bold">

                        {{-- hidden in first step --}}
                        <input type="button" value="Back" id="backBtn"
                            class="btn btn-outline-primary font-bold d-none">

                        {{-- hidden in second step --}}
                        <input type="button" value="Next" id="nextBtn" class="btn btn-primary font-bold px-5">

                        {{-- hidden in first step --}}
                        <input type="submit" value="Save" id="saveBtn"
                            class="btn btn-primary font-bold px-5 d-none">
                    </div>
                    <div class="d-none py-5" id="loadingMssg">
                        <div class="d-flex justify-content-center">
                            <x-spinner2 :hidden="false" />
                        </div>
                        <h4 class="text-secondary text-center mt-2">Registering Application...</h4>
                    </div>
                </div>
            </form>
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @vite('resources/js/pages/fsec/create.js')
@endsection
