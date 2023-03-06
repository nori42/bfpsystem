<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/print.css">
    <link rel="stylesheet" href="/css/googlefonts.css">
</head>
<body>
    <div class="nav">
        <a id="back" href="/establishments/fsic/payment/{{$id}}">
            Back
        </a>
        <div id="buttonContainer">
            Print Certificate
            <button id="printBtn"><span class="material-symbols-outlined print-ico">print</span></button>
        </div>
        <div class="printby">
            <strong>Establishment: </strong> <span>{{$details->establishment_name }}</span>
        </div>
        <div class="printby">
            <strong>Owned By: </strong> <span>{{$details->first_name}} {{$details->last_name}} </span>
        </div>
        <div class="printby">
            <strong>Issued For: </strong> <span>{{$details->issued_for}}</span>
        </div>
        <div class="printby">
            <strong>Printing as: </strong> <span>Admin</span>
        </div>
        <button id="showCert" onclick="showCert()">Show Cert</button>
    </div>

    <div id="printablePage">
        <div class="header bold">
                <div>Cebu City Fire Office</div>
                <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
                <div>Tel. Nos. (032) - 256-0544 / 2623110</div>
                <div>Email Address: cebucityfsn@yahoo.com</div>
        </div>

        <div class="date-container bold">
            {{$details->created_at}}
        </div>

        

        <div class="check-container">
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
                        @if($details->status != "NEW" && $details->status != "RENEWAL" && $details->status != "OCCUPANCY")
                            {{ $details->issued_for }}
                        @endif
                        Hello
                    </div>
                </div>
        </div>

        <div class="establishment-name bold">
            <span>{{$details->establishment_name}}</span>
        </div>
        <div class="rep-name bold">
            <span>{{$details->first_name}} {{$details->middle_name}} {{$details->last_name}}</span>
        </div>
        <div class="address bold">
            <span>{{$details->address}}</span>
        </div>
        
        <div class="issued-for bold">
            <span>{{$details->issued_for}} </span>
        </div>

        <div class="more-info">
            <span>MORE DETAILS HERE</span>
        </div>

        <div class="validity">
            <span>{{$details->expiry_date}}</span>
        </div>

        <div class="fc-fee">
            <div id="amount">{{$details->amount_paid}}.00</div>
            <div id="or_no">{{$details->or_no}}</div>
            <div id="date">{{$details->date_of_payment}}</div>
        </div>

        <div id="chiefName" class="chiefName">SP04 Philip K Layug, BFP</div>
        <div id="marshalName" class="marshalName">SUPT REYNALDO D ENOC, BFP</div>
    </div>

    
    <script src="/js/print.js"></script>
</body>
</html>