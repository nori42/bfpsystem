<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Firedrill</title>
    <link rel="stylesheet" href="/css/printfiredrill.css">
    {{-- <link rel="stylesheet" href="/css/printutilities.css"> --}}
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>

<body>

    <form id="print" action="/establishments/firedrill/print/{{ $firedrillId }}" method="POST">
        @csrf
        @method('PUT')
    </form>
    {{-- <div class="editToolBox">
        <button class="btnTools" id="btnCert" onclick="toggleCert(this)">Hide Certifcate</button>
        <button class="btnTools" id="btnMove" onclick="handleMove(this)">Move</button>
        <button class="btnTools" id="btnEdit" onclick="handleEdit(this)">Add
            Note</button>
    </div> --}}

    <div class="nav">
        <a id="back" href="/establishments/{{ $estabId }}/firedrill">
            Back
        </a>

        <button id="printBtn" onclick="printCert()">
            <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                style="background-color: #FFC900;">print</span>
        </button>
        <div class="printby">
            <strong>Issued For: </strong> <span>Firedrill</span>
        </div>
        @if ($firedrill->issued_on)
            <button id='btnDone' class="btn-done d-none" onclick="back()">Done &#10004;</button>
        @else
            <button id='btnDone' class="btn-done d-none" onclick="submitPrint()">Done &#10004;</button>
        @endif
    </div>

    <div id="printablePage">
        {{-- <div data-draggable="true" class="header bold">
            <div>Cebu City Fire Office</div>
            <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
            <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
            <div>Email Address: cebucityfsn@yahoo.com</div>
        </div> --}}

        <div data-draggable="true" class="date-container bold">
            {{ $firedrill->issued_on ? date('F d, Y', strtotime($firedrill->issued_on)) : date('F d, Y') }}
        </div>
        <img src="{{ asset('img/firedrill.png') }}" alt="" style="width: 100%; height: 100%;">

        <div data-draggable="true" class="control-no bold">
            {{ $controlNo }}
        </div>

        @php
            if (session('nameExtension')) {
                $establishment = $establishment . ' ' . strtoupper(session('nameExtension'));
            }
        @endphp
        <div data-draggable="true" id="estabName" class="establishment-name bold" contenteditable="true">
            <span>{{ $establishment }}</span>
        </div>
        <div data-draggable="true" class="rep-name bold">
            <span>{{ $representative }}</span>
        </div>
        <div data-draggable="true" class="address bold">
            @if (strlen($address) >= 55 && strlen($address) < 63)
                <span class="fs-9pt">{{ $address }}</span>
            @elseif (strlen($address) >= 63 && strlen($address) < 74)
                <span class="fs-7pt">{{ $address }}</span>
            @elseif (strlen($address) >= 74)
                <span class="fs-6pt">{{ $address }}</span>
            @else
                <span>{{ $address }}</span>
            @endif
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
            <div id="amount">{{ $payment['amountPaid'] }}</div>
            <div id="or_no">{{ $payment['orNo'] }}</div>
            <div id="date">{{ $payment['datePayment'] }}</div>
        </div>

        {{-- <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">SFO4 Philip K Layug, BFP
        </div>
        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">SUPT REYNALDO D ENOC,
            BFP</div> --}}
    </div>

    <script src="/js/print.js"></script>
    <script>
        function submitPrint() {
            document.querySelector('#print').submit();
        }

        function back() {
            history.back();
        }

        function printCert() {
            window.print()
            document.querySelector('#back').remove()
            document.querySelector('#btnDone').classList.remove('d-none')
        }
    </script>
</body>

</html>
