@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
<a href="/establishments/{{$establishment->id}}" class="material-symbols-outlined btn-back mt-5">
    arrow_back
</a>
<div class="page-content">
        {{-- Put page content here --}}
    {{-- page-wrapper --}}
    <x-pageWrapper>
        {{-- Owner Info & Selected Establishment --}}
        <x-headingInfo :establishment="$establishment" :owner="$owner"/>

        {{-- FSIC Action --}}
        <div class="d-flex w-100 mt-5">
            <x-action.link href="/establishments/fsic/{{$establishment->id}}" text="Inspection"/>
            <x-action.link href="/establishments/fsic/payment/{{$establishment->id}}" text="Payment" :active="true"/>
            <x-action.link href="/establishments/fsic/attachment/{{$establishment->id}}/fsic" text="Attachments"/>
        </div>

        {{-- Table --}}
        <div class="d-flex justify-content-end pt-3">
            <button class="btn btn-success" id="addPaymentBtn" onclick="openModal('addPaymentModal')">
                <span class="material-symbols-outlined align-middle">
                    payments
                </span>
                Add Payment
            </button>
        </div>
        <div id="payment" class="h-75 overflow-y-auto mt-4 border-3">
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
                        <td>{{date('m-d-Y', strtotime($payment->created_at))}}</td>
                        <td>{{$payment->certification}}</td>
                        <td>{{$payment->status}}</td>
                        <td class="text-center"><a href="/establishments/fsic/print/{{$payment->id}}" class="btn btn-warning"><span class="material-symbols-outlined">print</span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-pageWrapper>
    

    <!-- The Modal -->
    {{--Payment--}}
    <div id="addPaymentModal" class="modal" data-modal>
        <!-- Modal content -->
        <div class="modal-content" style="font-size: 0.9rem">
            <form action="/establishments/fsic/payment" method="POST" id="savePayment">
                @csrf
                
                <h4 class="px-4">Add Payment</h4>
                <div class="d-flex side-parent justify-content-center">
                    <div class="d-flex flex-column w-100 leftModal">
                        {{-- This is hidden, only used for post request--}}
                        <input class="info d-none" type="text" id="establishmentId" name="establishmentId" value="{{$establishment->id}}">

                        <label class="info-label" for="orNo">OR No.</label>
                        <input class="info" type="text" id="orNo" name="orNo" required value="">

                        <label class="info-label" for="natureOfPayment">Nature Of Payment</label>
                        <select name="natureOfPayment" id="natureOfPayment" required class="info">
                            <option value="" disabled selected>Select Nature Of Payment</option>
                        </select>

                        <label class="info-label" for="amountPaid">Amount Paid</label>
                        <input class="info" type="text" id="amountPaid" name="amountPaid" required>

                        <label class="info-label" for="certification">FSIC No.</label>
                        <input class="info" type="text" id="certification" name="certification" required>

                        <label class="info-label" for="date_of_payment">Date Of Payment</label>
                        <input class="info" type="date" id="date_of_payment" name="date_of_payment" required>

                        <label class="info-label" for="status">Registration Status</label>
                        <select name="status" id="status" required class="info">
                            <option value="" disabled selected>Select Registration Status</option>
                        </select>

                        <label class="info-label" for="dateIssued">Issued For</label>
                        <select name="issuedFor" id="issuedFor" required class="info">
                            <option value="" disabled selected>Select Issued For</option>
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

        <!-- Modal -->
    {{-- OwnerInfo --}}
    <x-modal id="modalOwner" width="70" location="5">
        <x-ownerInfo :establishment="$establishment" :owner="$owner"/>
    </x-modal>

    {{-- Import Script --}}
    <script src="{{ asset('js/selectOptions.js') }}"></script>

    {{-- Page Script --}}
    <script>
        const natureOfPaymentSelect = document.querySelector("#natureOfPayment")
        const regStatusSelect = document.querySelector("#status")
        const issuedForSelect = document.querySelector("#issuedFor")
        populateNatueOfPaymentSelect(natureOfPaymentSelect,natureOfPayments)
        populateSelect(regStatusSelect,regStatus)
        populateSelect(issuedForSelect,issuances)

        natureOfPaymentSelect.selectedIndex = 0
        regStatusSelect.selectedIndex = 0
        issuedForSelect.selectedIndex = 0

        var orNo = document.getElementById("orNo")
        var savePayment = document.getElementById("savePayment")
        var id = {!! $establishment->id !!}
        
        orNo.addEventListener("change", function(){
            savePayment.action = "/establishments/fsic/payment/" + id
        })
    </script>
</div>
@endsection