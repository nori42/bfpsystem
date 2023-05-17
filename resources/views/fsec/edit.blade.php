@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>

            <h1>Edit Building Plan Application</h1>
            <form class="form-wrapper p-5" action="/fsec/{{ $buildingPlan->id }}/update" method="POST">
                @csrf
                {{-- Hidden input --}}
                <input class="d-none" type="text" name="evaluator" id="evaluator"
                    value="{{ auth()->user()->type == 'ADMIN' ? auth()->user()->type : auth()->user()->type->personnel->person->last_name }}">

                <fieldset>
                    <legend>Building</legend>
                    <hr>
                    <x-form.inputWrapper>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="w-100">
                                <label class="info-label">Occupancy</label>
                                <select class="form-select" name="occupancy" id="occupancy" data-establishment-input
                                    required>
                                    <option value="" disabled selected>Select Occupancy</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>
                            <div class="w-100">
                                <label class="info-label">Sub Type</label>
                                <select class="form-select" name="subType" id="subType" data-establishment-input required>
                                    <option value="" disabled selected>Select Occupancy First</option>
                                    {{-- Options is populated in script --}}
                                </select>
                            </div>
                        </div>
                    </x-form.inputWrapper>
                    <div class="d-flex gap-2 w-50">
                        <x-form.input type="text" label="Building Story" name="buildingStory" />
                        <x-form.input type="text" label="Floor Area" name="floorArea" />
                    </div>
                    <x-form.input type="text" label="Bill Of Materials (BOQ)" name="billOfMaterials" />
                    <x-form.input type="text" label="Address" name="address" />
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
                <div class="d-flex justify-content-between">
                    <a href="/fsec/{{ $buildingPlan->id }}" class="btn btn-outline-secondary mt-3 px-3"
                        type="submit">Cancel</a>
                    <button class="btn btn-success mt-3 px-5" type="submit">Update</button>
                </div>
            </form>

        </x-pageWrapper>
    </div>
@endsection
