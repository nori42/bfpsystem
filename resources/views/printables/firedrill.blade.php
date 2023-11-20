@extends('layouts.print')

@php
    $personName = null;
    if ($establishment->owner->last_name != null) {
        $personName = $establishment->owner->first_name . ' ' . $establishment->owner->last_name;
    }
    $corporateName = $establishment->owner->corporate_name;

    $establishment = $firedrill->establishment->establishment_name;
    $address = $firedrill->establishment->address;
    $issuedOn = ['day' => date('jS', strtotime($firedrill->issued_on)), 'month' => date('F', strtotime($firedrill->issued_on))];
    $validity = $firedrill->validity_term . ' ' . $firedrill->year;
    $receipt = $firedrill->receipt;
    $payment = ['orNo' => $receipt->or_no, 'amountPaid' => $receipt->amount, 'datePayment' => date('m/d/Y', strtotime($receipt->date_of_payment))];
@endphp

@section('stylesheet')
    @vite('resources/css/pages/printables/firedrill.css')
@endsection

@section('issuedFor')
    {{-- PUT LITELAR STRING HERE NO TAGS NOT INSIDE A QUOTE --}}
    FIREDRILL
@endsection

@section('btngroup')
    <a class="btn btn-secondary" href="/establishments/{{ $firedrill->establishment_id }}/firedrill" btnback>Back</a>

    @if ($firedrill->issued_on == null)
        <form class="m-0 d-none" id="print" action="/firedrill/print/{{ $firedrill->id }}" method="POST" btndone>
            @csrf
            @method('PUT')
            <input type="hidden" name="newControlNo" value="{{ $controlNo }}">
            <button class="btn btn-success">Done<i class="bi bi-check-lg" name="action" value="print"></i></button>
        </form>
    @else
        <form class="m-0 d-none" id="print" action="/firedrill/print/{{ $firedrill->id }}" method="POST" btndone>
            @csrf
            @method('PUT')
            <button class="btn btn-success" name="action" value="reprint">Done<i class="bi bi-check-lg"
                    name="action"></i></button>
        </form>
        {{-- <a class="btn btn-success d-none" href="/establishments/{{ $firedrill->establishment_id }}/firedrill" btndone>Done
            <i class="bi bi-check-lg"></i></a> --}}
    @endif
@endsection

@section('printTools')
@endsection

@section('printablePage')
    <div class="printablePage">

        <div data-draggable="true" class="date-container bold text-decoration-underline">
            {{ $firedrill->issued_on ? date('F d Y', strtotime($firedrill->issued_on)) : date('F d Y') }}
        </div>
        <img src="{{ asset('img/firedrill.png') }}" alt="" style="width: 100%; height: 100%;">

        <div data-draggable="true" class="control-no bold" contenteditable="true">
            {{ $firedrill->control_no != null ? $firedrill->control_no : $controlNo }}
        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold"
            contenteditable="{{ $firedrill->issued_on == null ? 'true' : 'false' }}">
            <span>{{ $establishment }}</span>
        </div>
        <div data-draggable="true" class="rep-name">
            <span>{{ $personName ? $personName : $corporateName }}</span>
        </div>
        <div data-draggable="true" class="address bold" contenteditable="true">
            @if (strlen($address) >= 63 && strlen($address) < 74)
                <span class="fs-9pt">{{ $address }}</span>
            @elseif (strlen($address) >= 74 && strlen($address) < 85)
                <span class="fs-8pt">{{ $address }}</span>
            @elseif (strlen($address) >= 85)
                <span class="fs-7pt">{{ $address }}</span>
            @else
                <span>{{ $address }}</span>
            @endif
        </div>

        <div data-draggable="true" class="date-made bold">
            <span>{{ date('F d, Y', strtotime($firedrill->date_made)) }}</span>
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
    </div>
@endsection

@section('pagescript')
    @vite('resources/js/pages/printables/firedrill.js')
@endsection
