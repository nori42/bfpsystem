@extends('layouts.layout')

@section('content')

<div class="page-content">
    {{-- Put page content here --}}
    <a href="/establishments/{{$establishment->id}}" class="material-symbols-outlined btn-back mt-5">
        arrow_back
    </a>
    {{-- FSIC Action --}}
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <a href="/establishments/fsic/{{$establishment->id}}" id="btnInspection" class="btn btn-action rounded-0 fs-5 fsic-active">Inspection</a>
        <a href="/establishments/fsic/payment/{{$establishment->id}}"  id="btnPayment" class="btn btn-action rounded-0 fs-5">Payment</a>
        <a href="/establishments/fsic/attachment/{{$establishment->id}}"  id="btnAttachments" class="btn btn-action rounded-0 fs-5">Attachments</a>
    </div>
    {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto mt-5">
        <h5 class="fw-bold"> Owner: {{$establishment->owner->last_name." ".$establishment->owner->first_name." ".$establishment->owner->middle_name}}</h5>
        <div class="fs-5">Record No.: {{$establishment->id}}</div>
        <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Establishment: </span>{{$establishment->establishment_name}}</div>
    </div>

    {{-- Inspection --}}
    <div class="d-flex justify-content-end w-75 mx-auto">
        <button class="btn btn-success mt-3 px-4" id="addInspectionBtn" onclick="openModal('addInspectionModal')">Add</button>
    </div>
    <div id="inspection" class="w-75 h-75 overflow-y-auto mx-auto mt-4 border-3">
        <table class="table">
            <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                <th>Rec No.</th>
                <th>Inspection Date</th>
                <th>Compliant Status</th>
                <th>Action Taken</th>
                <th>Building Type</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                <tr class="align-middle">
                    <td>{{$inspection->record_no}}</td>
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

    <!-- The Modal -->
    {{--Inspection--}}
    <div id="addInspectionModal" class="modal">
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

    </div>

</div>
@endsection