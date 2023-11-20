@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-search for='building plan' />
        @if (session()->get('searchQuery'))
            @php
                $message = "\"" . session()->get('searchQuery') . "\"" . ' Returns no result';
            @endphp
            <x-toast :message="$message" />
        @endif
        @if (session()->get('toastMssg'))
            <x-toast :message="session()->get('toastMssg')" />
        @endif
        <x-pageWrapper>
            <div class="d-flex justify-content-center gap-4">
                <div>
                    <div class="text-secondary fw-bold text-center mb-3">Click To Add New Application</div>
                    <a href="/fsec/create" class="btn btn-primary px-5 py-2 mt-md-1 fs-4">
                        <span class="material-symbols-outlined align-middle fs-3">
                            assignment_add
                        </span>
                        New Building Plan Application
                    </a>
                </div>
                <div class="border border-1 mx-5" style="height: 13rem;">

                </div>
                <div>
                    <div class="text-secondary fw-bold text-center mb-3">Click To Show Pending Applications</div>
                    <button class="btn btn-primary px-5 py-2 mt-md-1 fs-4" data-bs-toggle="modal"
                        data-bs-target="#pendingApplication">
                        <i class="bi bi-hourglass-split"></i>Pending
                        Applications</button>
                </div>
            </div>
            {{-- <x-modal topLocation="3" width="100" id="pendingModal" leftLocation="30" class="bg-white">
            </x-modal> --}}

            <div class="modal fade" id="pendingApplication">
                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                    <div class="modal-content px-5 py-3">
                        <div class="overflow-auto">
                            @if (count($buildingPlans) != 0)
                                <div
                                    class="position-sticky top-0 d-flex align-items-center justify-content-between heading my-4 bg-white">
                                    <div class="py-2">
                                        <div class="fs-3">{{ count($buildingPlans) }} Pending</div>
                                        <div class="text-secondary">List of pending applications</div>
                                    </div>
                                </div>

                                <table id="evaluations" class="table">
                                    <thead>
                                        <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(0)">Series
                                                No.</span>
                                        </th>
                                        <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(1)">Date
                                                Received</span></th>
                                        <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(3)">Permit
                                                Applicant</span>
                                        </th>
                                        <th class="position-sticky bg-white" style="top:9%;"><span
                                                onclick="sort(4)">Building
                                                Name</span></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($buildingPlans as $plan)
                                            @php
                                                $owner = $plan->owner;

                                                $representative = $plan->getOwnerName();
                                            @endphp
                                            <tr>
                                                <td>{{ $plan->series_no }}</td>
                                                <td>{{ date('m/d/Y', strtotime($plan->date_received)) }}</td>
                                                <td><a href="/fsec/{{ $plan->id }}"
                                                        target="_parent">{{ $representative }}</a>
                                                </td>
                                                <td>{{ $plan->name_of_building }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="py-2">
                                    <div class="fs-3">0 Pending</div>
                                    <div class="text-secondary">List of pending applications</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-pageWrapper>
    </div>
@endsection
