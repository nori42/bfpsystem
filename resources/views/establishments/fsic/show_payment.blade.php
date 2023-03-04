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
        <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
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
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr>
                    <td>{{$payment->or_no}}</td>
                    <td>{{$payment->nature_of_payment}}</td>
                    <td>{{$payment->amount_paid}}</td>
                    <td>{{$payment->date_issued}}</td>
                    <td>{{$payment->certification}}</td>
                    <td>{{$payment->status}}</td>
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
                <form action="/establishments/fsic/payment/{{$establishment->id}}" method="POST">
                    @csrf
                    <div class="d-flex flex-column w-100">
                        {{-- This is hidden, only used for post request--}}
                        <input class="info d-none" type="text" id="establishmentId" name="establishmentId" value="{{$establishment->id}}">

                        <label class="info-label" for="orNo">OR No.</label>
                        <input class="info" type="text" id="orNo" name="orNo">

                        <label class="info-label" for="natureOfPayment">Nature Of Payment</label>
                        <input class="info" type="text" id="natureOfPayment" name="natureOfPayment">

                        <label class="info-label" for="amountPaid">Amount Paid</label>
                        <input class="info" type="text" id="amountPaid" name="amountPaid">

                        <label class="info-label" for="dateIssued">Date Issued</label>
                        <input class="info" type="text" id="dateIssued" name="dateIssued">

                        <label class="info-label" for="certification">Certification</label>
                        <input class="info" type="text" id="certification" name="certification">

                        <label class="info-label" for="status">Status</label>
                        <input class="info" type="text" id="status" name="status">
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="/establishments/fsic/print/{{$establishment->id}}" class="btn btn-primary mx-5">Print</a>
                        <button class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>

        </div>


</div>
@endsection