@extends('layouts.print')

@php
    $receipt = $buildingPlan->receipt;

    $evaluator = auth()->user()->personnel->first_name . ' ' . auth()->user()->personnel->last_name;

    $representative = $buildingPlan->getOwnerName();

    //Marshal and Chief Name
    $json = resource_path('json\printSettings.json');
    $jsonData = File::get($json);
    $printSettings = json_decode($jsonData, true);
    ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
@endphp

@section('stylesheet')
    @vite('resources/css/pages/printables/fsec.css')
@endsection

@section('issuedFor')
    {{-- PUT LITELAR STRING HERE NO TAGS --}}
    Fire Safety Evaluation Clearance
@endsection

@section('btngroup')
    <a class="btn btn-secondary" href="/fsec/{{ $buildingPlan->id }}" btnback>Back</a>

    <form class="d-none m-0" id="print" action="/fsec/print/{{ $buildingPlan->id }}" method="POST" btndone>
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $evaluator }}" name="evaluator">
        <input type="hidden" id="fsec_no" name="fsec_no">
        <button class="btn btn-success">Done<i class="bi bi-check-lg"></i></button>
    </form>
    {{-- <a class="btn btn-success d-none" href="/fsec/{{ $buildingPlan }}" btndone>Done <i class="bi bi-check-lg"></i></a> --}}
@endsection

@section('printTools')
    @if ($buildingPlan == null)
        <div class="printTools p-4 bg-white">

            <label for="fsec" class="fw-bold">FSEC NO.</label>
            <br>
            <input class="form-control border-black text-uppercase" type="text" name="fsec" id="fsec">
        </div>
    @endif
@endsection

@section('printablePage')
    <input type="checkbox" id="isPreview" {{ $buildingPlan->date_approved != null ? 'checked' : '' }} hidden>

    <div class="printablePage">
        <div data-draggable="true" class="header bold">
            <div>Cebu City Fire Office</div>
            <div>N. Bacalso Avenue, Pahina Central, Cebu City</div>
            <div>Tel. Nos. (032) - 256-0544 / 262-3110</div>
            <div>Email Address: cebucityfsn@yahoo.com</div>
        </div>

        <div data-draggable="true" class="fsec-no bold">
            {{ $buildingPlan->fsec_no }}
        </div>

        <div data-draggable="true" class="date-container bold">
            {{ $buildingPlan->date_approved ? date('F d Y', strtotime($buildingPlan->date_approved)) : date('F d Y') }}

        </div>

        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $buildingPlan->name_of_building }}</span>
        </div>

        <div data-draggable="true" class="address bold">
            <span>{{ $buildingPlan->address }}</span>
        </div>

        <div data-draggable="true" class="rep-name bold">
            <span>{{ $representative }}</span>
        </div>

        <div data-draggable="true" class="fc-fee">
            <div id="amount">{{ $receipt->amount }}</div>
            <div id="or_no">{{ $receipt->or_no }}</div>
            <div id="date">{{ date('m/d/Y', strtotime($receipt->date_of_payment)) }}</div>
        </div>

        <div class="plan-evaluator fw-bolder text-center">
            @php
                $first_name = auth()->user()->personnel->first_name;
                $first_name_lower = Str::lower($first_name);
                $last_name = auth()->user()->personnel->last_name;
                $last_name_lower = Str::lower($last_name);
            @endphp
            <div><span contenteditable="true">Eng`r.</span> {{ Str::ucfirst($first_name_lower) }}
                {{ Str::ucfirst($last_name_lower) }}</div>
            <div>Plans Evaluator</div>
        </div>

        <div data-draggable="true" id="chiefName" class="chiefName fw-bolder">{{ $chief }}</div>
        <div data-draggable="true" id="marshalName" class="marshalName fw-bolder">{{ $marshal }}</div>
    </div>
@endsection

@section('pagescript')
    <script defer src="{{ Vite::asset('resources/js/pages/printables/fsec.js') }}"></script>
@endsection
