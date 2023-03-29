@extends('layouts.layout')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
<div class="page-content">
        {{-- Put page content here --}}

        <a href="/establishments/{{$establishment->id}}" class="material-symbols-outlined btn-back mt-5">
            arrow_back
        </a>

        {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto">
        <div class="fs-5">Record No.: {{$establishment->id}}</div>

        <div>
            <p class="fs-5 mb-0"> Owner: {{$establishment->owner->last_name.", ".$establishment->owner->first_name." ".$establishment->owner->middle_name}}</p>
            <p class="fw-bold fs-5">Establishment: {{$establishment->establishment_name}}</p>
        </div>
        <div class="position-relative">
            <button type="button" class="btn btn-outline-success" style="width:auto !important" data-dropdown-btn onclick="toggleShow('establishmentDetail',this)"><span class="material-symbols-outlined fs-3 align-middle">domain</span>Establishment Info</button>
            <div class="dropdown-menus position-absolute p-3" id="establishmentDetail" data-dropdown-menu style="display: none !Important">
                <ul class="list-unstyled">
                    <li><span class="fw-bold">Establishment Name: </span>{{$establishment->establishment_name}}</li>
                    <li><span class="fw-bold">Substation: </span>{{$establishment->substation}}</li>
                    <li><span class="fw-bold">Occupancy: </span>{{$establishment->occupancy}}</li>
                    <li><span class="fw-bold">Sub Type: </span>{{$establishment->sub_type}}</li>
                    <li><span class="fw-bold">Building Type: </span>{{$establishment->building_type}}</li>
                    <li><span class="fw-bold">No. of storey: </span>{{$establishment->no_of_storey}}</li>
                    <li><span class="fw-bold">Height: </span>{{$establishment->height}}</li>
                    <li><span class="fw-bold">Building Permit: </span>{{$establishment->building_permit_no}}</li>
                    <li><span class="fw-bold">Fire Insurance Co: </span>{{$establishment->fire_insurance_co}}</li>
                    <li><span class="fw-bold">Latest Permit: </span>{{$establishment->latest_permit}}</li>
                    <li><span class="fw-bold">Barangay: </span>{{$establishment->barangay}}</li>
                    <li><span class="fw-bold">Address: </span>{{$establishment->address}}</li>
                </ul>
            </div>
            <button type="button" class="btn btn-outline-success" style="width:auto !important" onclick="openModal('modalOwner')"><span class="material-symbols-outlined fs-3 align-middle">account_box</span>Owner Info</button>
        </div>
{{--         
        @if (session('mssg'))
        <div class="mt-3">
            <h5 class="text-success w-90 w-25">{{session('mssg')}} {{session('files')}}</h5>
        </div>
        @endif --}}
    </div>

        {{-- FSIC Action --}}
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <a href="/establishments/fsec/{{$establishment->id}}"  id="btnPayment" class="btn btn-action rounded-0 fs-5 fsic-active">Process</a>
        <a href="/establishments/fsec/attachment/{{$establishment->id}}/fsec"  id="btnAttachments" class="btn btn-action rounded-0 fs-5">Attachments</a>
    </div>

    {{-- Table --}}
    <div id="fsec" class="w-75 h-75 overflow-y-auto mx-auto mt-4 border-3">
        <table class="table">
        </table>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success px-4" id="addPaymentBtn" onclick="openModal('addPaymentModal')">Add Process</button>
        </div>

        <div id="fsec" class="h-75 overflow-y-auto mx-auto mt-4 border-3">
            <table class="table">
                <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                    <th>OR No.</th>
                    <th>Certificate No.</th>
                    <th>Evaluator</th>
                    <th>Date Of Payment</th>
                    <th>Date Of Release</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody>
                    @foreach ($establishment->evaluation as $evaluation)
                    <tr>
                        <td>{{ $evaluation->or_no }}</td>
                        <td>{{ $evaluation->certification_no }}</td>
                        <td>{{ $evaluation->evaluator }}</td>
                        <td>{{date('m-d-Y', strtotime($evaluation->date_of_payment))}}</td>
                        <td>{{date('m-d-Y', strtotime($evaluation->date_release))}}</td>
                        <td class="text-center"><a href="/establishments/fsec/print/{{$evaluation->id}}" class="btn btn-warning"><span class="material-symbols-outlined">print</span> </a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>

        <!-- The Modal -->
        {{--Inspection--}}
        <div id="addPaymentModal" class="modal" data-modal>
            <!-- Modal content -->
            <div class="modal-content" style="font-size: 0.9rem">
                <form action="/establishments/fsec/{{$establishment->id}}" method="POST" id="saveEvaluation">
                    @csrf
                    <div class="d-flex side-parent justify-content-center">
                        <div class="d-flex flex-column w-100 leftModal">

                            <label class="info-label" for="orNo">OR No.</label>
                            <input class="info" type="text" id="orNo" name="orNo" required value="">
    
                            <label class="info-label" for="amountPaid">Amount Paid</label>
                            <input class="info" type="text" id="amountPaid" name="amountPaid" required>
    
                            <label class="info-label" for="date_of_payment">Date Of Payment</label>
                            <input class="info" type="date" id="date_of_payment" name="date_of_payment" required>

                            <label class="info-label" for="evaluator">Evaluator</label>
                            <input class="info" type="text" id="evaluator" name="evaluator">

                            <label class="info-label" for="certification">Certificate No.</label>
                            <input class="info" type="text" id="certification" name="certification" required>

                            <label class="info-label" for="date_release">Date Release</label>
                            <input class="info" type="date" id="date_release" name="date_release" required>
                        </div>
    
                        <div class="d-flex flex-column w-100 rightModal">
                            <label class="info-label" for="boq">BOQ</label>
                            <input class="info" type="text" id="boq" name="boq">

                            <label class="info-label" for="remarks">Remarks</label>
                            <textarea class="info" id="remarks" name="remarks"></textarea>

                            <label class="info-label" for="purpose">Purpose</label>
                            <textarea class="info" id="purpose" name="purpose"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 modal-button-container">
                        <button class="btn btn-success">Save & Print</button>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection