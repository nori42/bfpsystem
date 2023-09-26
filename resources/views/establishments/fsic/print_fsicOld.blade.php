<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    {{-- <link rel="stylesheet" href="/css/printutilities.css"> --}}
    <link rel="stylesheet" href="/css/printfsic.css">
    {{-- @vite(['resources/css/printfsic.css']) --}}
    @vite(['resources/css/bootstrap-icons.css'])
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>
@php
    $personName = null;
    
    if ($establishment->owner->person->last_name != null) {
        $personName = $establishment->owner->person->first_name . ' ' . $establishment->owner->person->last_name;
    }
    
    $corporateName = $establishment->owner->corporate->corporate_name;
    $registrationStatus = $inspection->registration_status;
    
    $details = [
        'dateToday' => date('F d, Y', time()),
        'inspection' => $inspection,
        'expiryDate' => date('F d, Y', strtotime('+1 year')),
        'dateOfPayment' => date('m/d/Y', strtotime($inspection->receipt->date_of_payment)),
    ];
    
    $json = resource_path('json\printSettings.json');
    $jsonData = File::get($json);
    $printSettings = json_decode($jsonData, true);
    ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
@endphp

<body>

    <form id="print" action="{{ $inspection->id }}" method="POST">
        @csrf
        @method('PUT')
    </form>

    @if ($inspection->issued_on == null)
        <div class="editToolBox">
            <button class="btnTools button" id="btnCert" onclick="toggleCert(this)">Hide Certifcate</button>
            <button class="btnTools button" id="btnEdit" onclick="handleEdit(this)">Add Note</button>
            {{-- <button class="btnTools button" id="btnMove" onclick="handleMove(this)">Move</button> --}}
        </div>
    @endif

    <div class="nav">
        <a id="back" href="/establishments/{{ $establishment->id }}/fsic">
            Back
        </a>
        @if ($inspection->issued_on == null)
            <button id="printBtn" class="button" onclick="printOnly(printCert)">
                <div>Print Certificate</div><span class="material-symbols-outlined print-ico"
                    style="background-color: #FFC900;">print</span>
            </button>
        @endif
        <div class="printby">
            <strong>Issued For: </strong> <span>{{ $inspection->registration_status }}</span>
        </div>
        <button id='btnDone' class="btn-done d-none" onclick="printDone()">Done &#10004;</button>
    </div>
    <div id="printablePage">
        <div data-draggable="true" class="header bold">
            <div>Cebu City Fire Office</div>
            <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
            <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
            <div>Email Address: cebucityfsn@yahoo.com</div>
        </div>

        @if ($inspection->issued_on != null)
            <div data-draggable="true" class="fsic-no bold">
                {{ $inspection->fsic_no }}
            </div>
        @endif

        <div data-draggable="true" class="date-container bold">
            {{ $inspection->issued_on == null ? $details['dateToday'] : date('F d, Y', strtotime($inspection->issued_on)) }}
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

            <div class="c-1 check {{ $registrationStatus == 'OCCUPANCY' ? '' : 'hidden' }}" id="c1">
                &#x2714;
            </div>

            <div class="c-2 {{ $registrationStatus == 'NEW' || $registrationStatus == 'RENEWAL' ? '' : 'hidden' }}"
                id="c2">
                <div class="check">&#x2714;</div>
                <div class="highlight-container">
                    <div id="new" class="highlight {{ $registrationStatus == 'NEW' ? '' : 'hidden' }}"></div>
                    <div id="renewal" class="highlight {{ $registrationStatus == 'RENEWAL' ? '' : 'hidden' }}">
                    </div>
                </div>
            </div>

            <div class="c-3 hidden" id="c3">
                <div class="check">&#x2714;</div>
                <div class="others bold">
                    {{-- @if ($details->status != 'NEW' && $details->status != 'RENEWAL' && $details->status != 'OCCUPANCY')
                        {{ $details->issued_for }}
                    @endif --}}
                    {{-- {{ $inspection->issued_for }} --}}
                    <div data-draggable="true" data-editable="true" class="others-info">
                        <span>&nbsp; </span>
                    </div>
                </div>
            </div>
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $inspection->establishment->establishment_name }}</span>
        </div>
        <div data-draggable="true" class="rep-name bold">
            <span>{{ $personName ? $personName : $corporateName }}</span>

        </div>
        <div data-draggable="true" class="address bold">
            @if (strlen($establishment->address) >= 63 && strlen($establishment->address) < 76)
                <span class="fs-9pt">{{ $establishment->address }}</span>
            @elseif (strlen($establishment->address) >= 76 && strlen($establishment->address) < 80)
                <span class="fs-8pt">{{ $establishment->address }}</span>
            @else
                <span>{{ $establishment->address }}</span>
            @endif
        </div>

        <div class="more-info bold" data-draggable="true" data-editable="true">
            <span>&nbsp;</span>
        </div>
        <div class="more-info more-info-2 bold" data-draggable="true" data-editable="true">
            <span>&nbsp;</span>
        </div>
        <div data-draggable="true" class="validity bold">
            <span>{{ $inspection->expiry_date == null ? $details['expiryDate'] : date('F d, Y', strtotime($inspection->expiry_date)) }}</span>
        </div>

        <div data-draggable="true" class="fc-fee bold">
            <div id="amount">{{ $inspection->receipt->amount }}</div>
            <div id="or_no">{{ $inspection->receipt->or_no }}</div>
            <div id="date">{{ $details['dateOfPayment'] }}</div>
        </div>

        <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">{{ $chief }}
        </div>
        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">
            {{ $marshal }}
        </div>
    </div>


    <script src="/js/print.js"></script>
    <script>
        function printCert() {
            document.querySelector('#back').remove()
            document.querySelector('#btnDone').classList.remove('d-none')
        }
    </script>
    {{-- Disable print if already printed --}}
    @if ($inspection->issued_on != null)
        <script>
            window.addEventListener("beforeprint", (event) => {
                const printPage = document.querySelector("#printablePage");
                printPage.innerHTML =
                    `<h1 class="text-center">Print is not allowed. Reload the page to re-view print</h1>`;
                console.log(getComputedStyle(printPage));
                printPage.style.background = "none";

            });
        </script>
    @endif
</body>

</html>
