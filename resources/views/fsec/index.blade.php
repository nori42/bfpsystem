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
                    <div class="text-secondary fw-bold text-center">Click To Add New Application</div>
                    <a href="/fsec/create" class="btn btn-primary px-5 py-2 mt-md-1 fs-4">
                        <span class="material-symbols-outlined align-middle fs-3">
                            assignment_add
                        </span>
                        New Building Plan Application
                    </a>
                </div>
                <div>
                    <div class="text-secondary fw-bold text-center">Click To Show Pending Applications</div>
                    <button class="btn btn-primary px-5 py-2 mt-md-1 fs-4" onclick="openModal('pendingModal')">
                        <i class="bi bi-hourglass-split"></i>Pending
                        Applications</button>
                </div>
            </div>
            <x-modal topLocation="3" width="100" id="pendingModal" leftLocation="30" class="bg-white">
                {{-- <iframe id="iFramePending" src="{{ env('APP_URL') . '/fsec/pending' }}" frameborder="0" width="100%"
                    height="800px"></iframe> --}}
                <div class="overflow-auto" style="height: 800px;">
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
                                <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(4)">Building
                                        Name</span></th>
                            </thead>
                            <tbody>
                                @foreach ($buildingPlans as $plan)
                                    @php
                                        $owner = $plan->owner;
                                        $personName = null;
                                        
                                        if ($owner->person->last_name != null) {
                                            if ($owner->person->middle_name == null) {
                                                $personName = $owner->person->first_name . ' ' . $owner->person->last_name;
                                            } else {
                                                $personName = $owner->person->first_name . ' ' . $owner->person->middle_name[0] . '. ' . $owner->person->last_name;
                                            }
                                        }
                                        
                                        if ($personName != null && $owner->corporate->corporate_name != null) {
                                            $representative = $personName . '/' . $owner->corporate->corporate_name;
                                        } elseif ($personName == null) {
                                            $representative = $owner->corporate->corporate_name;
                                        } else {
                                            $representative = $personName;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $plan->series_no }}</td>
                                        <td>{{ date('m/d/Y', strtotime($plan->date_received)) }}</td>
                                        <td><a href="/fsec/{{ $plan->id }}" target="_parent">{{ $representative }}</a>
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
            </x-modal>
        </x-pageWrapper>
    </div>
@endsection
