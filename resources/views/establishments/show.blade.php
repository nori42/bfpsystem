@extends('layouts.app')


@section('content')
    <style>
        .btn-show {
            background-color: #1C3B64;
            color: white;
            font-weight: 600;
            width: 80%;
        }

        .btn-show:hover {
            background-color: #234a7d !important;
            color: white !important;
        }

        .owner-info .btn:hover {
            background-color: #8ED2FF !important;
            color: black !important;
        }

        .info {
            text-transform: uppercase;
        }

        .info-label {
            font-weight: 700;
        }

        #btnEdit {
            background: #53A3D8;
            color: #FFFFFF;
            cursor: pointer;
        }

        .editBtn {
            background: #53A3D8;
            color: #FFFFFF;
            cursor: pointer;
        }

        .editBtn:hover {
            background: #72b5e1;
            color: #FFFFFF;
        }

        #saveBtn {
            background-color: #28A644;
            margin-right: 5px;
            cursor: pointer;
            display: none;
        }

        .editable {
            border: 1px solid;
            border-color: #53A3D8;
            outline: #28A644;
        }
    </style>

    <x-backBtn />

    <div class="page-content">
        {{-- Put page content here --}}


        {{-- Owner Info & Selected Establishment --}}
        <div class="w-85 mx-auto ">
            <div>
                <p class="fs-5 m-0"> Owner:
                    {{ $establishment->owner->person->last_name . ', ' . $establishment->owner->person->first_name . ' ' . $establishment->owner->person->middle_name }}
                </p>
                <p class="fw-bold fs-5">Establishment: {{ $establishment->establishment_name }}</p>
            </div>

            <button type="button" class="btn btn-outline-success" id="button" style="width:auto !important"
                onclick="openModal('modalOwner')"><span
                    class="material-symbols-outlined fs-3 align-middle">account_box</span>Owner Info</button>
            {{-- <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;">
                <span class="fw-bold">Selected Establishment: </span>{{$establishment->establishment_name}}
            </div> --}}
        </div>

        {{-- <hr class="w-85 mx-auto border-3"> --}}
        {{-- Establishment Info --}}

        {{-- Details Action --}}
        {{-- <div class="d-flex justify-content-between gap-2 mx-auto mt-5 w-85">
            <a href="/establishments/fsec/{{$establishment->id}}" class="btn btn-show fs-6">Fire Safety Evaluation Certificate(FSEC)</a>
            <a href="/establishments/fsic/{{$establishment->id}}" class="btn btn-show fs-6">Fire Safety Inspection Certificate(FSIC)</a>
            <a href="/establishments/firedrill/{{$establishment->id}}" class="btn btn-show fs-6">Fire Drill</a>
        </div> --}}
        <script defer>
            function deleteEstablishment() {
                document.getElementById('formDelete').submit();
            }
        </script>
        <form action="/establishments/{{ $establishment->id }}/delete" method="POST" id="formDelete">@csrf</form>

        <form class="w-85 mx-auto mt-3 py-3 px-5 position-relative" style="background-color: #EFEFEF;"
            action="/establishments/{{ $establishment->id }}/update" method="POST" id="updateForm">
            @csrf
            {{-- <div class="d-flex justify-content-end gap-1">
                <span class="text-decoration-none p-2 py-1 rounded-1 text-white" id="btnEdit">
                    
                    Edit Details
                </span>
                <span class="text-decoration-none p-2 py-1 rounded-1 text-white" id="btnSave">Done</span>
                <input type="hidden" value="false" id="isEditable">
            </div> --}}
            @if (session('mssg'))
                <h5 class="text-success w-90 position-absolute w-25">{{ session('mssg') }}</h5>
            @endif
            <div class="d-flex justify-content-end gap-3">
                <button class="btn btn-success" type="button" id="btnEdit">
                    <span class="material-symbols-outlined align-middle fs-6">
                        edit
                    </span>
                    Edit Details
                </button>
                <button class="btn btn-outline-success d-none p-1" type="button" data-btn-edit
                    id="btnCancel">Cancel</button>
                <button class="btn btn-success d-none px-4" type="submit" data-btn-edit>Save</button>

                <div class="position-relative">
                    <button type="button" class="btn p-0 fw-bold btn-success h-100" onclick="toggleShow('detailMenu')">
                        <span class="material-symbols-outlined fs-2 align-middle">
                            menu
                        </span>
                    </button>

                    {{-- Action Menu --}}
                    <div class="dropdown-menus p-2" data-dropdown-menu id="detailMenu"
                        style="display:none; !important; left: -168.5px;">
                        <div class="d-inline flex-column">
                            <a href="/establishments/{{ $establishment->id }}/fsic"
                                class="btn btn-outline-success border-0 w-100 text-start fw-semibold">Fire Safety
                                Inspection</a>
                            <a href="/establishments/{{ $establishment->id }}/firedrill"
                                class="btn btn-outline-success border-0 w-100 text-start fw-semibold">Fire Drill</a>
                            <hr class="my-0">
                            <button type="button" class="btn btn-outline-danger text-start border-0 w-100"
                                onclick="openModal('dialogMoveToArchive')">Move To Archive</button>
                        </div>
                    </div>

                    <div class="modal" id="dialogMoveToArchive" data-modal="modal">
                        <div class="modal-content w-50 modal-content-dialog">
                            <h4>Do you want to move this record to archive?</h4>
                            <p>Archived record cannot be access or edit <strong>(This action cannot be reverted)</strong>
                            </p>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary w-25 fw-bold"
                                    onclick="closeModal('dialogMoveToArchive')">No</button>
                                <button type="button" class="btn btn-outline-danger w-25 fw-bold"
                                    onclick="deleteEstablishment()">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- add @csrf every form --}}
            @csrf
            <input type="hidden" name="id" value="{{ $establishment->id }}">
            <div class="my-2">
                <label class="info-label">Establishment Name</label>
                <input class="info form-control" type="text" value="{{ $establishment->establishment_name }}"
                    name="establishmentName" data-input-edit readonly>
            </div>

            <x-form.input label="Occupancy" name="occupancy" :value="$establishment->occupancy" customAttr="data-input-edit"
                :readonly="true" />

            <div class="my-2 w-100">
                <label class="info-label">Sub Type</label>
                <input class="form-control info" type="text" value="{{ $establishment->sub_type }}" name="subType"
                    data-input-edit readonly>
            </div>

            <div class="my-2">
                {{-- arrays of sub-stations --}}
                @php
                    $stations = ['CCSF', 'CPB', 'GUADALUPE', 'LABANGON', 'LAHUG', 'MABOLO', 'PAHINA CENTRAL', 'PARDO', 'PARI-AN', 'SAN NICOLAS', 'TALAMBAN'];
                    
                    $building_type = ['Small', 'Medium', 'Large', 'High Rise'];
                @endphp
                <div class="my-2">
                    <label class="info-label">Substation</label>
                    <select class="form-select info" name="substation" id="substation" data-select-edit disabled>
                        @foreach ($stations as $station)
                            @if ($establishment->substation == $station)
                                <option value="{{ $station }}" selected>{{ $station }}</option>
                            @else
                                <option value="{{ $station }}">{{ $station }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">


                <div class="my-2 w-100">
                    <label class="info-label">Building Type</label>
                    <select class="form-select px-5 info" name="buildingType" id="buildingType" data-select-edit disabled>
                        @foreach ($building_type as $btype)
                            @if ($establishment->building_type == $btype)
                                <option value="{{ $btype }}" selected>{{ $btype }}</option>
                            @else
                                <option value="{{ $btype }}">{{ $btype }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">No Of Storey</label>
                    <input class="form-control info" type="text" value="{{ $establishment->no_of_storey }}"
                        name="no_of_storey" data-input-edit readonly>
                </div>

                <div class="my-2 w-100">
                    <label class="info-label">Height</label>
                    <input class="form-control info" type="text" value="{{ $establishment->height }}" name="height"
                        data-input-edit readonly>
                </div>
            </div>

            <div class="my-2">
                <label class="info-label">Building Permit No.</label>
                <input class="form-control info" type="text" value="{{ $establishment->building_permit_no }}"
                    name="buildingPermitNo" data-input-edit readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Name of Fire Insurance Co/Co-Insurer</label>
                <input class="form-control info" type="text" value="{{ $establishment->fire_insurance_co }}"
                    name="fireInsuranceCo" data-input-edit readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Latest Mayor's/Business Permit</label>
                <input class="form-control info" type="text" value="{{ $establishment->latest_mayors_permit }}"
                    name="latestPermit" data-input-edit readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Barangay</label>
                <input class="form-control info" type="text" value="{{ $establishment->barangay }}" name="barangay"
                    data-input-edit readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Address</label>
                <input class="form-control info" type="text" value="{{ $establishment->address }}" name="address"
                    data-input-edit readonly>
            </div>
        </form>
    </div>

    <x-modal id="modalOwner" width="50" topLocation="5">
        <x-ownerInfo />
    </x-modal>


    </div>



    <script src="/js/script.establishment-edit.js"></script>
@endsection
