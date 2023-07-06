@props(['personnel'])

<div class="card border-0 px-4 py-2 boxshadow" style="background-color: #F5F8FC; width: 18rem; ">
    {{-- <div class="card-img-top text-center">
        <span class="material-symbols-outlined border border-dark border-1 rounded-circle p-4 mt-4 bg-white"
            style="font-size: 3.5rem">
            person
        </span>
    </div> --}}
    <div class="bg-white rounded-circle p-3">
        <img src="{{ asset('img/Firefighter.svg') }}" alt="fireman" height="150px" width="100%">
    </div>
    @php
        $name = $personnel->first_name . ' ' . $personnel->last_name;
        
    @endphp
    <div class="card-body">
        <h5 class="card-title text-center fw-bold fs-6"
            {{ strlen($name) >= 20 ? 'style="font-size:0.8rem !important;"' : '' }}>{{ $name }}</h5>
        <h6 class="card-text text-center text-secondary">
            {{ $personnel->designation ? $personnel->designation : 'No Designation' }}</h6>
        <div class="mt-3">
        </div>

        <a class="btn btn-success border-0 w-100 fw-bold mt-4" href="/personnel/{{ $personnel->id }}">Info</a>

    </div>
    <x-modal id="info{{ $personnel->id }}" width="50" topLocation="8">

        <h4> Personel Info </h4>
        <hr>
        <div class="d-flex gap-3">
            <x-form.input label="First Name" name="firstName" />
            <x-form.input label="Middle Name" name="middleName" />
            <x-form.input label="Last Name" name="lastName" />
        </div>

        <x-form.input label="Suffix" name="suffix" class="w-50" />


    </x-modal>
</div>
