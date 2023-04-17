@extends('layouts.app')

@section('content')

<div class="page-content">
    {{-- Put page content here --}}
    <a href="/establishments/{{$establishment->id}}" class="material-symbols-outlined btn-back mt-5">
        arrow_back
    </a>

    <x-pageWrapper>
        {{-- Owner Info & Selected Establishment --}}
        <x-headingInfo :establishment="$establishment" :owner="$owner"/>
        {{-- FSIC Action --}}
        <div class="d-flex mt-5 w-100">
            <x-action.link href="/establishments/fsic/{{$establishment->id}}" text="Inspection" :active="true"/>
            <x-action.link href="/establishments/fsic/payment/{{$establishment->id}}" text="Payment"/>
            <x-action.link href="/establishments/fsic/attachment/{{$establishment->id}}/fsic" text="Attachments"/>
        </div>

        {{-- Inspection --}}
        <div class="d-flex justify-content-end">
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
    </x-pageWrapper>
    
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
                    {{-- <input class="info" type="text" id="compliantStatus" name="compliantStatus"> --}}
                    <select class="info" name="compliantStatus" id="compliantStatus">
                        <option value="Non-Compliant">Non-Compliant</option>
                        <option value="Compliant">Compliant</option>
                    </select>

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

    <x-modal id="modalOwner" width="70" location="5">
        <x-ownerInfo :establishment="$establishment" :owner="$owner"/>
    </x-modal>
</div>

@endsection