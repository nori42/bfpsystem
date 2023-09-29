{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PHP CODE --}}
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
    $lastInpsectionIssued = $inspections->last() ? date('m/d/Y', strtotime($inspections->last()->issued_on)) : 'N/A';
    
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

{{-- PUT EXTERNAL STYLE SHEET HERE USING VITE --}}
@section('stylesheet')
    @vite('resources/css/pages/establishments/show.css')
@endsection

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            {{-- {{ dd($establishment->getAttributes()) }} --}}


            @if (session('mssg'))
                <x-toast :message="session('mssg')" type="success" />
            @endif
            <div class="d-flex justify-content-center gap-5">
                @if (auth()->user()->type == 'FSIC' || auth()->user()->type == 'ADMINISTRATOR')
                    {{-- <div class="{{ auth()->user()->type == 'ADMINISTRATOR' ? 'w-100' : '' }}">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-outline-primary" href="/establishments/{{ $establishment->id }}/fsic">Fire
                                Safety
                                Inspection(FSIC) <i class="bi bi-arrow-right"></i></a>
                        </div>

                        <x-detailWrapper>
                            <x-info2 label="Total Inspection Issued:" value="{{ $inspectionCount }}" />
                            <x-info2 label="Last Inspection Issued:" value="{{ $lastInpsectionIssued }}" />
                        </x-detailWrapper>
                    </div> --}}
                    <div class="boxshadow rounded-4">
                        <div class="d-flex gap-3 bg-subtleBlue p-4">
                            <div class="text-center px-5">
                                <div class="text-nowrap fw-semibold fs-5">
                                    Total Issued
                                </div>
                                <div class="fs-5">
                                    {{ $inspectionCount }}
                                </div>
                            </div>
                            <div class="border-end border-2" style="border-color: ;">
                            </div>
                            <div class="text-center px-5">
                                <div class="text-nowrap fw-semibold fs-5">
                                    Last Issued
                                </div>
                                <div class="fs-5">
                                    {{ $lastInpsectionIssued }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center p-3">
                            <a class="btn btn-outline-primary px-4"
                                href="/establishments/{{ $establishment->id }}/fsic">Fire
                                Safety
                                Inspection Certificates(FSIC) <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->type == 'FIREDRILL' || auth()->user()->type == 'ADMINISTRATOR')
                    {{-- <div class="{{ auth()->user()->type == 'ADMINISTRATOR' ? 'w-100' : '' }}">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-outline-primary"
                                href="/establishments/{{ $establishment->id }}/firedrill">Firedrill <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                        <x-detailWrapper>
                            <x-info2 label="Total Firedrill Issued:" value="{{ $firedrillCount }}" />
                            <x-info2 label="Total Firedrill Issued This Year:" value="{{ $firedrillCountThisYear }}" />
                            <x-info2 label="Last Firedrill Issued:" value="{{ $lastFiredrillIssued }}" />
                        </x-detailWrapper>
                    </div> --}}
                    <div class="boxshadow rounded-4">
                        <div class="d-flex gap-1 bg-subtleBlue p-4">
                            <div class="text-center px-4">
                                <div class="text-nowrap fw-semibold fs-5">
                                    Total Issued
                                </div>
                                <div class="fs-5">
                                    {{ $firedrillCount }}
                                </div>
                            </div>
                            <div class="border-end border-2" style="border-color: ;">
                            </div>
                            <div class="text-center px-4">
                                <div class="text-nowrap fw-semibold fs-5">
                                    Issued This Year
                                </div>
                                <div class="fs-5">
                                    {{ $firedrillCountThisYear }}
                                </div>
                            </div>
                            <div class="border-end border-2" style="border-color: ;">
                            </div>
                            <div class="text-center px-4">
                                <div class="text-nowrap fw-semibold fs-5">
                                    Last Issued
                                </div>
                                <div class="fs-5">
                                    {{ $lastFiredrillIssued }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center p-3">
                            <a class="btn btn-outline-primary px-5"
                                href="/establishments/{{ $establishment->id }}/firedrill">Firedrill Certificates<i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                @endif
            </div>
            <hr class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h4 class="my-4">Establishment Detail</h4>
                </div>
                @if (auth()->user()->type == 'FSIC' || auth()->user()->type == 'ADMINISTRATOR')
                    <div>
                        <a class="btn btn-primary px-5" href="/establishments/{{ $establishment->id }}/edit">
                            <i class="bi bi-pencil-fill"></i>
                            Update Establishment</a>
                        <button class="btn btn-danger px-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash3-fill"></i>
                            Delete</button>
                    </div>
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
                </div>

                <div class="row my-3">
                    <x-info label="Substation" :value="$establishment->substation" />
                    <x-info label="Building Structure" :value="$establishment->building_type" />
                    <div class="col"></div>

                </div>

                <div class="row my-3">
                    <x-info label="No. of Story" :value="$establishment->no_of_storey" />
                    <x-info label="Height (m)" :value="$establishment->height" />
                    <x-info label="Floor Area (sq m)" :value="$establishment->floor_area" />
                    <div class="col"></div>
                    <div class="col"></div>
                </div>

                <div class="row my-3">
                    <x-info label="Name of Fire Insurance Co/Co-Insurer" :value="$establishment->fire_insurance_co" />

                    <div class="col"></div>
                    <div class="col"></div>
                </div>

                <div class="row my-3">
                    <x-info label="Barangay" :value="$establishment->barangay" />
                    <x-info label="Address" :value="$establishment->address" />
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
            </x-detailWrapper>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="my-4">Owner Detail</h4>

                @if (auth()->user()->type == 'FSIC' || auth()->user()->type == 'ADMINISTRATOR')
                    <a class="btn btn-primary px-5" href="/owner/{{ $establishment->owner->id }}/edit">
                        <i class="bi bi-pencil-fill"></i>
                        Update Owner</a>
                @endif
            </div>

            <div id="ownerDetail">
                <x-detailWrapper>
                    <div class="row">
                        @php
                            $personName = null;
                            $owner = $establishment->owner;
                            $contactNo = $owner->contactNo;
                            // if ($owner->corporate != null) {
                            //     $corporateName = $establishment->owner->corporate->corporate_name;
                            //     $contactNo = $owner->corporate->contact_no;
                            // }
                            
                            // if ($owner->person->last_name != null) {
                            //     $person = $establishment->owner->person;
                            //     $contactNo = $establishment->owner->person->contact_no;
                            
                            //     if ($person->middle_name != null) {
                            //         $personName = $person->first_name . ' ' . $person->middle_name[0] . '. ' . $person->last_name;
                            //     } else {
                            //         $personName = $person->first_name . ' ' . $person->last_name;
                            //     }
                            // }
                            
                            $representative = $establishment->getOwnerName();
                        @endphp
                        <x-info label="Owner/Representative" :value="$representative" />
                        <x-info label="Contact No." :value="$contactNo" />
                    </div>
                </x-detailWrapper>
            </div>

            <!--Delete Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
                    <div class="modal-content p-3">
                        <div id="deleteSpinner" class="text-center d-none my-5">
                            <div class="spinner-border" role="status" style="width: 4rem; height: 4rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="fs-4 mt-2 text-secondary">Deleting Establishment...</div>
                        </div>
                        <div id="deleteContent">
                            <div class="modal-body">
                                <h1 class="modal-title fs-4" id="exampleModalLabel">Do you want to delete this
                                    establishment?
                                </h1>
                                <div class="fs-6 text-secondary">All inspections and firedrill associated with this
                                    establishment
                                    will also
                                    be
                                    deleted.</div>
                                <div>Inspection Issued: {{ $establishment->inspection->count() }}</div>
                                <div>Firedrill Issued: {{ $establishment->firedrill->count() }}</div>
                                <div class="fs-6 text-secondary">This action cannot be reverted.</div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="/establishments/{{ $establishment->id }}/delete" method="POST">
                                    @csrf
                                    <button class="btn btn-danger px-2" id="deleteBtn">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-pageWrapper>


    </div>
@endsection

@section('page-script')
    @vite('resources/js/pages/establishments/show.js')
@endsection
