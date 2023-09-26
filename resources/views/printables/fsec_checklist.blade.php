@extends('layouts.print')

@php
    $person = $buildingPlan->owner->person;
    $corporate = $buildingPlan->owner->corporate;
    $receipt = $buildingPlan->receipt;
    
    // if (auth()->user()->type != 'ADMINISTRATOR') {
    //     $personnelName = auth()->user()->personnel->first_name . ' ' . auth()->user()->personnel->last_name;
    // }
    $personnelName = auth()->user()->personnel->first_name . ' ' . auth()->user()->personnel->last_name;
    
    $evaluator = $personnelName;
    
    //Person Name
    $middleInitial = $person->middle_name ? $person->middle_name[0] . '.' : '';
    $personName = $person->first_name . ' ' . $middleInitial . ' ' . $person->last_name . ' ' . $person->suffix;
    $representative = $person->last_name != null ? $personName : $corporate->corporate_name;
    
    $json = resource_path('json\printSettings.json');
    $jsonData = File::get($json);
    $printSettings = json_decode($jsonData, true);
    ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
@endphp

@section('stylesheet')
    @vite('resources/css/pages/printables/fsec_checklist.css')
@endsection

@section('issuedFor')
    {{-- PUT LITELAR STRING HERE NO TAGS --}}
    Fire Safety Evaluation Clearance Checklist
@endsection
@section('btngroup')
    <a class="btn btn-secondary d-none" href="/fsec/{{ $buildingPlan->id }}" btnback>Back</a>

    <a class="btn btn-success d-none" href="/fsec/{{ $buildingPlan->id }}" btndone> Done <i class="bi bi-check-lg"></i></a>
@endsection

@section('printTools')
    <div class="printTools d-flex flex-column p-3 bg-white rounded-3 gap-2" printtools>
        <button class="btn btn-primary" id="btnCheckmarkAdd">Toggle Checkmark</button>
    </div>
@endsection

@section('printablePage')
    <div class="printablePage page-1" page="1">
        <img class="certificate" src="{{ asset('img/checklist_1.png') }}" alt="" style="width: 100%; height: 100%;">
        <div data-draggable="true" id="series-no" class="series-no bold">
            <span>{{ $buildingPlan->series_no }}</span>
        </div>


        <div data-draggable="true" id="estabName" class="establishment-name bold">
            <span>{{ $representative }}</span>
        </div>

        <div data-draggable="true" id="projectTitle" class="project-title bold">
            <span>{{ $buildingPlan->project_title }}</span>
        </div>

        <div data-draggable="true" id="projectTitle" class="date-received bold">
            <span>{{ date('m/d/Y', strtotime($buildingPlan->date_received)) }}</span>
        </div>



        <div data-draggable="true" class="address bold">
            <span>{{ $buildingPlan->building->address }}</span>
        </div>
    </div>

    <div class="page-break"></div>

    <div class="printablePage" page="2">
        <img class="certificate" src="{{ asset('img/checklist_2.png') }}" alt="" style="width: 100%; height: 100%;">
    </div>

    <div class="page-break"></div>

    <div class="printablePage" page="3">
        <img class="certificate" src="{{ asset('img/checklist_3.png') }}" alt="" style="width: 100%; height: 100%;">
    </div>

    <div class="page-break"></div>

    <div class="printablePage" page="4">
        <img class="certificate" src="{{ asset('img/checklist_4.png') }}" alt=""
            style="width: 100%; height: 100%;">


        <textarea class="deficiency" maxlength="288">
        
            </textarea>
        <textarea class="deficiency deficiency-right" maxlength="288">
            </textarea>

        <div data-draggable="true" data-editable="false" id="chiefName" class="chiefName bold">{{ $chief }}
        </div>

        <div data-draggable="true" data-editable="false" id="marshalName" class="marshalName bold">{{ $marshal }}
        </div>

        <div data-draggable="true" id="evaluator2" class="evaluator-2 bold text-center">
            <span>{{ auth()->user()->personnel->first_name . ' ' . auth()->user()->personnel->last_name }}</span>
        </div>

        <div data-draggable="true" class="fc-fee">
            <div id="amount" class="fc-fee-font-size">{{ $receipt->amount }}</div>
            <div id="or_no" class="fc-fee-font-size">{{ $receipt->or_no }}</div>
            <div id="date" class="fc-fee-font-size">{{ date('m/d/Y', strtotime($receipt->date_of_payment)) }}
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    @vite('resources/js/pages/printables/fsec_checklist.js')
@endsection
