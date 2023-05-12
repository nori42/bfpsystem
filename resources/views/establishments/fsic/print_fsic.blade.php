<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="/css/printfsic.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>

<body>
    <form id="print" action="{{ $inspection->id }}" method="POST">
        @csrf
        @method('PUT')
    </form>
    <div class="editToolBox">
        <button class="btnTools" id="btnCert" onclick="toggleCert(this)">Hide Certifcate</button>
        <button class="btnTools" id="btnEdit" onclick="handleEdit(this)">Add Note</button>
        <button class="btnTools" id="btnMove" onclick="handleMove(this)">Move</button>
    </div>

    <div class="nav">
        <a id="back" href="/establishments/{{ $establishment->id }}/fsic">
            Back
        </a>
        <button id="printBtn">
            <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                style="background-color: #FFC900;">print</span>
        </button>
        <div class="printby">
            <strong>Establishment: </strong> <span>{{ $establishment->establishment_name }}</span>
        </div>
        <div class="printby">
            <strong>Owned By: </strong> <span>{{ $details['personName'] }} </span>
        </div>
        <div class="printby">
            <strong>Issued For: </strong> <span>{{ $inspection->issued_for }}</span>
        </div>
        <div class="printby">
            <strong>Printing as: </strong> <span>{{ auth()->user()->type }}</span>
        </div>
    </div>

    <div id="printablePage">
        <div data-draggable="true" class="header bold">
            <div>Cebu City Fire Office</div>
            <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
            <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
            <div>Email Address: cebucityfsn@yahoo.com</div>
        </div>

        <div data-draggable="true" class="date-container bold">
            {{ $details['dateToday'] }}
        </div>



        <div data-draggable="true" class="check-container">
            <div class="checkbox-container">
                <div class="checkBox c1" onclick="checkToggle('c1')"></div>
                <div class="checkBox c2" onclick="checkToggle('c2')"></div>
                <div class="checkBox c3" onclick="checkToggle('c3')"></div>
            </div>

            <div class="highlight-button-container">
                <div class="highlight-new" onclick="checkToggle('new')"></div>
                <div class="highlight-renewal" onclick="checkToggle('renewal')"></div>
            </div>

            <div class="c-1 check hidden" id="c1">&check;</div>

            <div class="c-2 check hidden" id="c2">
                <div>&check;</div>
                <div class="highlight-container">
                    <div id="new" class="highlight hidden"></div>
                    <div id="renewal" class="highlight hidden"></div>
                </div>
            </div>

            <div class="c-3 check hidden" id="c3">
                <div>&check;</div>
                <div class="others bold">
                    {{-- @if ($details->status != 'NEW' && $details->status != 'RENEWAL' && $details->status != 'OCCUPANCY')
                        {{ $details->issued_for }}
                    @endif --}}
                    {{-- {{ $inspection->issued_for }} --}}
                    <div data-draggable="true" data-editable="true" class="others-info">
                        <span>&nbsp;</span>
                    </div>
                </div>
            </div>
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $inspection->establishment->establishment_name }}</span>
        </div>
        <div data-draggable="true" class="rep-name bold">
            <span>{{ $details['personName'] != null ? $details['personName'] : $details['corporateName'] }}</span>
        </div>
        <div data-draggable="true" class="address bold">
            <span>{{ $establishment->address }}</span>
        </div>

        <div data-draggable="true" class="issued-for bold">
            <span>{{ $inspection->issued_for }} </span>
        </div>

        <div data-draggable="true" data-editable="true" class="more-info" id="moreInfo">
            <span>&nbsp;</span>
        </div>

        <div data-draggable="true" class="validity bold">
            <span>{{ $details['expiryDate'] }}</span>
        </div>

        <div data-draggable="true" class="fc-fee bold">
            <div id="amount">{{ $inspection->receipt->amount }}.00</div>
            <div id="or_no">{{ $inspection->receipt->or_no }}</div>
            <div id="date">{{ $details['dateOfPayment'] }}</div>
        </div>

        <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">SFO4 Philip K Layug, BFP
        </div>
        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">SUPT REYNALDO D ENOC,
            BFP</div>
    </div>


    <script src="/js/print.js"></script>
</body>

</html>
