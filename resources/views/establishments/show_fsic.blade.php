@extends('layouts.layout')

<style>
    .btn-action{
        border: 2px solid black !important;
        width: inherit;
    }
</style>

@section('content')

<div class="page-content">
    {{-- Put page content here --}}

    {{-- FSIC Action --}}
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <button class="btn btn-action rounded-0 fs-5">Inspection</button>
        <a href="/establishments/fsic/{{$establishment->record_no}}" class="btn rounded-0 fs-5 btn-action">Payment</a>
        <button class="btn btn-action rounded-0 fs-5">Attachments</button>
    </div>
    {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto mt-5">
        <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
        <div class="fs-5">Record No.: {{$establishment->record_no}}</div>
        <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Selected Establishment: </span>{{$establishment->establishment_name}}</div>
    </div>

    {{-- Inspection --}}
    <div id="inspection" class="w-75 mx-auto mt-4 border-3">
        <table class="table">
            <thead>
                <th>Rec No.</th>
                <th>Inspection Date</th>
                <th>Status</th>
                <th>Compliant Status</th>
                <th>Action Taken</th>
                <th>Building Type</th>
                <th></th>
            </thead>
            <tbody>
                
            </tbody>
        </table>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Launch demo modal
          </button>
          
    </div>

    {{-- Payment --}}
    <div>

    </div>

    {{-- Attachments --}}
    <div>

    </div>



    {{-- Models --}}

    {{--Inspection--}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
        </div>

    {{--Payment--}}
    <div>

    </div>

    {{--Attachments--}}
    <div>

    </div>
</div>
@endsection