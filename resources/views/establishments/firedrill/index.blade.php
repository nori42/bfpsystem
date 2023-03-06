@extends('layouts.layout')

@section('content')

<div class="page-content">
    {{-- Put page content here --}}
    {{-- FSIC Action --}}
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <a href="" id="" class="btn btn-action rounded-0 fs-5 fsic-active">Example</a>
        <a href=""  id="" class="btn btn-action rounded-0 fs-5">Example</a>
        <a href=""  id="" class="btn btn-action rounded-0 fs-5">Example</a>
    </div>
    {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto mt-5">
        <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
        <div class="fs-5">Record No.: {{$establishment->id}}</div>
        <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Establishment: </span>{{$establishment->establishment_name}}</div>
    </div>
</div>
@endsection