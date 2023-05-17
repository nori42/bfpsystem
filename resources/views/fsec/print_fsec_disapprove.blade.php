<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Firedrill</title>
    <link rel="stylesheet" href="/css/printfsecdisapprove.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>

<body>
    <form id="print" action="#" method="POST">
        @csrf
        @method('PUT')
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
        <a id="back" href="#">
            Back
        </a>
        <button id="printBtn">
            <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                style="background-color: #FFC900;">print</span>
        </button>
        <div class="printby">
            <strong>Establishment: </strong> <span></span>
        </div>
        <div class="printby">
            <strong>Owned By: </strong> <span> </span>
        </div>
        <div class="printby">
            <strong>Issued For: </strong> <span>FSEC Disapprove</span>
        </div>
        <div class="printby">
            <strong>Printing as: </strong> <span>{{ auth()->user()->type }}</span>
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
            R-7 013-S'2023
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>Sample</span>
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name-2 bold">
            <span>Sample 2</span>
        </div>

        <div data-draggable="true" class="rep-name bold">
            <span>Sample Name</span>
        </div>
        <div data-draggable="true" class="address bold">
            <span>Looc Norte, Asturias, Cebu</span>
        </div>

        <div data-draggable="true" class="address-2 bold">
            <span>Looc Norte, Asturias, Cebu</span>
        </div>


        <div data-draggable="true" class="fc-fee bold">
            <div id="amount"></div>
            <div id="or_no"></div>
            <div id="date"></div>
        </div>

        {{-- <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">SFO4 Philip K Layug, BFP
        </div> --}}

        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">SUPT REYNALDO D ENOC,
            BFP</div>
    </div>


    <script src="/js/print.js"></script>
</body>

</html>
