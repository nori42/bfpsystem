@extends('layouts.layout')


@section('content')
<div class="page-content">
    {{-- Put page content here --}}
    
    {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto mt-5">
        <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
        <div class="fs-5">Record No.: {{$establishment->record_no}}</div>
        <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Selected Establishment: </span>{{$establishment->establishment_name}}</div>
    </div>

    {{-- Inspection --}}
    <div>

    </div>

    {{-- Payment --}}
    <div>

    </div>

    {{-- Attachments --}}
    <div>

    </div>
</div>
@endsection