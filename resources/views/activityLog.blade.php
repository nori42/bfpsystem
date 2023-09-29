{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        @if (session('toastMssg') != null)
            <x-toast :message="session('toastMssg')" />
        @endif

        <x-pageWrapper>
            <div class="d-flex align-items-center gap-4">
                <div>
                    <span class="d-block fw-bold fs-3">Activity log</span>
                    <span class="text-secondary">List of user's activity</span>
                </div>
                {{-- <form action="/activity" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold" for="fromDate">From</label>
                    <input class="form-control" type="date" id="activityDateFrom" name="activityDateFrom"
                        style="width:18rem;" value="" required>

                    <label class="fw-bold" for="fromDate">To</label>
                    <input class="form-control" type="date" id="activityDateTo" name="activityDateTo"
                        style="width:18rem;" value="" required>
                    <button id="btnViewActivity" class="btn btn-primary">View Activity</button>
                </form> --}}
            </div>

            {{-- Loading --}}
            <h2 class="text-secondary text-center mt-5 d-none" id="loadingMssg">Fetching Activity...</h2>
            <div id="activityContent">
                <div class="d-flex align-items-center justify-content-between my-3">
                    <form id="filter" class="d-flex gap-3 align-items-center" action="/activity">

                        <x-dateFilter :dateRange="['from' => $dateRange['from'], 'to' => $dateRange['to']]" />

                        @if ($dateRange['from'] != null)
                            <div class="d-flex align-items-center gap-2">
                                <label for="fsec" class="fs-5 fw-semibold">FSEC</label>
                                <input type="radio" class="mr-2" name="activityIn" id="fsec" value="FSEC"
                                    {{ $activityIn == 'FSEC' ? 'checked' : '' }} checkboxquery>
                                <label for="fsic" class="fs-5 fw-semibold">FSIC</label>
                                <input type="radio" class="mr-2" name="activityIn" id="fsic" value="FSIC"
                                    {{ $activityIn == 'FSIC' ? 'checked' : '' }} checkboxquery>
                                <label for="firedrill" class="fs-5 fw-semibold">FIREDRILL</label>
                                <input type="radio" class="mr-2" name="activityIn" id="firedrill" value="FIREDRILL"
                                    {{ $activityIn == 'FIREDRILL' ? 'checked' : '' }} checkboxquery>
                                {{-- <label for="users" class="fs-5 fw-semibold">USERS</label>
                                <input type="radio" class="mr-2" name="activityIn" id="users" value="USERS"
                                    {{ $activityIn == 'USERS' ? 'checked' : '' }} checkboxquery> --}}
                                <label for="all" class="fs-5 fw-semibold">ALL</label>
                                <input type="radio" class="mr-2" name="activityIn" id="all" value="ALL"
                                    {{ $activityIn == 'ALL' ? 'checked' : '' }} checkboxquery>
                            </div>
                        @endif
                    </form>
                    <input type="hidden" name="dateFromCurrent" id="dateFromCurrent" value="{{ $dateRange['from'] }}">
                    <input type="hidden" name="dateToCurrent" id="dateToCurrent" value="{{ $dateRange['to'] }}">
                    <div class="fs-6 fw-semibold">{{ $activities->count() }} Result{{ $activities->count() > 1 ? 's' : '' }}
                    </div>
                    <div class="my-3 fw-semibold fs-6">
                        @if ($dateRange['from'] != null && $dateRange['to'] != null && $dateRange['from'] != $dateRange['to'])
                            <div>
                                <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                                <span> - </span>
                                <span>{{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                            </div>
                        @else
                            @if ($dateRange['from'] == null)
                                <span>{{ date('F d, Y', strtotime($dateQuery)) }}</span>
                            @else
                                <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                            @endif
                        @endif
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <th>User Type</th>
                        <th>User</th>
                        <th>Log</th>
                        <th>Date and Time</th>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            @php
                                $name = $activity->first_name . ' ' . $activity->last_name;
                            @endphp
                            <tr>
                                <td>{{ $activity->type }}</td>
                                <td>{{ strtoupper($name) }}</td>
                                <td>{{ $activity->activity }}</td>
                                <td>{{ date('m/d/Y g:i A', strtotime($activity->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($activities == null || count($activities) == 0)
                    <h2 class="text-secondary">No Activity</h2>
                @endif
            </div>
        </x-pageWrapper>
    </div>

@section('page-script')
    @vite(['/resources/js/pages/activitylogs.js'])
@endsection
@endsection
