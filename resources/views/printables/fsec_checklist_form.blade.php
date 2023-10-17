@extends('layouts.print')

@section('stylesheet')
    {{-- @vite('resources/css/pages/printables/fsec_checklist.css') --}}
@endsection

@section('issuedFor')
    {{-- PUT LITELAR STRING HERE NO TAGS --}}
    Fire Safety Evaluation Clearance Checklist Form
@endsection
@section('btngroup')
    <a class="btn btn-secondary d-none" href="/fsec/{{ $buildingPlan->id }}" btnback>Back</a>

    <a class="btn btn-success d-none" href="/fsec/{{ $buildingPlan->id }}" btndone> Done <i class="bi bi-check-lg"></i></a>
@endsection

@section('printTools')
@endsection

@section('printablePage')
    <div>This is checklist form</div>
@endsection

@section('pagescript')
    @vite('resources/js/pages/printables/fsec_checklist.js')
@endsection
