@extends('layouts.app')

@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-backBtn />

        <x-pageWrapper>
            {{-- FSIC Action --}}
            {{-- Owner Info & Selected Establishment --}}
            <x-headingInfo :establishment="$establishment" :owner="$owner" />

            <div class="d-flex mt-3 w-100">
                <x-action.link href="/establishments/firedrill/{{ $establishment->id }}" text="Firedrill" :active="true" />
                <x-action.link href="/establishments/firedrill/attachment/{{ $establishment->id }}/firedrill"
                    text="Attachments" />
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-success mt-3" id="addInspectionBtn" onclick="openModal('addFiredrillModal')">
                    <span class="material-symbols-outlined align-middle">
                        add
                    </span>
                    Add Firedrill
                </button>
            </div>
            <x-firedrill>
                @foreach ($firedrills as $firedrill)
                    <x-firedrill.item :firedrill="$firedrill" />
                @endforeach
            </x-firedrill>

            <x-form.firedrillAdd :controlNo="$controlNo" :establishment="$establishment" />
        </x-pageWrapper>
    </div>
@endsection
