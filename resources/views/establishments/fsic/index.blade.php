@extends('layouts.app')

@section('stylesheet')
    @vite(['resources/css/components/headingInfo.css', 'resources/css/pages/inspections.css'])
@endsection

@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        <div>

            {{-- <x-backBtn /> --}}
            <div id="top"></div>
            @isset($toastMssg)
                <x-toast :message="$toastMssg" />
            @endisset
            @if (session('toastMssg'))
                <x-toast :message="session('toastMssg')" />
            @endif
            <x-pageWrapper>
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fw-bold fs-5 align-middle">Establishment: {{ $establishment->establishment_name }}</div>
                        @if ($establishment->inspection_is_expired)
                            <x-tag bgColor="bg-danger" text="Expired Inspection" />
                        @endif
                    </div>
                    <div class="fs-5 mb-0"> Owner:
                        {{ $establishment->getOwnerName() }}
                    </div>
                </div>
                {{-- Owner Info & Selected Establishment --}}
                <x-headingInfo :establishment="$establishment" :owner="$owner" :representative="$representative" />
                {{-- FSIC Action --}}
                {{-- <div class="d-flex mt-3 w-100 border-bottom border-primary border-2">
                    <a class="btn btn-primary rounded-0 fs-5 px-5"
                        href="/establishments/{{ $establishment->id }}/fsic">Inspections</a>
                    <a class="btn btn-outline-primary rounded-0 fs-5 px-5"
                        href="/establishments/{{ $establishment->id }}/fsic/attachment">Attachments</a>
                </div> --}}

                {{-- Inspection --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <div class="fs-4 fw-semibold">Inspection Certificates</div>
                        <div class="fs-6 text-secondary">List of issued inspection certifcate for this establishment</div>
                    </div>
                    <button class="btn btn-primary mt-3 px-4" data-bs-toggle="modal" data-bs-target="#addInspectionModal">
                        <span class="material-symbols-outlined align-middle">
                            assignment_add
                        </span>
                        Issue Certificate
                    </button>
                </div>
                @if ($inspections->count() != 0)
                    <table class="table table-striped mt-2">
                        <thead class="sticky-top top bg-white z-0">
                            <th>Inspection Date</th>
                            <th>Issued Date</th>
                            <th>FSIC No.</th>
                            <th>Registration Status</th>
                            <th>Expiry Date</th>
                            {{-- <th>Status</th> --}}
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($inspections as $inspection)
                                <tr
                                    class="align-middle {{ ($loop->index == 0 && isset($isAdd)) || (isset($isUpdate) && $inspection->id == $inpsectUpdatedId) ? 'record-highlight' : '' }}">
                                    <td>{{ date('m/d/Y', strtotime($inspection->inspection_date)) }}</td>
                                    @php

                                    @endphp
                                    <td>{{ $inspection->issued_on != null ? date('m/d/Y', strtotime($inspection->issued_on)) : '' }}
                                    </td>
                                    <td>{{ $inspection->fsic_no }}</td>
                                    <td>{{ $inspection->registration_status }}</td>
                                    <td>{{ $inspection->expiry_date ? date('m/d/Y', strtotime($inspection->expiry_date)) : '' }}
                                    </td>
                                    {{-- <td class="{{ $inspection->status == 'Printed' ? 'text-success' : 'text-danger' }}">
                                        {{ $inspection->status }}</td> --}}
                                    <td>
                                        <button class="btn fw-bold btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#inspection{{ $inspection->id }}" {{-- onclick="openModal(`inspection{{ $inspection->id }}`)" --}}
                                            value={{ $inspection->id }}>
                                            <i class="bi bi-card-text"></i>
                                            Details
                                        </button>
                                        @if ($inspection->status == 'Printed' || $inspection->status == 'Expired')
                                            <a class="btn btn-primary" href={{ '/fsic/print/' . $inspection->id }}>
                                                <i class="bi bi-file-earmark-fill"></i>
                                                View Certificate
                                            </a>
                                        @endif

                                        @if ($inspection->status == 'Expired')
                                            <div class="d-inline text-danger mx-2">Expired</div>
                                        @endif
                                    </td>
                                </tr>
                                {{-- Modal Detail --}}
                                <x-inspectionDetail :inspection="$inspection" key="inspection{{ $inspection->id }}"
                                    :establishment="$establishment" />
                            @endforeach
                        </tbody>
                    </table>

                    @if ($inspections->count() >= 20)
                        <a class="link d-block text-center" href="#top" id="backToTop">Back to top</a>
                    @endif
                @else
                    <h2 class="text-center text-secondary">No Inspection</h2>
                    <div class="text-center text-secondary">List of issued inspections will be shown here.</div>
                @endif
            </x-pageWrapper>

            <!-- Modal -->
            {{-- Inspection --}}
            {{-- <x-modal id="addInspectionModal" width="50" topLocation="2">
            <x-inspectionForm :establishment="$establishment" inputAttr="input-inspect" />
        </x-modal> --}}

            <!-- Modal -->
            <div class="modal fade" id="addInspectionModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" style="min-width:800px;">
                    <div class="modal-content px-5 py-4">
                        <x-inspectionForm :establishment="$establishment" inputAttr="input-inspect" />
                    </div>
                </div>
            </div>

        </div>
    @endsection

    @section('page-script')
        @yield('component-scripts')
        @vite('resources/js/pages/inspections.js')
    @endsection
