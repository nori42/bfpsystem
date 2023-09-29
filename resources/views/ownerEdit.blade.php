{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <h1>Edit Owner</h1>
            <form class="form-wrapper p-5" action="/owner/{{ $owner->id }}/edit" method="POST">
                @csrf
                <legend>Owner</legend>
                <div class="d-flex gap-2">
                    <x-form.input type="text" label="Last Name" name="lastName" :value="$owner->last_name" />
                    <x-form.input type="text" label="First Name" name="firstName" :value="$owner->first_name" />
                    <x-form.input type="text" label="Middle Name" name="middleName" :value="$owner->middle_name" />
                    <x-form.input type="text" label="Name Suffix" name="nameSuffix" class="w-50" :value="$owner->name_suffix" />
                </div>
                <x-form.input type="text" label="Corporate Name" name="corporateName" :value="$owner->corporate_name" />
                <x-form.input class="w-50" type="text" label="Contact No" name="contactNo" :value="$owner->contact_no" />

                <div class="d-flex justify-content-between">
                    <a href="/establishments/{{ $owner->establishment[0]->id }}" class="btn btn-outline-secondary mt-3 px-3"
                        type="submit">Cancel</a>
                    <button class="btn btn-primary mt-3 px-5" type="submit">Save</button>
                </div>
            </form>
        </x-pageWrapper>
    </div>
@endsection
