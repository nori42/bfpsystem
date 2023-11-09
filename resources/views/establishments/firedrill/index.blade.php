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
            <div class="mb-3 d-flex justify-content-between align-items-center bg-subtleBlue boxshadow p-4">
                <div>
                    <div class="fw-bold fs-5">Establishment: {{ $establishment->establishment_name }}</div>

                    <div class="fs-5 "> Owner:
                        {{ $establishment->getOwnerName() }}
                    </div>
                </div>
                <x-headingInfo :establishment="$establishment" :owner="$owner" :representative="$representative" />

            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <div class="fs-4 fw-semibold">Firedrill Certificates</div>
                    <div class="fs-6 text-secondary">List of issued firedrill certifcate for this establishment</div>
                </div>
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
                <div class="fs-5 d-flex justify-content-center align-content-center mt-5">
                    <div class="border border-3 border-gray-500 rounded-3 px-5 py-3 text-secondary">
                        <h2 class="text-center text-secondary fw-bold fs-4">No Firedrill</h2>
                        <div class="text-center text-secondary fw-normal">List of issued firedrill certificate will be shown
                            here.
                        </div>
                    </div>
                </div>
            @endif

            <x-form.firedrillAdd :establishment="$establishment" />
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @yield('component-scripts')
@endsection
