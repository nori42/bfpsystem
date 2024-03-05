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
                <div class="mb-3 d-flex justify-content-between align-items-center bg-subtleBlue boxshadow p-4">
                    <div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="fw-bold fs-5 align-middle">Establishment: {{ $establishment->establishment_name }}
                            </div>
                            @if ($establishment->inspection_is_expired)
                                <x-tag bgColor="bg-danger" text="Expired Inspection" />
                            @endif
                        </div>
                        <div class="fs-5 mb-0"> Owner:
                            {{ $establishment->getOwnerName() }}
                        </div>
                    </div>
                    <x-headingInfo :establishment="$establishment" :owner="$owner" :representative="$representative" />
                </div>

                {{-- Owner Info & Selected Establishment --}}

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
                    <table id="inspectionTable" class="table table-striped mt-2">
                        <thead class="sticky-top top bg-white z-0">
                            <th>Inspection Date</th>
                            <th>Issued Date</th>
                            <th>FSIC No.</th>
                            <th>Registration Status</th>
                            <th>Expiry Date</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($inspections as $inspection)
                                <tr
                                    class="align-middle bg-danger {{ ($loop->index == 0 && isset($isAdd)) || (isset($isUpdate) && $inspection->id == $inpsectUpdatedId) ? 'record-highlight' : '' }}">
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
                                        @if ($inspection->status == 'Error')
                                            Marked As Error
                                        @elseif ($inspection->status == 'Not Printed')
                                            Not Printed
                                        @endif
                                    </td>
                                    <td>
                                        @if ($inspection->status != 'Not Printed')
                                            <button class="btn fw-bold btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#inspection{{ $inspection->id }}" {{-- onclick="openModal(`inspection{{ $inspection->id }}`)" --}}
                                                value={{ $inspection->id }}>
                                                <i class="bi bi-card-text"></i>
                                                Details
                                            </button>
                                        @else
                                            @if ($inspection->registration_status == 'OCCUPANCY')
                                                <a class="btn btn-primary"
                                                    href={{ '/occupancy/print/' . $inspection->id }}><i
                                                        class="bi bi-printer-fill"></i>Print Certificate</a>
                                            @else
                                                <a class="btn btn-primary" href="/fsic/print/{{ $inspection->id }}"><i
                                                        class="bi bi-printer-fill"></i>Print Certificate</a>
                                            @endif

                                            <a class="btn btn-danger"
                                                href="/establishments/fsic/{{ $inspection->id }}/destroy"><i
                                                    class="bi bi-x-circle-fill mr-2" data-server-action></i>Delete</a>
                                        @endif
                                        @if ($inspection->status == 'Printed' || $inspection->status == 'Expired' || $inspection->status == 'Error')
                                            @if ($inspection->registration_status == 'OCCUPANCY')
                                                <a class="btn btn-primary"
                                                    href={{ '/occupancy/print/' . $inspection->id }}>
                                                    <i class="bi bi-file-earmark-fill"></i>
                                                    View Certificate
                                                </a>
                                            @else
                                                <a class="btn btn-primary" href={{ '/fsic/print/' . $inspection->id }}>
                                                    <i class="bi bi-file-earmark-fill"></i>
                                                    View Certificate
                                                </a>
                                            @endif
                                        @endif

                                        @if ($inspection->status == 'Expired')
                                            <div class="d-inline text-danger mx-2">Expired</div>
                                        @endif
                                    </td>
                                </tr>
                                {{-- Modal Detail --}}
                                <x-inspection.detail :inspection="$inspection" key="inspection{{ $inspection->id }}"
                                    :establishment="$establishment" />
                            @endforeach
                        </tbody>
                    </table>

                    @if ($inspections->count() >= 20)
                        <a class="link d-block text-center" href="#top" id="backToTop">Back to top</a>
                    @endif
                @else
                    <div class="fs-5 d-flex justify-content-center align-content-center mt-5">
                        <div class="border border-3 border-gray-500 rounded-3 px-5 py-3 text-secondary">
                            <h2 class="text-center text-secondary fw-bold fs-4">No Inspection</h2>
                            <div class="text-center text-secondary fw-normal">List of issued inspections will be shown here.
                            </div>
                        </div>
                    </div>
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
        {{-- <script defer src="{{ Vite::asset('resources/js/pages/inspections.js') }}"></script> --}}
    @endsection
