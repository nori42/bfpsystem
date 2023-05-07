@props(['establishment', 'owner'])


@php
    $personName = $owner->person->first_name . ' ' . $owner->person->middle_name . '. ' . $owner->person->last_name . ' ' . $owner->person->suffix;
    $company = $owner->corporate->corporate_name;
    $representative = $personName != null ? $personName : $company;
@endphp
<div>
    <div class="fs-5">Buidling Permit: {{ $establishment->building_permit_no }}</div>
    <div>
        <p class="fs-5 mb-0"> Owner/Representative:
            {{ $representative }}
        </p>
        <p class="fw-bold fs-5">Establishment: {{ $establishment->establishment_name }}</p>
    </div>

    <div>
        {{-- Establishment Info --}}
        <div class="position-relative d-inline-block" dropdown>
            <button type="button" class="btn btn-outline-success"style="width:auto !important" data-dropdown-btn
                onclick="toggleShow('establishmentDetail')"><span
                    class="material-symbols-outlined fs-3 align-middle">domain</span>Establishment Info</button>
            <div class="dropdown-menus position-absolute p-3" id="establishmentDetail" dropdown-menu
                style="display: none !Important; min-width: 380px;">
                <ul class="list-unstyled">
                    @if (auth()->user()->type != 'FIREDRILL')
                        <li class="d-flex justify-content-between"><span class="fs-4 fw-bold">Info</span><a
                                class="btn btn-success my-0" href="/establishments/{{ $establishment->id }}">Edit
                                Details</a>
                        </li>
                    @endif
                    <li><span class="fw-bold">Establishment Name: </span>{{ $establishment->establishment_name }}</li>
                    <li><span class="fw-bold">Building Permit: </span>{{ $establishment->building_permit_no }}</li>
                    <li><span class="fw-bold">Substation: </span>{{ $establishment->substation }}</li>
                    <li><span class="fw-bold">Occupancy: </span>{{ $establishment->occupancy }}</li>
                    <li><span class="fw-bold">Occupancy Sub-Type: </span>{{ $establishment->sub_type }}</li>
                    <li><span class="fw-bold">Building Type: </span>{{ $establishment->building_type }}</li>
                    <li><span class="fw-bold">No. of storey: </span>{{ $establishment->no_of_storey }}</li>
                    <li><span class="fw-bold">Height: </span>{{ $establishment->height }}</li>
                    <li><span class="fw-bold">Fire Insurance Co: </span>{{ $establishment->fire_insurance_co }}</li>
                    <li><span class="fw-bold">Latest Permit: </span>{{ $establishment->latest_permit }}</li>
                    <li><span class="fw-bold">Barangay: </span>{{ $establishment->barangay }}</li>
                    <li><span class="fw-bold">Address: </span>{{ $establishment->address }}</li>
                </ul>
            </div>
        </div>
        {{-- Owner Info --}}
        <button type="button" class="btn btn-outline-success" style="width:auto !important"
            onclick="openModal('modalOwner')"><span
                class="material-symbols-outlined fs-3 align-middle">account_box</span>Owner Info</button>
    </div>
</div>
