@extends('layouts.print')

@php

    // if (auth()->user()->type != 'ADMINISTRATOR') {
    //     $personnelName = auth()->user()->personnel->person->first_name . ' ' . auth()->user()->personnel->person->last_name;
    // }
    $evaluator = $evaluator = auth()->user()->personnel->first_name . ' ' . auth()->user()->personnel->last_name;

    $representative = $buildingPlan->getOwnerName();

    $json = resource_path('json\printSettings.json');
    $jsonData = File::get($json);
    $printSettings = json_decode($jsonData, true);
    ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
@endphp

@section('stylesheet')
    @vite('resources/css/pages/printables/fsec_disapprove.css')
@endsection

@section('issuedFor')
    {{-- PUT LITELAR STRING HERE NO TAGS --}}
    Fire Safety Evaluation Clearance Disapproval
@endsection
@section('btngroup')
    <a class="btn btn-secondary" href="/fsec/{{ $buildingPlan->id }}" btnback>Back</a>

    <form class="m-0 d-none" id="print" action="/fsecdisapprove/print/{{ $buildingPlan->id }}" method="POST" btndone>
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $evaluator }}" name="evaluator">
        <input type="hidden" value="" name="pdfInput" id="pdfInput">
        <button class="btn btn-success">Done<i class="bi bi-check-lg"></i></button>
    </form>
    {{-- <a class="btn btn-success d-none" href="/fsec/{{ $buildingPlan }}" btndone>Done <i class="bi bi-check-lg"></i></a> --}}
@endsection

@section('printTools')
@endsection

@section('printablePage')
    <div class="printablePage">
        {{-- <div data-draggable="true" class="header bold">
        <div>Cebu City Fire Office</div>
        <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
        <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
        <div>Email Address: cebucityfsn@yahoo.com</div>
    </div> --}}

        <div data-draggable="true" class="date-container bold">
            {{ date('F d, Y') }}
        </div>
        <img class="certificate" src="{{ asset('img/fsec_disapprove.png') }}" alt=""
            style="width: 100%; height: 100%;">

        <div data-draggable="true" class="series-no bold" contenteditable="true">
            {{ $buildingPlan->series_no }}
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span class="fs-9pt">{{ $buildingPlan->name_of_building }}</span>
        </div>

        <div data-draggable="true" id="estabName2" class="establishment-name-2 bold">
            <span class="fs-9pt">{{ $buildingPlan->name_of_building }}</span>
        </div>

        <div data-draggable="true" class="rep-name bold">
            <span class="fs-9pt">{{ $representative }}</span>
        </div>

        {{-- <div class="deficiency" id="moreInfo" data-draggable="true" data-editable="true">
    </div>
    <div class="deficiency deficiency-right" id="moreInfo" data-draggable="true" data-editable="true">
    </div> --}}
        {{-- <textarea class="deficiency" maxlength="288" rows="7" cols="30"></textarea> --}}
        {{-- <textarea class="deficiency deficiency-right" maxlength="288" rows="7" cols="30"></textarea> --}}
        <div class="deficiency" contenteditable="true" deficiency="1">
            <div class="w-100 h-100">

            </div>
        </div>
        <div class="deficiency deficiency-right" contenteditable="true" deficiency="2">
        </div>

        <div data-draggable="true" class="address">
            <span class="fs-9pt fw-bold">{{ $buildingPlan->address }}</span>
        </div>

        <div data-draggable="true" class="establishment-name-2 bold">
            <span class="fs-9pt">{{ $buildingPlan->name_of_building }}</span>
        </div>

        <div data-draggable="true" class="address-2 bold">
            <span class="fs-9pt">{{ $buildingPlan->address }}</span>
        </div>


        {{-- <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">SFO4 Philip K Layug, BFP
    </div> --}}

        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">{{ $marshal }}
        </div>
    </div>
@endsection

@section('pagescript')
    @vite('resources/js/pages/printables/fsec_disapprove.js')
@endsection
