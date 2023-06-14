@props(['establishment', 'owner', 'representative'])


@php
    $personName = null;
    $company = null;
    $person = null;
    
    if ($owner->person->last_name != null) {
        $person = $owner->person;
        $personName = $owner->person->first_name . ' ' . $owner->person->middle_name . ' ' . $owner->person->last_name . ' ' . $owner->person->suffix;
    }
    
    if ($owner->corporate != null) {
        $company = $owner->corporate;
    }
    
    // $representative = $personName != null ? $personName : $company->corporate_name;
    
@endphp
<div>
    {{-- <div class="fs-5">Business Permit: {{ $establishment->business_permit_no }}</div> --}}
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
                style="display: none !important; min-width: 380px;">
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between"><span class="fs-4 fw-bold">Info</span><a
                            class="btn btn-success my-0" href="/establishments/{{ $establishment->id }}">
                            Details</a>
                    </li>
                    <li><span class="fw-bold">Establishment Name: </span>{{ $establishment->establishment_name }}</li>
                    <li><span class="fw-bold">Business Permit: </span>{{ $establishment->building_permit_no }}</li>
                    <li><span class="fw-bold">Substation: </span>{{ $establishment->substation }}</li>
                    <li><span class="fw-bold">Occupancy: </span>{{ $establishment->occupancy }}</li>
                    <li><span class="fw-bold">Occupancy Sub-Type: </span>{{ $establishment->sub_type }}</li>
                    <li><span class="fw-bold">Building Type: </span>{{ $establishment->building_type }}</li>
                    <li><span class="fw-bold">Building Story: </span>{{ $establishment->no_of_storey }}</li>
                    <li><span class="fw-bold">Floor Area: </span>{{ $establishment->floor_area }} (sq m)</li>
                    <li><span class="fw-bold">Height: </span>{{ $establishment->height }} (m)</li>
                    <li><span class="fw-bold">Fire Insurance Co: </span>{{ $establishment->fire_insurance_co }}</li>
                    <li><span class="fw-bold">Latest Permit: </span>{{ $establishment->latest_permit }}</li>
                    <li><span class="fw-bold">Barangay: </span>{{ $establishment->barangay }}</li>
                    <li><span class="fw-bold">Address: </span>{{ $establishment->address }}</li>
                    <li><span class="fw-bold fs-5">Owner/Representative</li>
                    @if ($personName != null)
                        <li><span class="fw-bold">Name:</span> {{ $personName }}</li>
                        <li><span class="fw-bold">Contact:</span> {{ $person->contact_no }}</li>
                    @else
                        <li><span class="fw-bold">Corporate:</span> {{ $company->corporate_name }}</li>
                        <li><span class="fw-bold">Contact:</span> {{ $company->contact_no }}</li>
                    @endif
                </ul>
            </div>
        </div>
        {{-- Owner Info --}}
        {{-- <div class="position-relative d-inline-block" dropdown>
            <button type="button" class="btn btn-outline-success" style="width:auto !important"
                onclick="openModal('ownerDetail')"><span
                    class="material-symbols-outlined fs-3 align-middle">account_box</span>Owner Info</button>
            <div class="dropdown-menus position-absolute p-3" id="ownerDetail" dropdown-menu
                style="display: none !important; min-width: 380px;">
                <ul class="list-unstyled">
                    @if (auth()->user()->type != 'FIREDRILL')
                        <li class="d-flex justify-content-between"><span class="fs-4 fw-bold">Info</span><a
                                class="btn btn-success my-0" href="#">Edit
                                Details</a>
                        </li>
                    @endif
                    </li>
                    <li><span class="fw-bold fs-5">Owner/Representative</li>
                    @if ($personName != null)
                        <li><span class="fw-bold">Name:</span> {{ $personName }}</li>
                        <li><span class="fw-bold">Contact:</span> {{ $person->contact_no }}</li>
                    @else
                        <li><span class="fw-bold">Corporate:</span> {{ $company->corporate_name }}</li>
                        <li><span class="fw-bold">Contact:</span> {{ $company->contact_no }}</li>
                    @endif
                </ul>
            </div>
        </div> --}}

    </div>
</div>
