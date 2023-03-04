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
    </div>

    <script>
        document.getElementById("buttonContainer").addEventListener("click", function(){
            window.print();
        })
    </script>

    <div id="printablePage">
        <div class="header bold">
            <ul>
                <li>Cebu City Fire Office</li>
                <li>N. Bacalso Avenue, Pahina Central, Cebu City</li>
                <li>Tel. Nos. (032) - 256-0544 / 2623110</li>
                <li>Email Address: cebucityfsn@yahoo.com</li>
            </ul>
        </div>

        <div class="date-container bold">
            <li class="fs-12 float-right">{{$details->created_at}}</li>
        </div>

        <div class="check-container">
            <ul class="check">
                @if($details->status == "OCCUPANCY" )
                    <li class="c-1">&check;</li>
                @elseif($details->status == "NEW" || $details->status == "RENEWAL")
                    <li class="c-2">&check;</li>
                @else
                    <li class="c-3">&check;</li>
                @endif
            </ul>
            <div class="highlight">
                @if($details->status == "NEW")
                    <div class="new"></div>
                    <div class="renewal disable"></div>
                @endif
                @if($details->status == "RENEWAL")
                <div class="new disable"></div>
                <div class="renewal"></div>   
                @endif
            </div>
            <div class="others bold">
                @if($details->status != "NEW" && $details->status != "RENEWAL" && $details->status != "OCCUPANCY")
                    {{ $details->issued_for }}
                @endif
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
        <div class="more-info bold">
            <div class="moreInfo">
                <span>MORE DETAILS HERE</span>
            </div>
            <div class="validity">
                <span>{{$details->expiry_date}}</span>
            </div>
        </div>
        
        <div class="footer bold">
            <div class="left">
                <div id="amount">{{$details->amount_paid}}.00</div>
                <div id="or_no">{{$details->or_no}}</div>
                <div id="date">{{$details->date_of_payment}}</div>
            </div>
            <div class="right">
                <div id="chiefName">SP04 Philip K Layug, BFP</div>
                <div id="marshalName">SUPT REYNALDO D ENOC, BFP</div>
            </div>
        </div>
    </div>
</body>
</html>