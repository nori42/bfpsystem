{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <h1>Edit Personnel</h1>
            <form class="form-wrapper p-5" action="update" method="POST">
                @method('PUT')
                @csrf
                <div class="d-flex gap-2">
                    <x-form.input type="text" label="First Name" name="firstName" :value="$personnel->first_name" />
                    <x-form.input type="text" label="Middle Name" name="middleName" :value="$personnel->middle_name" />
                    <x-form.input type="text" label="Last Name" name="lastName" :value="$personnel->last_name" />
                </div>
                <x-form.input class="w-25" type="text" label="Name Suffix" name="nameSuffix" :value="$personnel->name_suffix" />

                <div class="my-3">
                    <div class="my-2 fw-bold">Sex</div>
                    <span style="margin-right: 1rem;">
                        <label for="male">MALE</label>
                        <input class="ml-5" type="radio" name="sex" id="male" value="MALE"
                            {{ $personnel->sex == 'MALE' ? 'checked' : '' }}>
                    </span>
                    <label for="female">FEMALE</label>
                    <input type="radio" name="sex" id="female" value="FEMALE"
                        {{ $personnel->sex == 'FEMALE' ? 'checked' : '' }}>
                </div>

                <x-form.input class="w-25" type="date" label="Date of Birth" name="dateOfBirth" :value="$personnel->date_of_birth" />
                <x-form.input class="w-25" type="text" label="Contact No." name="contactNo" :value="$personnel->contact_no" />
                <x-form.input type="text" label="Address" name="address" :value="$personnel->address" />
                <x-form.select class="w-25" name="rank" label="Rank" placeholder="SELECT RANK">
                    @php
                        $ranks = ['CINSP', 'INSP', 'SFO4', 'SFO3', 'SFO1', 'FO3', 'FO2', 'FO1', 'NUP'];
                    @endphp

                    @foreach ($ranks as $rank)
                        <option value="{{ $rank }}" {{ $rank == $personnel->rank ? 'selected' : '' }}>
                            {{ $rank }}</option>
                    @endforeach
                </x-form.select>

                {{-- <x-form.input type="text" label="Designation" name="designation" :value="$personnel->designation" /> --}}

                <div class="d-flex justify-content-between mt-4 align-items-center">
                    <a class="btn btn-outline-secondary" href="/users/{{ $personnel->user->id }}">Cancel</a>
                    <button class="btn btn-success mt-4 px-5">Update</button>
                </div>
            </form>
        </x-pageWrapper>
    </div>
@endsection
