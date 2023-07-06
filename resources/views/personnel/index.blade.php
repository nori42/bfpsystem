{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    @php
        $personnelCINSP = $personnelList->where('rank', '=', 'CINSP');
        $personnelINSP = $personnelList->where('rank', '=', 'INSP');
        $personnelSFO4 = $personnelList->where('rank', '=', 'SFO4');
        $personnelSFO3 = $personnelList->where('rank', '=', 'SFO3');
        $personnelSFO2 = $personnelList->where('rank', '=', 'SFO2');
        $personnelSFO1 = $personnelList->where('rank', '=', 'SFO1');
        $personnelFO3 = $personnelList->where('rank', '=', 'FO3');
        $personnelFO2 = $personnelList->where('rank', '=', 'FO2');
        $personnelFO1 = $personnelList->where('rank', '=', 'FO1');
        
        $personnels = [$personnelCINSP, $personnelINSP, $personnelSFO4, $personnelSFO3, $personnelSFO2, $personnelSFO1, $personnelFO3, $personnelFO2, $personnelFO1];
    @endphp

    <div class="page-content">
        <x-pageWrapper>
            @if (session('toastMssg') != null)
                <x-toast :message="session('toastMssg')" />
            @endif

            <div class="d-flex justify-content-between my-5 align-items-center">
                <div>
                    <span class="d-block fw-bold fs-3">{{ count($personnelList) }} Personnel</span>
                    <span class="d-block text-secondary ">Manage personnel</span>
                </div>
                <button class="btn btn-success" onclick="openModal('addPersonnel')">
                    <span class="material-symbols-outlined fs-2 align-middle">
                        person_add
                    </span>
                    Add Personnel
                </button>
            </div>
            {{-- Put page content here --}}
            <div class="d-flex gap-5">
                {{-- <div>
                    <div class="card border-0 px-4 py-2 boxshadow"
                        style="background-color: #F5F8FC; width: 14rem; min-height: 12rem;">
                        <div class="d-flex align-items-center justify-content-center btn" style="height:16rem;">
                            <i class="bi bi-person-plus-fill" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    <div class="text-center fw-semibold mt-3">CHIEF, Fire Safety Enforcement Section</div>
                </div>

                <div>
                    <div class="card border-0 px-4 py-2 boxshadow"
                        style="background-color: #F5F8FC; width: 14rem; min-height: 12rem;">
                        <div class="d-flex align-items-center justify-content-center btn" style="height:16rem;">
                            <i class="bi bi-person-plus-fill" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    <div class="text-center fw-semibold mt-3">CITY/MUNICIPAL FIRE MARSHALL</div>
                </div> --}}
            </div>

            @foreach ($personnels as $personnelType)
                @if (count($personnelType) == 0)
                    @continue
                @endif
                @php
                    $label = $personnelType->first()->rank;
                @endphp
                <x-personnel.cardList label="{{ $label }}">
                    @foreach ($personnelType as $personnel)
                        <x-personnel.card :personnel="$personnel" />
                    @endforeach
                </x-personnel.cardList>
            @endforeach

        </x-pageWrapper>

        <x-modal id="addPersonnel" width="50" topLocation="8">

            <form action="/personnel" method="POST">
                @csrf
                <fieldset>
                    <legend>Personal Info</legend>
                    <hr>
                    <div class="d-flex gap-3">
                        <x-form.input label="First Name" name="firstName" required />
                        <x-form.input label="Middle Name" name="middleName" />
                        <x-form.input label="Last Name" name="lastName" required />
                    </div>
                    <div class="d-flex gap-2">
                        {{-- <x-form.input type="text" label="Title" name="title" /> --}}
                        <x-form.input type="text" label="Name Suffix" name="nameSuffix" class="w-25" />
                    </div>
                    <x-form.select class="w-25" name="sex" label="Sex" placeholder="SELECT SEX" required>
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                    </x-form.select>
                    <x-form.input class="w-25" label="Date of Birth" name="dateOfBirth" type="date" />
                    <x-form.input class="w-50" label="Contact No." name="contactNo" />
                    <x-form.input label="Address" name="address" />
                </fieldset>
                <fieldset>
                    <hr>
                    <x-form.select class="w-25" name="rank" label="Rank" placeholder="SELECT RANK">
                        <option value="CINSP">CINSP</option>
                        <option value="INSP">INSP</option>
                        <option value="SFO4">SFO4</option>
                        <option value="SFO3">SFO3</option>
                        <option value="SFO2">SFO2</option>
                        <option value="SFO1">SFO1</option>
                        <option value="FO3">FO3</option>
                        <option value="FO2">FO2</option>
                        <option value="FO1">FO1</option>
                        <option value="NUP">NUP</option>
                    </x-form.select>
                    <x-form.input label="Designation" name="designation" />
                </fieldset>

                <button class="btn btn-success w-25 float-end mt-3" onclick="openModal('addPersonnel')" type="submit">
                    <span class="material-symbols-outlined fs-2 align-middle">
                        person_add
                    </span>
                    Add
                </button>
            </form>
        </x-modal>
    </div>
@endsection
