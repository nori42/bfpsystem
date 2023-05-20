<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="/css/printfsecdisapprove.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>

@php
    $person = $buildingPlan->owner->person;
    $corporate = $buildingPlan->owner->corporate;
    
    if (auth()->user()->type != 'ADMIN') {
        $personnelName = auth()->user()->personnel->person->first_name . ' ' . auth()->user()->personnel->person->last_name;
    }
    
    $evaluator = auth()->user()->type != 'ADMIN' ? $personnelName : 'ADMIN';
    
    //Person Name
    $middleInitial = $person->middle_name ? $person->middle_name[0] : '';
    $personName = $person->first_name . ' ' . $middleInitial . '. ' . $person->last_name . ' ' . $person->suffix;
    $representative = $person->last_name != null ? $personName : $corporate->corporate_name;
@endphp

<body>
    <form id="print" action="/fsecdisapprove/print/{{ $buildingPlan->id }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $evaluator }}" name="evaluator">
    </form>
    {{-- <div class="editToolBox"> --}}
    {{-- <button class="btnTools" id="btnCert" onclick="toggleCert(this)">Hide Certifcate</button>
        <button class="btnTools" id="btnMove" onclick="handleMove(this)">Move</button> --}}

    {{-- Do Not Delete --}}
    {{-- <button class="btnTools" id="btnEdit" onclick="handleEdit(this)"
                style=" position: fixed; scale: 0; bottom: 0; pointer-events: none;">Add
                Note</button> --}}
    {{-- </div> --}}

    <div class="nav">
        <a id="back" href="/fsec/{{ $buildingPlan->id }}">
            Back
        </a>
        <button id="printBtn">
            <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                style="background-color: #FFC900;">print</span>
        </button>
        <div class="printby">
            <strong>Issued For: </strong> <span>FSEC Disapprove</span>
        </div>
        <div class="printby">
            <strong>Printing as: </strong> <span>{{ auth()->user()->type }} User</span>
        </div>
    </div>

    <div id="printablePage">
        {{-- <div data-draggable="true" class="header bold">
            <div>Cebu City Fire Office</div>
            <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
            <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
            <div>Email Address: cebucityfsn@yahoo.com</div>
        </div> --}}

        <div data-draggable="true" class="date-container bold">
            {{ date('F d, Y') }}
        </div>
        <img src="{{ asset('img/fsec_disapprove.png') }}" alt="" style="width: 100%; height: 100%;">

        <div data-draggable="true" class="series-no bold">
            {{ $buildingPlan->series_no }}
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $buildingPlan->name_of_building }}</span>
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name-2 bold">
            <span>{{ $buildingPlan->name_of_building }}</span>
        </div>

        <div data-draggable="true" class="rep-name bold">
            <span>{{ $representative }}</span>
        </div>
        <div data-draggable="true" class="address bold">
            <span>{{ $buildingPlan->building->address }}</span>
        </div>

        <div data-draggable="true" class="address-2 bold">
            <span>{{ $buildingPlan->building->address }}</span>
        </div>


        {{-- <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">SFO4 Philip K Layug, BFP
        </div> --}}

        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">SUPT REYNALDO D ENOC,
            BFP</div>
    </div>


    <script src="/js/print.js"></script>
</body>

</html>
