@props(['establishment', 'owner', 'representative'])


@php
    $personName = $owner->last_name != null ? $owner->first_name . ' ' . $owner->last_name : '';
@endphp
<div>
    <div>
        {{-- Establishment Info --}}
        <div class="position-relative d-inline-block" dropdown>
            <button type="button" class="btn btn-outline-primary py-2 rounded-2"style="width:auto !important"
                dropdown-btn><span class="material-symbols-outlined fs-3 align-middle">domain</span>Establishment
                Info<i class="bi bi-caret-down-fill fs-6 mx-2"></i></button>

            <div class="dropdown-menus position-absolute p-3 boxshadow rounded-3" id="establishmentDetail" dropdown-menu
                style="min-width: 380px; translate: -40%;">
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between"><span class="fs-4 fw-bold">Info</span><a
                            class="btn btn-primary my-0" href="/establishments/{{ $establishment->id }}">
                            Details</a>
                    </li>
                    <li><span class="fw-bold">Establishment Name: </span>{{ $establishment->establishment_name }}</li>
                    <li><span class="fw-bold">Business Permit: </span>{{ $establishment->business_permit_no }}</li>
                    <li><span class="fw-bold">Building Permit: </span>{{ $establishment->building_permit_no }}</li>
                    <li><span class="fw-bold">Substation: </span>{{ $establishment->substation }}</li>
                    <li><span class="fw-bold">Occupancy: </span>{{ $establishment->occupancy }}</li>
                    <li><span class="fw-bold">Occupancy Sub-Type: </span>{{ $establishment->sub_type }}</li>
                    <li><span class="fw-bold">Building Type: </span>{{ $establishment->building_type }}</li>
                    <li><span class="fw-bold">Building Story: </span>{{ $establishment->no_of_storey }}</li>
                    <li><span class="fw-bold">Floor Area: </span>{{ $establishment->floor_area }} (sq m)</li>
                    <li><span class="fw-bold">Height: </span>{{ $establishment->height }} (m)</li>
                    <li><span class="fw-bold">Hazard Note: </span>{{ $establishment->hazard_note }}</li>
                    <li><span class="fw-bold">Fire Insurance Co: </span>{{ $establishment->fire_insurance_co }}</li>
                    <li><span class="fw-bold">Barangay: </span>{{ $establishment->barangay }}</li>
                    <li><span class="fw-bold">Address: </span>{{ $establishment->address }}</li>
                    <li><span class="fw-bold fs-5 my-3">Owner</li>
                    @if ($personName)
                        <li><span class="fw-bold">Name:</span> {{ $personName }}</li>
                    @endif
                    @if ($owner->corporate_name)
                        <li><span class="fw-bold">Corporate:</span> {{ $owner->corporate_name }}</li>
                    @endif
                    <li><span class="fw-bold">Contact:</span> {{ $owner->contact_no }}</li>
                </ul>
            </div>
        </div>

    </div>
</div>

@section('component-scripts')
@endsection
