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
                <a href="" id="" class="btn btn-action rounded-0 fs-5 fsic-active">Fire Drill</a>
                <a href="" id="" class="btn btn-action rounded-0 fs-5">Attachments</a>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-success mt-3" id="addInspectionBtn" onclick="openModal('addInspectionModal')">
                    <span class="material-symbols-outlined align-middle">
                        assignment_add
                    </span>
                    Add Firedrill
                </button>
            </div>

            <div id="inspection" class="h-75 overflow-y-auto mt-4 border-3">
                <table class="table">
                    <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                        <th class="w-25">Control No.</th>
                        <th colspan="2">Fire Drill Quarter</th>
                        <th></th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </x-pageWrapper>
    </div>
@endsection
