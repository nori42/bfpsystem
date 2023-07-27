@extends('layouts.app')

@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        {{-- <x-backBtn /> --}}

        @isset($toastMssg)
            <x-toast :message="$toastMssg" />
        @endisset
        <x-pageWrapper>

            {{-- Owner Info & Selected Establishment --}}
            <x-headingInfo :establishment="$establishment" :owner="$owner" :representative="$representative" />
            {{-- FSIC Action --}}
            <div class="d-flex mt-3 w-100">
                <x-action.link href="/establishments/{{ $establishment->id }}/fsic" text="Inspection" :active="true" />
                {{-- <x-action.link href="/establishments/fsic/payment/{{ $establishment->id }}" text="Payment" /> --}}
                <x-action.link href="/establishments/fsic/attachment/{{ $establishment->id }}/fsic" text="Attachments" />
            </div>

            {{-- Inspection --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @if ($establishment->inspection_is_expired)
                        <x-tag bgColor="bg-danger" text="Expired Inspection" />
                    @endif
                </div>
                <button class="btn btn-success mt-3" id="addInspectionBtn" onclick="openModal('addInspectionModal')">
                    <span class="material-symbols-outlined align-middle">
                        assignment_add
                    </span>
                    Add Inspection
                </button>
            </div>
            <div id="inspection" class="h-75 overflow-y-auto mt-4 border-3">
                @if ($inspections->count() != 0)
                    <table class="table">
                        <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle textPrimary">
                            <th>Inspection Date</th>
                            <th>OR No.</th>
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
                                    <td>{{ $inspection->receipt->or_no }}</td>
                                    <td>{{ $inspection->registration_status }}</td>
                                    <td>{{ $inspection->expiry_date ? date('m/d/Y', strtotime($inspection->expiry_date)) : '' }}
                                    </td>
                                    <td class="{{ $inspection->status == 'Printed' ? 'text-success' : 'text-danger' }}">
                                        {{ $inspection->status }}</td>
                                    <td class="text-center">
                                        <button class="btn fw-bold btn-success"
                                            onclick="openModal(`inspection{{ $inspection->id }}`)"
                                            value={{ $inspection->id }}>
                                            Details
                                        </button>
                                    </td>
                                </tr>

                                <x-inspectionDetail :inspection="$inspection" key="inspection{{ $inspection->id }}"
                                    :establishment="$establishment" />
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h2 class="text-center text-secondary">No Inspection</h2>
                @endif
            </div>
        </x-pageWrapper>

        <!-- Modal -->
        {{-- Inspection --}}
        <x-modal id="addInspectionModal" width="50" topLocation="2">
            <x-inspectionForm :establishment="$establishment" inputAttr="input-inspect" />
        </x-modal>
    </div>
@endsection
