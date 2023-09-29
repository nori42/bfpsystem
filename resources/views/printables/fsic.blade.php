@extends('layouts.print')

@php
    $personName = null;
    
    if ($establishment->owner->last_name != null) {
        $personName = $establishment->owner->first_name . ' ' . $establishment->owner->last_name;
    }
    
    $corporateName = $establishment->owner->corporate_name;
    $registrationStatus = $inspection->registration_status;
    
    $details = [
        'dateToday' => date('F d, Y', time()),
        'inspection' => $inspection,
        'expiryDate' => date('F d, Y', strtotime('+1 year')),
        'dateOfPayment' => date('m/d/Y', strtotime($inspection->receipt->date_of_payment)),
    ];
    
    // OTHERS OPTION
    if ($inspection->registration_status == 'NEW' || $inspection->registration_status == 'RENEWAL' || $inspection->registration_status == 'OCCUPANCY') {
        $isStatusOthers = false;
    } else {
        $isStatusOthers = true;
    }
    
    $json = resource_path('json\printSettings.json');
    $jsonData = File::get($json);
    $printSettings = json_decode($jsonData, true);
    ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
@endphp

@section('stylesheet')
    @vite('resources/css/pages/printables/fsic.css')
@endsection

@section('issuedFor')
    {{-- PUT LITELAR STRING HERE NO TAGS --}}
    {{ $inspection->registration_status }}
@endsection

@section('btngroup')
    <a class="btn btn-secondary" href="/establishments/{{ $inspection->establishment_id }}/fsic" btnback>Back</a>

    @if ($inspection->issued_on == null)
        <form class="m-0 d-none" id="print" action="{{ $inspection->id }}" method="POST" btndone>
            @csrf
            @method('PUT')
            <input type="hidden" name="othersDescrpt" others="input">
            <input type="hidden" name="validForDescrpt1" descrptInp1>
            <input type="hidden" name="validForDescrpt2" descrptInp2>
            <button class="btn btn-success">Done<i class="bi bi-check-lg"></i></button>
        </form>
    @else
        <a class="btn btn-success d-none" href="/establishments/{{ $inspection->establishment_id }}/fsic" btndone>Done <i
                class="bi bi-check-lg"></i></a>
    @endif
@endsection

@section('printTools')
    @if ($inspection->issued_on == null)
        <div class="printTools d-flex flex-column p-3 bg-white rounded-3 gap-2" printtools>
            <button class="btn btn-primary" id="btnAddNote" toggled="false">Add Description</button>
        </div>
    @endif
@endsection

@section('printablePage')
    <input type="checkbox" id="isPreview" {{ $inspection->issued_on != null ? 'checked' : '' }} hidden>

    <div class="printablePage">
        <div data-draggable="true" class="header bold">
            Cebu City Fire Office <br>
            N. Bacalso Avenue, Pahina Central, Cebu City <br>
            Tel. Nos. (032) - 256-0544 / 262-3110 <br>
            Email Address: cebucityfsn@yahoo.com <br>
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
                <div class="checkBox c1" checkboxtoggle="1"></div>
                <div class="checkBox c2" checkboxtoggle="2"></div>
                <div class="checkBox c3" checkboxtoggle="3"></div>
            </div>

            <div class="c-1 check {{ $registrationStatus == 'OCCUPANCY' ? '' : 'hidden' }}" checkbox="1">
                &#x2714;
            </div>

            <div class="c-2 {{ $registrationStatus == 'NEW' || $registrationStatus == 'RENEWAL' ? '' : 'hidden' }}"
                checkbox="2">
                <div class="check">&#x2714;</div>
                <div class="highlight-container">
                    <div id="new" class="{{ $registrationStatus == 'NEW' ? 'highlight' : '' }}" highlightable></div>
                    <div id="renewal" class="{{ $registrationStatus == 'RENEWAL' ? 'highlight' : '' }}" highlightable>
                    </div>
                </div>
            </div>

            <div class="c-3 {{ $isStatusOthers ? '' : 'hidden' }}" checkbox="3">
                <div class="check">&#x2714;</div>
                <div class="others bold">
                    <div data-draggable="true" data-editable class="others-info" others="descrpt">
                        <span>
                            @if ($isStatusOthers && $inspection->others_descrpt == null)
                                {{ $inspection->registration_status }}
                            @endif
                            @if ($inspection->others_descrpt != null)
                                {{ $inspection->others_descrpt }}
                            @endif
                        </span>
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

        <div class="more-info bold" data-draggable="true" data-editable descrpt1>
            <span>{{ $inspection->valid_for_descrpt }}</span>
        </div>
        <div class="more-info more-info-2 bold" data-draggable="true" data-editable descrpt1>
            <span>{{ $inspection->valid_for_descrpt2 }}</span>
        </div>
        <div data-draggable="true" class="validity bold">
            <span>{{ $inspection->expiry_date == null ? $details['expiryDate'] : date('F d, Y', strtotime($inspection->expiry_date)) }}</span>
        </div>

        <div data-draggable="true" class="fc-fee bold">
            <div id="amount">{{ $inspection->receipt->amount }}</div>
            <div id="or_no">{{ $inspection->receipt->or_no }}</div>
            <div id="date">{{ $details['dateOfPayment'] }}</div>
        </div>

        <div data-draggable="true" id="chiefName" class="chiefName bold">{{ $chief }}
        </div>
        <div data-draggable="true" id="marshalName" class="marshalName bold">
            {{ $marshal }}
        </div>
    </div>
@endsection

@section('pagescript')
    @vite('resources/js/pages/printables/fsic.js')
@endsection
