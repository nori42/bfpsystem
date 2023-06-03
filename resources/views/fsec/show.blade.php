@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    @php
        $building = $buildingPlan->building;
        $receipt = $buildingPlan->receipt;
        $person = $buildingPlan->owner->person;
        $corporate = $buildingPlan->owner->corporate;
        
        //Person Name
        $middleInitial = $person->middle_name ? $person->middle_name[0] . '.' : '';
        $personName = $person->title . ' ' . $person->first_name . ' ' . $middleInitial . ' ' . $person->last_name . ' ' . $person->suffix;
        $applicant = $person->last_name != null ? $personName : $corporate->corporate_name;
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            @if (session('mssg'))
                <x-toast :message="session('mssg')" />
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <h1 class="fs-3 my-2">Building Plan Application</h1>
                    @switch($buildingPlan->status)
                        @case('APPROVED')
                            <x-tag bgColor="bg-success" text="Approved" />
                        @break

                        @case('DISAPPROVED')
                            <x-tag bgColor="bg-danger" text="Disapproved" />
                        @break

                        @default
                            <x-tag bgColor="bg-warning" text="Pending" />
                    @endswitch
                </div>
                <div class="d-flex gap-2 {{ $buildingPlan->status == 'APPROVED' ? 'd-none' : '' }}">
                    <a class="btn btn-success px-4" href="/fsec/{{ $buildingPlan->id }}/edit"> <i
                            class="bi bi-pencil-fill mx-1"></i>Update Application</a>

                    <div class="position-relative py-0">
                        <button class="btn btn-success px-2" onclick="toggleShow('actionMenu')">Action <i
                                class="bi bi-caret-down-fill"></i></button>
                        <div id="actionMenu" class="dropdown-menus py-3 px-2 border-1 text-white" dropdown-menu
                            style="display:none !important; width:180px; left:calc(-1 * (100% + 10px));">
                            <ul class="list-unstyled">
                                <li><a href="/fsec/print/{{ $buildingPlan->id }}"
                                        class="btn btn-success w-100 text-start"><i
                                            class="bi bi-file-earmark-check mx-2 fs-5"></i>Approve</a>
                                </li>
                                <li><a href="/fsecchecklist/print/{{ $buildingPlan->id }}"
                                        class="btn btn-success w-100 mt-2 text-start"><i
                                            class="bi bi-clipboard-check mx-2 fs-5"></i>Checklist</a></li>
                                <li><a href="/fsecdisapprove/print/{{ $buildingPlan->id }}"
                                        class="btn btn-outline-danger w-100 mt-2 text-start"><i
                                            class="bi bi-file-earmark-excel mx-2 fs-5"></i>Disapprove</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <x-detailWrapper>

                <h2 class="fs-4">Permit</h2>
                <div class="row">
                    <x-info label="Applicant Name" :value="$applicant" />
                </div>
                <div class="row my-3">
                    <x-info label="Series No." :value="$buildingPlan->series_no" />
                    <x-info label="Application No." :value="$buildingPlan->bp_application_no" />
                    <x-info label="Bill of Materials(BOQ)" :value="$buildingPlan->bill_of_materials ? $buildingPlan->bill_of_materials : 'N/A'" />
                    <x-info label="Date Received." value="{{ date('m/d/Y', strtotime($buildingPlan->date_received)) }}" />
                </div>

                <h2 class="fs-4 mt-4">Building</h2>
                <x-info label="Name of Building/Structure/Facility" :value="$buildingPlan->name_of_building ? $buildingPlan->name_of_building : 'N/A'" />

                <div class="row my-3">
                    <x-info label="Building Story" :value="$building->building_story ? $building->building_story : 'N/A'" />
                    <x-info label="Floor Area" :value="$building->floor_area ? $building->floor_area : 'N/A'" />
                    <x-info label="Occupancy" :value="$building->occupancy" />
                    <x-info label="Sub Type" :value="$building->sub_type" />
                </div>
                <div class="my-3">
                    <x-info label="Address" :value="$building->address" />
                </div>
                <h2 class="fs-4 mt-4">Receipt</h2>

                @if ($receipt->or_no)
                    <div class="row w-50">
                        <x-info label="OR No." :value="$receipt->or_no ? $receipt->or_no : 'N/A'" />
                        <x-info label="Amount" :value="$receipt->amount ? $receipt->amount : 'N/A'" />
                        <x-info label="Date of Payment" value="{{ date('m/d/Y', strtotime($receipt->date_of_payment)) }}" />
                    </div>
                @else
                    <div class="text-secondary fs-5">No Payment (Update the application if available)</div>
                @endif
            </x-detailWrapper>
            <hr>
            <h1 class="fs-3 my-2">Evaluation</h1>
            <table class="table">
                <thead>
                    <th>Remarks</th>
                    <th>Evaluation Date</th>
                    <th>Evaluator</th>
                </thead>
                <tbody>
                    @foreach ($evaluations as $evaluation)
                        <tr>
                            <td><span
                                    class="{{ $evaluation->remarks == 'DISAPPROVED' ? 'text-danger' : 'text-success' }}">{{ $evaluation->remarks }}</span>
                            </td>
                            <td>{{ date('m/d/Y', strtotime($evaluation->created_at)) }}</td>
                            <td>{{ $evaluation->evaluator }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-pageWrapper>
    </div>
@endsection
