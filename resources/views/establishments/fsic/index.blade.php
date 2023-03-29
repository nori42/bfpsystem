@extends('layouts.layout')

@section('content')

<div class="page-content">
    {{-- Put page content here --}}
    <a href="/establishments/{{$establishment->id}}" class="material-symbols-outlined btn-back mt-5">
        arrow_back
    </a>
    {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto ">
        <div class="fs-5">Record No.: {{$establishment->id}}</div>

        <div>
            <p class="fs-5 mb-0"> Owner: {{$establishment->owner->last_name.", ".$establishment->owner->first_name." ".$establishment->owner->middle_name}}</p>
            <p class="fw-bold fs-5">Establishment: {{$establishment->establishment_name}}</p>
        </div>

        <div class="position-relative">
            <button type="button" class="btn btn-outline-success"style="width:auto !important" data-dropdown-btn onclick="toggleShow('establishmentDetail')"><span class="material-symbols-outlined fs-3 align-middle">domain</span>Establishment Info</button>
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
        <a href="/establishments/fsic/{{$establishment->id}}" id="btnInspection" class="btn btn-action rounded-0 fs-5 fsic-active">Inspection</a>
        <a href="/establishments/fsic/payment/{{$establishment->id}}"  id="btnPayment" class="btn btn-action rounded-0 fs-5">Payment</a>
        <a href="/establishments/fsic/attachment/{{$establishment->id}}/fsic"  id="btnAttachments" class="btn btn-action rounded-0 fs-5">Attachments</a>
    </div>

    {{-- Inspection --}}
    <div class="d-flex justify-content-end w-75 mx-auto">
        <button class="btn btn-success mt-3" id="addInspectionBtn" onclick="openModal('addInspectionModal')">
            <span class="material-symbols-outlined align-middle">
                assignment_add
            </span>
            Add Inspection
        </button>
    </div>
    <div id="inspection" class="w-75 h-75 overflow-y-auto mx-auto mt-4 border-3">
        <table class="table">
            <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                <th>Inspection Date</th>
                <th>Compliant Status</th>
                <th>Action Taken</th>
                <th>Building Type</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                <tr class="align-middle">
                    <td>{{date('m-d-Y', strtotime($inspection->inspection_date))}}</td>
                    <td>{{$inspection->compliant_status}}</td>
                    <td>{{$inspection->action_taken}}</td>
                    <td>{{$inspection->building_type}}</td>
                    <td>{{$inspection->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    {{--Inspection--}}
    <div id="addInspectionModal" class="modal" data-modal>
        <!-- Modal content -->
        <div class="modal-content" style="font-size: 0.9rem">
            <form action="/establishments/fsic/{{$establishment->id}}" method="POST">
                @csrf
                <fieldset class="d-flex flex-column">
                    {{-- This is hidden, only used for post request--}}
                    <input class="info d-none" type="text" id="establishmentId" name="establishmentId" value="{{$establishment->id}}">

                    <label class="info-label" for="inpsectionDate">Inspection Date</label>
                    <input class="info" type="date" id="inspectionDate" name="inspectionDate">

                    <label class="info-label" for="compliantStatus">Compliant Status</label>
                    <input class="info" type="text" id="compliantStatus" name="compliantStatus">

                    <label class="info-label" for="status">Status</label>
                    <input class="info" type="text" id="status" name="status">

                    <label class="info-label" for="actionTaken">Action Taken</label>
                    <input class="info" type="text" id="actionTaken" name="actionTaken">

                    <label class="info-label" for="buildingType">Building Type</label>
                    <select class="info" name="buildingType" id="buildingType">
                        @php
                            $buildingType = [
                            'Small',
                            'Medium',
                            'Large',
                            'High Rise'
                        ];
                        @endphp
                        $@foreach ($buildingType as $item)
                            <option value="{{$item}}">{{$item}}</option>
                        @endforeach
                    </select>
            </fieldset>

            <div class="d-flex justify-content-end mt-3">
                <input class="btn btn-success" type="submit" value="Save"/>
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
</div>

@endsection