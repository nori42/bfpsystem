{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        <x-pageWrapper>
            <div class="d-flex justify-content-between my-5 align-items-center">
                <div>
                    <span class="d-block fw-bold fs-3">3 Personnel</span>
                    <span class="d-block text-secondary ">Manage personnel</span>
                </div>
                <button class="btn btn-success" onclick="openModal('addPersonnel')">Add Personnel</button>
            </div>
            {{-- Put page content here --}}
            <x-personnel.cardList>
                <x-personnel.card />
                <x-personnel.card />
                <x-personnel.card />
            </x-personnel.cardList>
        </x-pageWrapper>

        <x-modal id="addPersonnel" width="50" topLocation="8">

            <div class="d-flex gap-3">
                <x-form.input label="First Name" name="firstName" />
                <x-form.input label="Middle Name" name="middleName" />
                <x-form.input label="Last Name" name="lastName" />
            </div>

            <x-form.input label="Position" name="position" />
            <x-form.input label="Contact No." name="contactNo" />

            <button class="btn btn-success w-25 ml-auto mt-3" onclick="openModal('addPersonnel')">Add</button>
        </x-modal>
    </div>
@endsection
