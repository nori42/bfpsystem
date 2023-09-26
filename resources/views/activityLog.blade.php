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
                <form action="/activity" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold" for="fromDate">From</label>
                    <input class="form-control" type="date" id="activityDateFrom" name="activityDateFrom"
                        style="width:18rem;" value="" required>

                    <label class="fw-bold" for="fromDate">To</label>
                    <input class="form-control" type="date" id="activityDateTo" name="activityDateTo"
                        style="width:18rem;" value="" required>
                    <button id="btnViewActivity" class="btn btn-primary">View Activity</button>
                </form>
            </div>

            {{-- Loading --}}
            <h2 class="text-secondary text-center mt-5 d-none" id="loadingMssg">Fetching Activity...</h2>
            <div id="activityContent">
                <div class="my-3 float-end fw-bold fs-5">
                    @if ($dateRange[0] != null && $dateRange[1] != null && $dateRange[0] != $dateRange[1])
                        <div>
                            <span>{{ date('F d, Y', strtotime($dateRange[0])) }}</span>
                            <span> - </span>
                            <span>{{ date('F d, Y', strtotime($dateRange[1])) }}</span>
                        </div>
                    @else
                        @if ($dateRange[0] == null)
                            <span>{{ date('F d, Y', strtotime($dateQuery)) }}</span>
                        @else
                            <span>{{ date('F d, Y', strtotime($dateRange[0])) }}</span>
                        @endif
                    @endif
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

    <script defer>
        const dateFrom = document.querySelector(["#activityDateFrom"])
        const dateTo = document.querySelector(["#activityDateTo"])

        const loadingMssg = document.querySelector(["#loadingMssg"])
        const activtiyContent = document.querySelector(["#activityContent"])

        document.querySelector('#btnViewActivity').addEventListener('click', () => {
            if (dateFrom.value != "" && dateTo.value != "") {
                loadingMssg.classList.remove('d-none')
                activtiyContent.classList.add('d-none')
            }
        })

        dateFrom.addEventListener('change', () => {
            dateTo.value = dateFrom.value
        })
    </script>
@endsection
