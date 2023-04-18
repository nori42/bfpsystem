@props(['establishment', 'owner'])

<div class="">
    <div class="fs-5">Record No.: {{ $establishment->id }}</div>
    <div>
        <p class="fs-5 mb-0"> Owner:
            {{ $establishment->owner->person->last_name . ', ' . $establishment->owner->person->first_name . ' ' . $establishment->owner->person->middle_name }}
        </p>
        <p class="fw-bold fs-5">Establishment: {{ $establishment->establishment_name }}</p>
    </div>

    {{-- Establishment Info --}}
    <div class="position-relative">
        <button type="button" class="btn btn-outline-success"style="width:auto !important" data-dropdown-btn
            onclick="toggleShow('establishmentDetail')"><span
                class="material-symbols-outlined fs-3 align-middle">domain</span>Establishment Info</button>
        <div class="dropdown-menus position-absolute p-3" id="establishmentDetail" data-dropdown-menu
            style="display: none !Important">
            <ul class="list-unstyled">
                <li><span class="fw-bold">Establishment Name: </span>{{ $establishment->establishment_name }}</li>
                <li><span class="fw-bold">Substation: </span>{{ $establishment->substation }}</li>
                <li><span class="fw-bold">Occupancy: </span>{{ $establishment->occupancy }}</li>
                <li><span class="fw-bold">Occupancy Sub-Type: </span>{{ $establishment->sub_type }}</li>
                <li><span class="fw-bold">Building Type: </span>{{ $establishment->building_type }}</li>
                <li><span class="fw-bold">No. of storey: </span>{{ $establishment->no_of_storey }}</li>
                <li><span class="fw-bold">Height: </span>{{ $establishment->height }}</li>
                <li><span class="fw-bold">Building Permit: </span>{{ $establishment->building_permit_no }}</li>
                <li><span class="fw-bold">Fire Insurance Co: </span>{{ $establishment->fire_insurance_co }}</li>
                <li><span class="fw-bold">Latest Permit: </span>{{ $establishment->latest_permit }}</li>
                <li><span class="fw-bold">Barangay: </span>{{ $establishment->barangay }}</li>
                <li><span class="fw-bold">Address: </span>{{ $establishment->address }}</li>
            </ul>
        </div>
        <button type="button" class="btn btn-outline-success" style="width:auto !important"
            onclick="openModal('modalOwner')"><span
                class="material-symbols-outlined fs-3 align-middle">account_box</span>Owner Info</button>
    </div>
</div>
