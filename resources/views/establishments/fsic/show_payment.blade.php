@extends('layouts.layout')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
<a href="/establishments/{{$establishment->id}}" class="material-symbols-outlined btn-back mt-5">
    arrow_back
</a>
<div class="page-content">
        {{-- Put page content here --}}

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
    </div>

    {{-- FSIC Action --}}
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <a href="/establishments/fsic/{{$establishment->id}}" id="btnInspection" class="btn btn-action rounded-0 fs-5">Inspection</a>
        <a href="/establishments/fsic/payment/{{$establishment->id}}"  id="btnPayment" class="btn btn-action rounded-0 fs-5 fsic-active">Payment</a>
        <a href="/establishments/fsic/attachment/{{$establishment->id}}/fsic"  id="btnAttachments" class="btn btn-action rounded-0 fs-5">Attachments</a>
    </div>

    {{-- Table --}}
    <div class="d-flex justify-content-end w-75 mx-auto pt-3">
        <button class="btn btn-success" id="addPaymentBtn" onclick="openModal('addPaymentModal')">
            <span class="material-symbols-outlined align-middle">
                payments
            </span>
            Add Payment
        </button>
    </div>
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
                    <td>{{date('m-d-Y', strtotime($payment->created_at))}}</td>
                    <td>{{$payment->certification}}</td>
                    <td>{{$payment->status}}</td>
                    <td class="text-center"><a href="/establishments/fsic/print/{{$payment->id}}" class="btn btn-warning"><span class="material-symbols-outlined">print</span></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        
    </div>

        <!-- The Modal -->
        {{--Inspection--}}
        <div id="addPaymentModal" class="modal" data-modal>
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

        <!-- Modal -->
    {{-- OwnerInfo --}}
    <div id="modalOwner" class="modal" data-modal>

        <!-- Modal content -->
        <div class="modal-content ">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Owner Information</h5>
          </div>
      
              <form>
                  <div class="d-flex gap-2">
                      <div class="my-2 w-100">
                          <label class="info-label">First Name</label>
                          <input type="text"  class="form-control input-lg" value="{{$establishment->owner->first_name}}" disabled>
                      </div>
          
                      <div class="my-2 w-100">
                          <label class="info-label">Middle Name</label>
                          <input type="text" class="form-control input-lg" value="{{$establishment->owner->middle_name}}" disabled>
                      </div>
                      <div class="my-2 w-100">
                          <label class="info-label">Last Name</label>
                          <input type="text" class="form-control input-lg" value="{{$establishment->owner->last_name}}" disabled>
                      </div>
                  </div>
                  
                  <div class="d-flex gap-3">
                      <div class="my-2 w-100">
                          <label class="info-label">Contact No.</label>
                          <input type="text" class="form-control info-lg" value="{{$establishment->owner->contact_no}}" disabled>
                      </div>
                      
                  </div>
                  
              </form>
              
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Owner Establishment(s)</h5>
              </div>
              
              <!--Establishment Table-->
              <div class="w-100 h-75 overflow-y-auto mx-auto mt-4 border-3" style="height: 300px !important;">
                  <table class="table">
                      <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                          <th>Rec No.</th>
                          <th>Establishment</th>
                          <th></th>
                      </thead>
                      <tbody>
                          @foreach ($owner->establishment as $establishment)
                          <tr>
                              <td>{{$establishment->id}}</td>
                              <td>{{$establishment->establishment_name}}</td>
                              <td><a href="/establishments/{{$establishment->id}}" class="btn btn-success">View</a></td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                  {{-- <a  class="btn btn-success btn-lg fs-5" href="/establishments/create/{{$establishment->owner_id}}" >Add New Establishment</a> --}}
                  <div class="d-flex justify-content-end">
                      <a class="btn btn-success text-white px-5 py-2 align-middle" href="/establishments/create/{{$establishment->owner_id}}"><span class="material-symbols-outlined align-middle">domain_add</span>Add New Establishment</a>
                  </div>
              </div>
      
          </div>
        </div>
      
      
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