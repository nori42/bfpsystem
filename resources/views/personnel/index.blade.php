{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        <x-pageWrapper>

            @isset($toastMssg)
                <x-toast :message="$toastMssg" />
            @endisset
            <div class="d-flex justify-content-between my-5 align-items-center">
                <div>
                    <span class="d-block fw-bold fs-3">{{ count($personnelList) }} Personnel</span>
                    <span class="d-block text-secondary ">Manage personnel</span>
                </div>
                <button class="btn btn-success" onclick="openModal('addPersonnel')">Add Personnel</button>
            </div>
            {{-- Put page content here --}}

            <x-personnel.cardList>
                @foreach ($personnelList as $personnel)
                    <x-personnel.card :personnel="$personnel" />
                @endforeach
            </x-personnel.cardList>
        </x-pageWrapper>

        <x-modal id="addPersonnel" width="50" topLocation="8">

            <form action="/personnel" method="POST">
                @csrf
                <div class="d-flex gap-3">
                    <x-form.input label="First Name" name="firstName" />
                    <x-form.input label="Middle Name" name="middleName" />
                    <x-form.input label="Last Name" name="lastName" />
                </div>
                <x-form.input class="w-25" label="Suffix" name="suffix" />
                <x-form.input label="Position" name="position" />

                <button class="btn btn-success w-25 ml-auto mt-3" onclick="openModal('addPersonnel')"
                    type="submit">Add</button>
            </form>
        </x-modal>
    </div>
@endsection
