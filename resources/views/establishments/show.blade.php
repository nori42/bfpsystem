@extends('layouts.layout')


@section('content')
    <style>
        .btn-show{
            background-color: #53A3D8;
            color: black;
            font-weight: 600;
            width: 80%;
        }
        .btn-show:hover{
            background-color: #53A3D8 !important;
            color: black !important;
        }

        .owner-info .btn:hover {
            background-color: #8ED2FF !important;
            color: black !important;
        }

    </style>
    
    
    <div class="w-75 mx-auto border-1 mt-5">
        <div class="d-flex justify-content-between gap-4">
            <button class="btn btn-show fs-5">FSEC</button>
            <a href="/establishments/fsic/{{$establishment->record_no}}" class="btn btn-show fs-5">FSIC</a>
            <button class="btn btn-show fs-5">FIRE DRILL</button>
        </div>

        <div class="pt-5 d-flex justify-content-between owner-info">
            <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->last_name}}</h5>
            <button class="btn" style="background-color: #8ED2FF; font-weight: bold;">Establishment</button>
        </div>
        <div class="fs-5">Record No.: {{$establishment->record_no}}</div>
        <div class="w-100 text-black p-2 mt-2" style="background-color: #D9D9D9;"><span class="fw-bold">Selected Establishment: </span>{{$establishment->establishment_name}}</div>
    </div>
@endsection