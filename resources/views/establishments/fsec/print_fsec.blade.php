<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FSEC</title>
    <link rel="stylesheet" href="/css/printfsec.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>
<body>
    <div class="editToolBox">
        <button class="btnTools" id="btnCert" onclick="toggleCert(this)">Hide Certifcate</button>
        <button class="btnTools" id="btnEdit" onclick="handleEdit(this)">Edit</button>
        <button class="btnTools" id="btnMove" onclick="handleMove(this)">Move</button>
    </div>

    <div class="nav">
        <a id="back" href="/establishments/fsec/{{$evaluation->establishment->id}}">
            Back
        </a>
        <button id="printBtn"><div>Print Certificate</div><span class="material-symbols-outlined print-ico" style="background-color: #FFC900;">print</span></button>
        <div class="printby">
            <strong>Establishment: </strong> <span>{{$evaluation->establishment->establishment_name }}</span>
        </div>
        <div class="printby">
            <strong>Owned By: </strong> <span>{{$evaluation->establishment->owner->first_name}} {{$evaluation->establishment->owner->last_name}} </span>
        </div>
        <div class="printby">
            <strong>Printing as: </strong> <span>Admin</span>
        </div>
    </div>

    <div id="printablePage">
        <div data-draggable="true" class="header bold">
                <div>REGIONAL OFFICE - VII</div>
                <div>Cebu City Fire Station</div>
                <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
                <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
                <div>Email Address: cebucityfsn@yahoo.com</div>
        </div>

        <div data-draggable="true" class="date-container bold">
            {{date('F d Y', strtotime($evaluation->date_release))}}
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{$evaluation->establishment->establishment_name}}</span>
        </div>

        <div data-draggable="true" class="address bold">
            <span>{{$evaluation->establishment->address}}</span>
        </div>

        <div data-draggable="true" class="rep-name bold">
            <span>{{$evaluation->establishment->owner->first_name}} {{$evaluation->establishment->owner->middle_name}} {{$evaluation->establishment->owner->last_name}}</span>
        </div>

        <div data-draggable="true" class="fc-fee">
            <div id="amount">{{$evaluation->amount_paid}}.00</div>
            <div id="or_no">{{$evaluation->or_no}}</div>
            <div id="date">{{date('m/d/Y', strtotime($evaluation->date_of_payment))}}</div>
        </div>

        <div data-draggable="true" id="chiefName" class="chiefName">SP04 Philip K Layug, BFP</div>
        <div data-draggable="true" id="marshalName" class="marshalName">SUPT REYNALDO D ENOC, BFP</div>
    </div>

    
    <script src="/js/print.js"></script>
</body>
</html>