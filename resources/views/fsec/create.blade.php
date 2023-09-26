@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        <x-pageWrapper>
            <h1 class="my-3">New Building Plan Application</h1>
            <form class="p-4 form-wrapper" action="/fsec" method="POST" autocomplete="off">
                @csrf
                <fieldset class="my-3">
                    <legend>Permit Applicant</legend>
                    <hr>
                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="Last Name" name="lastName" />
                        <x-form.input type="text" label="First Name" name="firstName" />
                        <x-form.input type="text" label="Middle Name" name="middleName" />
                        <x-form.input type="text" label="Name Suffix" name="nameSuffix" class="w-50" />
                    </div>
                    <x-form.input class="w-50" type="text" label="Corporate Name" name="corporateName" />
                </fieldset>

                <fieldset>
                    <legend>Permit</legend>
                    <hr>
                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="Building Permit Application No. (BP APP#)"
                            name="bpApplicationNo" />
                        <x-form.input type="text" label="Bill Of Materials (BOQ)" name="billOfMaterials" />
                        <x-form.input type="date" label="Date Received" name="dateReceived" />
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Building</legend>
                    <hr>
                    <x-form.input type="text" label="Project Title" name="projectTitle" />
                    <x-form.input type="text" label="Name of Building/Structure/Facility" name="buildingName" />
                    <x-form.inputWrapper>
                        <div class="d-flex gap-2 align-items-center">
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
                                <select class="form-select" name="subType" id="subType" data-establishment-input required>
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

                <fieldset>
                    <legend>Receipt Information</legend>
                    <hr>
                    <div class="d-flex gap-2">
                        <x-form.input type="text" label="OR No." name="orNo" />
                        <x-form.input type="text" label="Amount Paid" name="amountPaid" />
                        <x-form.input type="date" label="Date of Payment" name="dateOfPayment" />
                    </div>
                </fieldset>

                <div class="d-flex justify-content-between mt-4">
                    <a href="/fsec" class="btn btn-outline-secondary mt-3 px-3" type="submit">Cancel</a>
                    <button class="btn btn-success mt-3 px-5" type="submit">Save</button>
                </div>
            </form>
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @vite('resources/js/pages/fsec/create.js')
@endsection
