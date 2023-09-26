@extends('layouts.app')

@section('stylesheet')
    @vite(['resources/css/components/headingInfo.css', 'resources/css/pages/inspections.css'])
@endsection

@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        {{-- <x-backBtn /> --}}
        <div id="top"></div>
        @isset($toastMssg)
            <x-toast :message="$toastMssg" />
        @endisset
        <x-pageWrapper>

            {{-- Owner Info & Selected Establishment --}}
            <x-headingInfo :establishment="$establishment" :owner="$owner" :representative="$representative" />
            {{-- FSIC Action --}}
            <div class="d-flex mt-3 w-100 border-bottom border-primary border-2">
                {{-- <x-action.link href="/establishments/{{ $establishment->id }}/fsic" text="Inspection" :active="true" /> --}}
                {{-- <x-action.link href="/establishments/fsic/attachment/{{ $establishment->id }}/fsic" text="Attachments" /> --}}
                <a class="btn btn-primary rounded-0 fs-5 px-5"
                    href="/establishments/{{ $establishment->id }}/fsic">Inspections</a>
                <a class="btn btn-outline-primary rounded-0 fs-5 px-5"
                    href="/establishments/{{ $establishment->id }}/fsic/attachment">Attachments</a>
            </div>

            {{-- Inspection --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if ($establishment->inspection_is_expired)
                        <x-tag bgColor="bg-danger" text="Expired Inspection" />
                    @endif
                </div>
                <button class="btn btn-primary mt-3 px-4" data-bs-toggle="modal" data-bs-target="#addInspectionModal">
                    <span class="material-symbols-outlined align-middle">
                        assignment_add
                    </span>
                    Add Inspection
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
                        <th>Status</th>
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
                                <td class="{{ $inspection->status == 'Printed' ? 'text-success' : 'text-danger' }}">
                                    {{ $inspection->status }}</td>
                                <td>
                                    <button class="btn fw-bold btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#inspection{{ $inspection->id }}" {{-- onclick="openModal(`inspection{{ $inspection->id }}`)" --}}
                                        value={{ $inspection->id }}>
                                        <i class="bi bi-card-text"></i>
                                        Details
                                    </button>
                                    @if ($inspection->status == 'Printed')
                                        <a class="btn btn-primary" href={{ '/fsic/print/' . $inspection->id }}>
                                            <i class="bi bi-file-earmark-fill"></i>
                                            View Print
                                        </a>
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
