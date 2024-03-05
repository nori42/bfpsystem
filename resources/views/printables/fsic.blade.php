@extends('layouts.print')

@php
    $personName = null;

    if ($establishment->owner->last_name != null) {
        $personName = $establishment->owner->first_name . ' ' . $establishment->owner->last_name;
    }

    $corporateName = $establishment->owner->corporate_name;
    $registrationStatus = $inspection->registration_status;

    $details = [
        'dateToday' => date('F d, Y'),
        'inspection' => $inspection,
        'expiryDate' => date('F d, Y', strtotime('+1 year')),
        'dateOfPayment' => date('m/d/Y', strtotime($inspection->receipt->date_of_payment)),
    ];

    // OTHERS OPTION
    if (
        $inspection->registration_status == 'NEW' ||
        $inspection->registration_status == 'RENEWAL' ||
        $inspection->registration_status == 'OCCUPANCY'
    ) {
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

    @if ($inspection->status == 'Not Printed')
        <form class="m-0 d-none" id="print" action="{{ $inspection->id }}" method="POST" btndone>
            @csrf
            @method('PUT')
            <input type="hidden" name="othersDescrpt" others="input">
            <input type="hidden" name="validForDescrpt1" descrptInp1>
            <input type="hidden" name="validForDescrpt2" descrptInp2>
            <button class="btn btn-success" data-server-action>Done<i class="bi bi-check-lg"></i></button>
        </form>
    @else
        <a class="btn btn-success d-none" href="/establishments/{{ $inspection->establishment_id }}/fsic" btndone>Done <i
                class="bi bi-check-lg"></i></a>
    @endif
@endsection

@section('printTools')
    @if ($inspection->status != 'Printed' && $inspection->status != 'Error')
        <div class="printTools d-flex flex-column p-3 bg-white rounded-3 gap-2" printtools>
            <button class="btn btn-primary" id="btnAddNote" toggled="false">Add Description</button>
        </div>


        <div class="text-tools p-3 bg-white rounded-3 d-none" data-text-tools>
            <div class="fs-5">Text Tools</div>
            <div class="d-flex align-items-center gap-3">
                <label class="form-label fw-bold" for="fontSize">Font Size</label>
                <select class="form-select" name="fontSize" id="fontSize" onchange="fontSizeChange()">
                    <option value="" selected disabled>Choose Font Size</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                </select>
            </div>
        </div>
    @endif
@endsection

@section('printablePage')
    {{-- This will determined if the print certificate will show or not --}}
    <input type="checkbox" id="isPreview"
        {{ ($inspection->issued_on != null && $inspection->status == 'Printed') || $inspection->status == 'Error' ? 'checked' : '' }}
        hidden>

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
                                {{ $inspection->issued_for }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span data-text-editable>{{ $inspection->establishment->establishment_name }}</span>
        </div>
        <div data-draggable="true" class="rep-name bold">
            <span data-text-editable>{{ $establishment->getOwnerBoth() }}</span>

        </div>
        <div data-draggable="true" class="address bold">
            @if (strlen($establishment->address) >= 76 && strlen($establishment->address) < 80)
                <span class="fs-9pt" data-text-editable>{{ $establishment->address }}</span>
            @elseif (strlen($establishment->address) >= 86 && strlen($establishment->address) < 96)
                <span class="fs-8pt" data-text-editable>{{ $establishment->address }}</span>
            @else
                <span data-text-editable>{{ $establishment->address }}</span>
            @endif
        </div>

        <div class="more-info bold" data-draggable="true" data-editable descrpt1>
            <span>
                {{-- Add Space --}}
                @for ($i = 0; $i < 3; $i++)
                    &nbsp;
                @endfor
                @if ($inspection->valid_for_descrpt == null)
                    {{ $inspection->issued_for }}
                @endif
            </span>

            <span>{{ $inspection->valid_for_descrpt }}</span>
        </div>
        <div class="more-info more-info-2 bold" data-draggable="true" data-editable descrpt1>
            <span>{{ $inspection->valid_for_descrpt2 }}</span>
        </div>
        <div data-draggable="true" class="validity bold">
            @if ($inspection->registration_status == 'OCCUPANCY')
                <span>Not Applicable</span>
            @else
                <span>{{ $inspection->expiry_date == null ? $details['expiryDate'] : date('m/d/Y', strtotime($inspection->expiry_date)) }}</span>
            @endif
        </div>

        <div data-draggable="true" class="fc-fee bold">
            <div><span id="amount">{{ $inspection->receipt->amount }}</span></div>
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
