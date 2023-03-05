@extends('layouts.layout')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
<div class="page-content">
        {{-- Put page content here --}}

        {{-- FSIC Action --}}
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <a href="/establishments/fsic/{{$establishment->id}}" id="btnInspection" class="btn btn-action rounded-0 fs-5">Inspection</a>
        <a href="/establishments/fsic/payment/{{$establishment->id}}"  id="btnPayment" class="btn btn-action rounded-0 fs-5 fsic-active">Payment</a>
        <a href="/establishments/fsic/attachment/{{$establishment->id}}"  id="btnAttachments" class="btn btn-action rounded-0 fs-5">Attachments</a>
    </div>
    {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto mt-5">
        <h5 class="fw-bold"> Owner: {{$owner->last_name." ".$owner->first_name." ".$owner->middle_name}}</h5>
        <div class="fs-5">Record No.: {{$establishment->id}}</div>
        <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Establishment: </span>{{$establishment->establishment_name}}</div>
    </div>

    {{-- Table --}}
    <div id="payment" class="w-75 h-75 overflow-y-auto mx-auto mt-4 border-3">
        <table class="table">
            <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                <th>OR No.</th>
                <th>Nature of Payment</th>
                <th>Amount Paid</th>
                <th>Date Issued</th>
                <th>Certification</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr>
                    <td>{{$payment->or_no}}</td>
                    <td>{{$payment->nature_of_payment}}</td>
                    <td>{{$payment->amount_paid}}</td>
                    <td>{{$payment->created_at}}</td>
                    <td>{{$payment->certification}}</td>
                    <td>{{$payment->status}}</td>

                    <td><a href="/establishments/fsic/print/{{$establishment->id}}&{{$payment->or_no}}" class="btn btn-warning mx-5"><span class="material-symbols-outlined">print</span> </a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <button class="btn btn-success px-4" id="addPaymentBtn" onclick="openModal('addPaymentModal')">Add</button>
        </div>
        
    </div>

        <!-- The Modal -->
        {{--Inspection--}}
        <div id="addPaymentModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content" style="font-size: 0.9rem">
                
                {{-- arrays for drop-downs --}}
                @php
                    $issuances = [
                        'THE PURPOSE OF SECURING BUSINESS PERMIT',
                        'NEW BUSINESS PERMIT',
                        'OCCUPANCY PERMIT',
                        'RENEWAL OF BUSINESS PERMIT',
                        'RENEWAL OF BUSINESS PERMIT/TESDA ACCREDITATION',
                        'RENEWAL OF BUSINESS PERMIT/DOT ACCREDITATION',
                        'PEZA OCCUPANCY PERMIT',
                        'ANNUAL INSPECTION OF PEZA CERTIFICATE'
                    ];

                    $regStatus = [
                        'NEW',
                        'RENEWAL',
                        'OCCUPANCY',
                        'BUILDING PERMIT',
                        'ACCREDITATION'
                    ];
                @endphp

                <form action="/establishments/fsic/payment/" method="POST" id="savePayment">
                    @csrf
                    <div class="d-flex side-parent justify-content-center">
                        <div class="d-flex flex-column w-100 leftModal">
                            {{-- This is hidden, only used for post request--}}
                            <input class="info d-none" type="text" id="establishmentId" name="establishmentId" value="{{$establishment->id}}">
    
                            <label class="info-label" for="orNo">OR No.</label>
                            <input class="info" type="text" id="orNo" name="orNo" required value="">
    
                            <label class="info-label" for="natureOfPayment">Nature Of Payment</label>
                            <select name="natureOfPayment" id="natureOfPayment" required class="info">
                                @foreach ($natureOfPayment as $nop)
                                    <option value="{{$nop['DESCRIPTION']}}">{{$nop['DESCRIPTION']}} - {{$nop['NATURE_PAYMENT']}} - {{$nop['CODE']}}</option>
                                @endforeach
                            </select>
    
                            <label class="info-label" for="amountPaid">Amount Paid</label>
                            <input class="info" type="text" id="amountPaid" name="amountPaid" required>
    
                            <label class="info-label" for="certification">Certificate No.</label>
                            <input class="info" type="text" id="certification" name="certification" required>

                            <label class="info-label" for="date_of_payment">Date Of Payment</label>
                            <input class="info" type="date" id="date_of_payment" name="date_of_payment" required>
    
                            <label class="info-label" for="status">Registration Status</label>
                            <select name="status" id="status" required class="info">
                                @foreach ($regStatus as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
    
                            <label class="info-label" for="dateIssued">Issued For</label>
                            <select name="issuedFor" id="issuedFor" required class="info">
                                @foreach ($issuances as $issuance)
                                    <option value="{{$issuance}}">{{$issuance}}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="d-flex flex-column w-100 rightModal">
                            <label class="info-label" for="expiry_date">Expiry Date</label>
                            <input class="info" type="date" id="expiry_date" name="expiry_date" required>
    
                            <label class="info-label" for="buildingConditions">Building Conditions</label>
                            <textarea class="info" type="comment" id="buildingConditions" name="buildingConditions" required></textarea>
    
                            <label class="info-label" for="buildingStructures">Building Structures</label>
                            <textarea class="info" type="text" id="buildingStructures" name="buildingStructures" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 modal-button-container">
                        {{-- <a href="/establishments/fsic/print/{{$establishment->id}}" class="btn btn-primary mx-5">Print & Save</a> --}}
                        <button class="btn btn-success">Save & Print</button>
                    </div>
                    
                </form>
            </div>
        </div>
        {{-- script for this page only --}}
        <script>
            var orNo = document.getElementById("orNo")
            var savePayment = document.getElementById("savePayment")
            var id = {!! $establishment->id !!}
            
            orNo.addEventListener("change", function(){
                savePayment.action = "/establishments/fsic/payment/" + id
            })
        </script>
</div>
@endsection