{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <h1>Edit Establishment</h1>
            <form class="form-wrapper p-5" action="/establishments/{{ $establishment->id }}/update" method="POST">
                @csrf
                <x-form.input type="text" label="Establishment Name" name="establishmentName" :value="$establishment->establishment_name"
                    :required="true" />
                <x-form.input type="text" label="Business Permit No." name="businessPermitNo" :value="$establishment->business_permit_no" />

                <x-form.inputWrapper>
                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <label class="info-label">Occupancy</label>
                            <select class="form-select" name="occupancy" id="occupancy"
                                select-value="{{ $establishment->occupancy }}" data-establishment-input required>
                                <option value="" disabled selected>Select Occupancy</option>
                                {{-- Options is populated in script --}}
                            </select>
                        </div>
                        <div class="w-100">
                            <label class="info-label">Sub Type</label>
                            <select class="form-select" name="subType" id="subType" data-establishment-input required
                                select-value="{{ $establishment->sub_type }}">
                                {{-- Options is populated in script --}}
                            </select>
                        </div>

                    </div>
                </x-form.inputWrapper>

                <x-form.inputWrapper>
                    <div class="d-flex gap-2">
                        <div class="w-100">
                            <label class="info-label">Substation</label>
                            <select class="form-select" name="substation" id="substation" data-establishment-input required
                                select-value="{{ $establishment->substation }}">
                                <option value="" disabled selected>Select Substation</option>
                                {{-- Options is populated in script --}}
                            </select>
                        </div>

                        <div class="w-100">
                            <label class="info-label">Building Structure</label>
                            <select class="form-select" name="buildingType" id="buildingType" data-establishment-input
                                required select-value="{{ $establishment->building_type }}">
                                <option value="" disabled selected>Select Building Type</option>
                                {{-- Options is populated in script --}}
                            </select>
                        </div>
                    </div>
                </x-form.inputWrapper>

                <div class="d-flex gap-2">
                    <x-form.input type="text" label="No. of Story" name="noOfStory" :value="$establishment->no_of_storey" />
                    <x-form.input type="text" label="Height" name="height" :value="$establishment->height" />
                    <x-form.input type="text" label="Floor Area" name="floorArea" :value="$establishment->floor_area" />
                </div>
                <div class="d-flex gap-2">
                    <x-form.input type="text" label="Name of Fire Insurance Co/Co-Insurer" name="fireInsuranceCo"
                        :value="$establishment->fire_insurance_co" />
                    <x-form.input type="text" label="Latest Mayor's/Business Permit" name="latestPermit"
                        :value="$establishment->latest_mayors_permit" />
                </div>

                <x-form.inputWrapper>
                    <label class="info-label">Barangay</label>
                    <select class="form-select" name="barangay" id="barangay"
                        select-value="{{ $establishment->barangay }}">
                        <option value="" disabled selected>Select Barangay</option>
                    </select>
                </x-form.inputWrapper>
                <x-form.input type="text" label="Address" name="address" :required="true" :value="$establishment->address" />

                <div class="d-flex justify-content-between">
                    <a href="/establishments/{{ $establishment->id }}" class="btn btn-outline-secondary mt-3 px-3"
                        type="submit">Cancel</a>
                    <button class="btn btn-primary mt-3 px-5" type="submit">Save</button>
                </div>
            </form>
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @vite('resources/js/pages/establishmentsedit.js')
@endsection
