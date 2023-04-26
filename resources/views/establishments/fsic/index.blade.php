@extends('layouts.app')

@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        <x-backBtn />

        <x-pageWrapper>

            {{-- Owner Info & Selected Establishment --}}
            <x-headingInfo :establishment="$establishment" :owner="$owner" />
            {{-- FSIC Action --}}
            <div class="d-flex mt-3 w-100">
                <x-action.link href="/establishments/fsic/{{ $establishment->id }}" text="Inspection" :active="true" />
                {{-- <x-action.link href="/establishments/fsic/payment/{{ $establishment->id }}" text="Payment" /> --}}
                <x-action.link href="/establishments/fsic/attachment/{{ $establishment->id }}/fsic" text="Attachments" />
            </div>

            {{-- Inspection --}}
            <div class="d-flex justify-content-between align-items-center">
                <div class="fs-5">Building Structure: <b> {{ $establishment->building_type }}</b></div>
                <button class="btn btn-success mt-3" id="addInspectionBtn" onclick="openModal('addInspectionModal')">
                    <span class="material-symbols-outlined align-middle">
                        assignment_add
                    </span>
                    Add Inspection
                </button>
            </div>
            <div id="inspection" class="h-75 overflow-y-auto mt-4 border-3">
                <table class="table">
                    <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                        <th class="text-primary">Inspection Date</th>
                        <th class="text-primary">OR No.</th>
                        <th class="text-primary">Registration Status</th>
                        <th class="text-primary">Expiry Date</th>
                        <th class="text-primary">Status</th>
                        <th class="text-primary"></th>
                    </thead>
                    <tbody>
                        @foreach ($inspections as $inspection)
                            <tr class="align-middle">
                                <td>{{ date('m/d/Y', strtotime($inspection->inspection_date)) }}</td>
                                <td>{{ $inspection->receipt->or_no }}</td>
                                <td>{{ $inspection->registration_status }}</td>
                                <td>{{ $inspection->expiry_date }}
                                </td>
                                <td class="{{ $inspection->status == 'Printed' ? 'text-success' : 'text-danger' }}">
                                    {{ $inspection->status }}</td>
                                <td class="text-center">
                                    <button class="btn fw-bold btn-success"
                                        onclick="openModal(`inspection{{ $inspection->id }}`)" value={{ $inspection->id }}>
                                        Details
                                    </button>
                                </td>
                            </tr>

                            <x-inspectionDetail :inspection="$inspection" key="inspection{{ $inspection->id }}"
                                :establishment="$establishment" />
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-pageWrapper>

        <!-- Modal -->
        {{-- Inspection --}}
        <x-modal id="addInspectionModal" width="50" topLocation="2">
            <x-inspectionForm :establishment="$establishment" inputAttr="input-inspect" />
        </x-modal>


        <x-modal id="modalOwner" width="50" topLocation="5">
            <x-ownerInfo :establishment="$establishment" :owner="$owner" />
        </x-modal>
    </div>
    {{-- Import Script --}}
    <script src="{{ asset('js/selectOptions.js') }}"></script>
    <script src="{{ asset('js/fetch.js') }}"></script>

    {{-- Page Script --}}
    <script>
        const natureOfPaymentSelect = document.querySelector("#natureOfPayment")
        const regStatusSelect = document.querySelector("#registrationStatus")
        const issuedForSelect = document.querySelector("#issuedFor")
        const natureOfPaymentSelectDetail = document.querySelector("#natureOfPaymentDetail")
        const regStatusSelectDetail = document.querySelector("#registrationStatusDetail")
        const issuedForSelectDetail = document.querySelector("#issuedForDetail")
        const btnSave = document.querySelector('#btnSave')

        async function showDetail() {
            const inspectionDetails = await getInspectionById("{{ env('APP_URL') }}", event.target.value);

            console.log(inspectionDetails.fsicNo)

            document.querySelector('#inspectionDateDetail').value = inspectionDetails.inspectionDate;
            document.querySelector('#buildingConditionsDetail').value = inspectionDetails.buildingCondtions;
            document.querySelector('#buildingStructuresDetail').value = inspectionDetails.buildingStructures;
            document.querySelector('#orNoDetail').value = inspectionDetails.orNo;
            document.querySelector('#natureOfPaymentDetail').value = inspectionDetails.natureOfPayment;
            document.querySelector('#amountPaidDetail').value = inspectionDetails.amount;
            document.querySelector('#fsicNoDetail').value = inspectionDetails.fsicNo;
            document.querySelector('#dateOfPaymentDetail').value = inspectionDetails.dateOfPayment;
            document.querySelector('#registrationStatusDetail').value = inspectionDetails.registrationStatus;
            document.querySelector('#issuedForDetail').value = inspectionDetails.issuedFor;

            openModal('detailInspectionModal');
        }

        // populateNatueOfPaymentSelect(natureOfPaymentSelect, natureOfPayments)
        // populateSelect(regStatusSelect, regStatus)
        // populateSelect(issuedForSelect, issuances)

        natureOfPaymentSelect.selectedIndex = 0
        regStatusSelect.selectedIndex = 0
        issuedForSelect.selectedIndex = 0

        var orNo = document.getElementById("orNo")
        var savePayment = document.getElementById("savePayment")
        var id = {!! $establishment->id !!}

        orNo.addEventListener("change", function() {
            savePayment.action = "/establishments/fsic/payment/" + id
        })
    </script>
@endsection
