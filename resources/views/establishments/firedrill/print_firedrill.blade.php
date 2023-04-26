<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Firedrill</title>
    <link rel="stylesheet" href="/css/printfiredrill.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>

<body>
    <form id="print" action="/establishments/firedrill/print/{{ $firedrillId }}" method="POST">
        @csrf
        @method('PUT')
    </form>
    <div class="editToolBox">
        <button class="btnTools" id="btnCert" onclick="toggleCert(this)">Hide Certifcate</button>
        <button class="btnTools" id="btnMove" onclick="handleMove(this)">Move</button>

        {{-- Do Not Delete --}}
        <button class="btnTools" id="btnEdit" onclick="handleEdit(this)"
            style=" position: fixed; scale: 0; bottom: 0; pointer-events: none;">Add
            Note</button>
    </div>

    <div class="nav">
        <a id="back" href="/establishments/firedrill/{{ $estabId }}">
            Back
        </a>
        <button id="printBtn">
            <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                style="background-color: #FFC900;">print</span>
        </button>
        <div class="printby">
            <strong>Establishment: </strong> <span>{{ $establishment }}</span>
        </div>
        <div class="printby">
            <strong>Owned By: </strong> <span>{{ $representative }} </span>
        </div>
        <div class="printby">
            <strong>Issued For: </strong> <span>Firedrill</span>
        </div>
        <div class="printby">
            <strong>Printing as: </strong> <span>Admin</span>
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


        <div data-draggable="true" class="control-no bold">
            {{ $controlNo }}
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $establishment }}</span>
        </div>
        <div data-draggable="true" class="rep-name bold">
            <span>{{ $representative }}</span>
        </div>
        <div data-draggable="true" class="address bold">
            <span>{{ $address }}</span>
        </div>

        <div data-draggable="true" class="date-made bold">
            <span>{{ date('F d, Y', strtotime($dateMade)) }}</span>
        </div>

        <div data-draggable="true" class="issuedDay bold">
            <span>{{ $issuedOn['day'] }}</span>
        </div>

        <div data-draggable="true" class="issuedMonth bold">
            <span>{{ $issuedOn['month'] }}</span>
        </div>

        <div data-draggable="true" class="validity bold">
            <span>{{ $validity }}</span>
        </div>

        <div data-draggable="true" class="fc-fee bold">
            <div id="amount">{{ $payment['amountPaid'] }}.00</div>
            <div id="or_no">{{ $payment['orNo'] }}</div>
            <div id="date">{{ $payment['datePayment'] }}</div>
        </div>

        {{-- <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">SP04 Philip K Layug, BFP
        </div>
        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">SUPT REYNALDO D ENOC,
            BFP</div> --}}
    </div>


    <script src="/js/print.js"></script>
</body>

</html>
