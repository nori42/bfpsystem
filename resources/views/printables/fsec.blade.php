@extends('layouts.print')

@php
    $receipt = $buildingPlan->receipt;
    
    $evaluator = auth()->user()->personnel->first_name . ' ' . auth()->user()->personnel->last_name;
    
    $representative = $buildingPlan->getOwnerName();
    
    //Marshal and Chief Name
    $json = resource_path('json\printSettings.json');
    $jsonData = File::get($json);
    $printSettings = json_decode($jsonData, true);
    ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
@endphp

@section('stylesheet')
    @vite('resources/css/pages/printables/fsec.css')
@endsection

@section('issuedFor')
    {{-- PUT LITELAR STRING HERE NO TAGS --}}
    Fire Safety Evaluation Clearance
@endsection

@section('btngroup')
    <a class="btn btn-secondary" href="/fsec/{{ $buildingPlan->id }}" btnback>Back</a>

    <form class="d-none m-0" id="print" action="/fsec/print/{{ $buildingPlan->id }}" method="POST" btndone>
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $evaluator }}" name="evaluator">
        <button class="btn btn-success">Done<i class="bi bi-check-lg"></i></button>
    </form>
    {{-- <a class="btn btn-success d-none" href="/fsec/{{ $buildingPlan }}" btndone>Done <i class="bi bi-check-lg"></i></a> --}}
@endsection

@section('printTools')
@endsection

@section('printablePage')
    <div class="printablePage">
        <div data-draggable="true" class="header bold">
            <div>Cebu City Fire Office</div>
            <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
            <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
            <div>Email Address: cebucityfsn@yahoo.com</div>
        </div>

        <div data-draggable="true" class="date-container bold">
            {{ date('F d Y') }}
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $buildingPlan->name_of_building }}</span>
        </div>

        <div data-draggable="true" class="address bold">
            <span>{{ $buildingPlan->address }}</span>
        </div>

        <div data-draggable="true" class="rep-name bold">
            <span>{{ $representative }}</span>
        </div>

        <div data-draggable="true" class="fc-fee">
            <div id="amount">{{ $receipt->amount }}</div>
            <div id="or_no">{{ $receipt->or_no }}</div>
            <div id="date">{{ date('m/d/Y', strtotime($receipt->date_of_payment)) }}</div>
        </div>

        <div data-draggable="true" id="chiefName" class="chiefName">{{ $chief }}</div>
        <div data-draggable="true" id="marshalName" class="marshalName">{{ $marshal }}</div>
    </div>
@endsection

@section('pagescript')
    {{-- @vite('resources/js/pages/printables/fsic.js') --}}
@endsection
