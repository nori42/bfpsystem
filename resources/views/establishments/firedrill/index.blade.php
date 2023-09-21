@extends('layouts.app')

@section('stylesheet')
    @vite(['resources/css/components/headingInfo.css'])
@endsection

@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        <x-pageWrapper>
            {{-- Firedrill Action --}}
            {{-- Owner Info & Selected Establishment --}}
            @isset($toastMssg)
                <x-toast :message="$toastMssg" />
            @endisset

            <x-headingInfo :establishment="$establishment" :owner="$owner" :representative="$representative" />

            <div class="d-flex mt-3 w-100">
                <x-action.link href="/establishments/{{ $establishment->id }}/firedrill" text="Firedrill" :active="true" />
                <x-action.link href="/establishments/{{ $establishment->id }}/firedrill/attachment" text="Attachments" />
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{-- @if ($establishment->firedrill_is_expired)
                        <x-tag bgColor="bg-danger" text="Expired Firedrill" />
                    @endif --}}
                </div>
                <button class="btn btn-primary mt-3" id="addInspectionBtn" onclick="openModal('addFiredrillModal')">
                    <span class="material-symbols-outlined align-middle">
                        add
                    </span>
                    Add Firedrill
                </button>
            </div>
            @if ($firedrills->count() != 0)
                <x-firedrill>
                    @foreach ($firedrills as $firedrill)
                        @if (($loop->index == 0 && isset($isAdd)) || (isset($isUpdate) && $firedrill->id == $firedrillUpdatedId))
                            <x-firedrill.item :firedrill="$firedrill" :newRecord="true" />
                        @else
                            <x-firedrill.item :firedrill="$firedrill" />
                        @endif
                    @endforeach
                </x-firedrill>
            @else
                <h2 class="text-center text-secondary">No Firedrill</h2>
            @endif

            <x-form.firedrillAdd :establishment="$establishment" />
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @yield('component-scripts')
@endsection
