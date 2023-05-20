<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="/css/printfsec.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>
@php
    $person = $buildingPlan->owner->person;
    $corporate = $buildingPlan->owner->corporate;
    $receipt = $buildingPlan->receipt;
    
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
    <form id="print" action="/fsec/print/{{ $buildingPlan->id }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $evaluator }}" name="evaluator">
    </form>

    <div class="editToolBox">
        <button class="btnTools" id="btnCert" onclick="toggleCert(this)">Hide Certifcate</button>
        <button class="btnTools" id="btnEdit" onclick="handleEdit(this)" style="display: none;">Edit</button>
        <button class="btnTools" id="btnMove" onclick="handleMove(this)">Move</button>
    </div>

    <div class="nav">
        <a id="back" href="/fsec/{{ $buildingPlan->id }}">
            Back
        </a>
        <button id="printBtn">
            <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                style="background-color: #FFC900;">print</span>
        </button>

        <div class="printby">
            <strong>Issued For: </strong> <span>FSEC</span>
        </div>

        <div class="printby">
            <strong>Printing as: </strong> <span>{{ auth()->user()->type }} User</span>
        </div>
    </div>

    <div id="printablePage">
        <div data-draggable="true" class="header bold">
            <div>REGIONAL OFFICE - VII</div>
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
            <span>{{ $buildingPlan->building->address }}</span>
        </div>

        <div data-draggable="true" class="rep-name bold">
            <span>{{ $representative }}</span>
        </div>

        <div data-draggable="true" class="fc-fee">
            <div id="amount">{{ $receipt->amount }}</div>
            <div id="or_no">{{ $receipt->or_no }}</div>
            <div id="date">{{ date('m/d/Y', strtotime($receipt->date_of_payment)) }}</div>
        </div>

        <div data-draggable="true" id="chiefName" class="chiefName">SP04 Philip K Layug, BFP</div>
        <div data-draggable="true" id="marshalName" class="marshalName">SUPT REYNALDO D ENOC, BFP</div>
    </div>


    <script src="/js/print.js"></script>
</body>

</html>
