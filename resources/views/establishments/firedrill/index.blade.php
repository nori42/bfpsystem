@extends('layouts.app')

@section('stylesheet')
    @vite(['resources/css/components/headingInfo.css', 'resources/css/pages/firedrill.css'])
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
            @if (session('toastMssg'))
                <x-toast :message="session('toastMssg')" />
            @endif
            <div class=" mb-3">
                <div class="fw-bold fs-5">Establishment: {{ $establishment->establishment_name }}</div>

                <div class="fs-5 "> Owner:
                    {{ $establishment->getOwnerName() }}
                </div>
            </div>
            <x-headingInfo :establishment="$establishment" :owner="$owner" :representative="$representative" />

            <div class="d-flex mt-3 w-100 border-bottom border-primary border-2">
                {{-- <x-action.link href="/establishments/{{ $establishment->id }}/firedrill" text="Firedrill" :active="true" />
                <x-action.link href="/establishments/{{ $establishment->id }}/firedrill/attachment" text="Attachments" /> --}}
                <a class="btn btn-primary rounded-0 fs-5 px-5"
                    href="/establishments/{{ $establishment->id }}/firedrill">Firedrill</a>
                <a class="btn btn-outline-primary rounded-0 fs-5 px-5"
                    href="/establishments/{{ $establishment->id }}/firedrill/attachment">Attachments</a>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <button class="btn btn-primary mt-3" id="addInspectionBtn" data-bs-toggle="modal"
                    data-bs-target="#addFiredrillModal">
                    <span class="material-symbols-outlined align-middle">
                        assignment_add
                    </span>
                    Issue Firedrill
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
                <div class="text-center text-secondary">List of issued firedrill certificate will be shown here.</div>
            @endif

            <x-form.firedrillAdd :establishment="$establishment" />
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @yield('component-scripts')
@endsection
