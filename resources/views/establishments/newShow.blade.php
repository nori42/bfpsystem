{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        @php
            // Check if establishment detail is complete
            $incompleteDetail = false;
            foreach ($establishment->getAttributes() as $detail => $value) {
                if (($value === '' || $value === null) && $detail != 'deleted_at') {
                    $incompleteDetail = true;
                    break;
                }
            }
            $inspectionCount = 0;
            $firedrillCount = 0;
            $lastInpsectionIssued = $inspections->last() ? date('m/d/Y', strtotime($inspections->last()->inspection_date)) : 'N/A';
            $lastFiredrillIssued = $firedrills->last() ? date('m/d/Y', strtotime($firedrills->last()->issued_on)) : 'N/A';
            $firedrillCountThisYear = count($firedrills->filter(fn($firedrill) => $firedrill->year == date('Y')));
            // count will throw error if checks a null value
            try {
                $inspectionCount = count($inspections);
            } catch (\Throwable $th) {
                $inspectionCount = 0;
            }
            try {
                $firedrillCount = count($firedrills);
            } catch (\Throwable $th) {
                $firedrillCount = 0;
            }
        @endphp
        <x-pageWrapper>
            {{-- {{ dd($establishment->getAttributes()) }} --}}
            @if (session('mssg'))
                <x-toast :message="session('mssg')" />
            @endif
            <div class="d-flex justify-content-between gap-5">
                @if (auth()->user()->type == 'FSIC' || auth()->user()->type == 'ADMIN')
                    <div class="{{ auth()->user()->type == 'ADMIN' ? 'w-100' : '' }}">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-outline-success" href="/establishments/{{ $establishment->id }}/fsic">Fire
                                Safety
                                Inspection(FSIC)</a>
                            <div>
                                @if ($inspectionCount == 0)
                                    <x-tooltip label="!" tooltiptext="No Inspection" color="danger" />
                                @endif
                                {{-- <x-tooltip label="!" tooltiptext="Expired Inspection" color="danger" /> --}}
                            </div>
                        </div>
                        {{-- Inspection Stat --}}
                        <x-detailWrapper>
                            <x-info2 label="Total Inspection Issued:" value="{{ $inspectionCount }}" />
                            <x-info2 label="Last Inspection Issued:" value="{{ $lastInpsectionIssued }}" />
                        </x-detailWrapper>
                    </div>
                @endif

                @if (auth()->user()->type == 'FIREDRILL' || auth()->user()->type == 'ADMIN')
                    <div class="{{ auth()->user()->type == 'ADMIN' ? 'w-100' : '' }}">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-outline-success"
                                href="/establishments/{{ $establishment->id }}/firedrill">Firedrill</a>
                            <div>
                                @if ($firedrillCount == 0)
                                    <x-tooltip label="!" tooltiptext="No Firedrill" color="danger" />
                                @endif
                            </div>
                        </div>
                        <x-detailWrapper>
                            <x-info2 label="Total Firedrill Issued:" value="{{ $firedrillCount }}" />
                            <x-info2 label="Total Firedrill Issued This Year:" value="{{ $firedrillCountThisYear }}" />
                            <x-info2 label="Last Firedrill Issued:" value="{{ $lastFiredrillIssued }}" />
                        </x-detailWrapper>
                    </div>
                @endif
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h4 class="my-4">Establishment Detail</h4>
                    @if ($incompleteDetail)
                        <x-tooltip label="!" tooltiptext="Incomplete details" color="warning" />
                    @endif
                </div>
                @if (auth()->user()->type == 'FSIC' || auth()->user()->type == 'ADMIN')
                    <a class="btn btn-success px-5" href="/establishments/{{ $establishment->id }}/edit">
                        <i class="bi bi-pencil-fill"></i>
                        Edit</a>
                @endif
            </div>

            <x-detailWrapper>
                <div class="row">
                    <x-info label="Establishment Name" :value="$establishment->establishment_name" />
                </div>
                <div class="row my-3">
                    <x-info label="Business Permit No." :value="$establishment->business_permit_no" />
                    <x-info label="Occupancy" :value="$establishment->occupancy" />
                    <x-info label="Sub Type" :value="$establishment->sub_type" />
                    <x-info label="Building Structure" :value="$establishment->building_type" />
                </div>

                <div class="row my-3">
                    <x-info label="No. of Story" :value="$establishment->no_of_storey" />
                    <x-info label="Height (m)" :value="$establishment->height" />
                    <x-info label="Floor Area (sq m)" :value="$establishment->floor_area == null ? 'N/A' : $establishment->floor_area" />
                    <div class="col"></div>
                    <div class="col"></div>
                </div>

                <div class="row my-3">
                    <x-info label="Name of Fire Insurance Co/Co-Insurer" :value="$establishment->fire_insurance_co == null ? 'N/A' : $establishment->fire_insurance_co" />
                    <x-info label="Latest Mayor's/Business Permit" :value="$establishment->latest_mayors_permit == null
                        ? 'N/A'
                        : $establishment->latest_mayors_permit" />
                    <div class="col"></div>
                    <div class="col"></div>
                </div>

                <div class="row my-3">
                    <x-info label="Barangay" :value="$establishment->barangay" />
                    <x-info label="Address" :value="$establishment->address == null ? 'N/A' : $establishment->address" />
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
            </x-detailWrapper>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-subtleBlue shadow-sm fw-normal fs-4" onclick="toggleShow('ownerDetail')">Owner Detail
                    <i class="bi bi-caret-down-fill"></i></button>

                @if (auth()->user()->type == 'FSIC' || auth()->user()->type == 'ADMIN')
                    <a class="btn btn-success px-5" href="/owner/{{ $establishment->owner->id }}/edit">
                        <i class="bi bi-pencil-fill"></i>
                        Edit</a>
                @endif
            </div>

            <div id="ownerDetail"style="display: none !important;">
                <x-detailWrapper>

                    <div class="row">
                        @php
                            $personName = null;
                            $contactNo = null;
                            
                            if ($owner->corporate != null) {
                                $corporateName = $establishment->owner->corporate->corporate_name;
                                $contactNo = $owner->corporate->contact_no;
                            }
                            
                            if ($owner->person->last_name != null) {
                                $person = $establishment->owner->person;
                                $contactNo = $establishment->owner->person->contact_no;
                                $personName = $person->first_name . ' ' . $person->middle_name[0] . '. ' . $person->last_name;
                            }
                            
                            $representative = $personName != null ? $personName : $corporateName;
                        @endphp
                        <x-info label="Owner/Representative" :value="$representative" />
                        <x-info label="Contact No." :value="$contactNo" />
                    </div>
                </x-detailWrapper>
            </div>
        </x-pageWrapper>
    </div>
@endsection
