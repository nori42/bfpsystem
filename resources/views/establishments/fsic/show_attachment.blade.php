@extends('layouts.layout')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
<div class="page-content">
        {{-- Put page content here --}}
        {{-- FSIC Action --}}
        <div class="d-flex justify-content-between w-75 mx-auto mt-5">
            <a href="/establishments/fsic/{{$establishment->id}}" id="btnInspection" class="btn btn-action rounded-0 fs-5">Inspection</a>
            <a href="/establishments/fsic/payment/{{$establishment->id}}"  id="btnPayment" class="btn btn-action rounded-0 fs-5">Payment</a>
            <a href="/establishments/fsic/attachment/{{$establishment->id}}"  id="btnAttachments" class="btn btn-action rounded-0 fs-5 fsic-active">Attachments</a>
        </div>
        {{-- Owner Info & Selected Establishment --}}
        <div class="w-75 mx-auto mt-5">
            <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
            <div class="fs-5">Record No.: {{$establishment->id}}</div>
            <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Establishment: </span>{{$establishment->establishment_name}}</div>
        </div>

        {{-- Attachments --}}
        <div id="attachments" class="w-75 h-75 overflow-y-auto mx-auto mt-4 border-3">
            <table class="table">
                <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                    <th>File Name</th>
                    <th>Type</th>
                    <th>Date Added</th>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            <input class="btn bg-secondary-subtle" id="addAttachmentsBtn" onclick="openModal('addAttachmentsModal')" type="file" value="Add"/>
        </div>
</div>
@endsection