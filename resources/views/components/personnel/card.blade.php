@props(['personnel'])

<div class="card border-0 px-4 py-2 boxshadow" style="background-color: #F5F8FC; width: 14rem;">
    <div class="card-img-top text-center">
        <span class="material-symbols-outlined border border-dark border-1 rounded-circle p-4 mt-4 bg-white"
            style="font-size: 3.5rem">
            person
        </span>
    </div>
    @php
        $name = $personnel->person->first_name . ' ' . $personnel->person->middle_name[0] . '. ' . $personnel->person->last_name;
    @endphp
    <div class="card-body">
        <h5 class="card-title text-center fw-bold fs-6">{{ $name }}</h5>
        <h6 class="card-text text-center text-secondary">{{ $personnel->rank }}</h6>
        <div class="mt-3">
        </div>

        <button class="btn btn-success border-0 w-100 fw-bold mt-4" onclick="openModal('')">Info</button>

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