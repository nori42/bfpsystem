{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <style>
        @media print {

            body,
            #filter {
                visibility: hidden;
            }

            #printables {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                translate: (-50%, 0);
                page-break-after: always;
                display: block !important;
            }

            .report-buttons {
                display: none;
            }
        }
    </style>
    <div class="page-content">
        {{-- Put page content here --}}
        @if (session('toastMssg') != null)
            <x-toast :message="session('toastMssg')" />
        @endif
        <x-pageWrapper>
            <div class="d-flex align-items-center gap-3">
                <select name="reports" id="reportsSelect" class="w-50 fs-4 form-select">
                    <option value="inspection">Inspection Reports</option>
                    @if (auth()->user()->type == 'ADMINISTRATOR')
                        <option value="firedrill">Firedrill Reports</option>
                        <option value="buildingplan">Building Plan Reports</option>
                    @endif
                </select>
            </div>
            <hr>

            <div id="filter" class="my-2 d-flex align-items-center gap-2">

                {{-- <label for="month">Month</label>
                    <select class="form-select" name="month" id="month" style="width:21rem;">
                        @foreach ($monthReports as $m)
                            @if ($selectedReports['month'] == $m->month)
                                <option value="{{ $m->month }}" selected>
                                    {{ DateTime::createFromFormat('!m', $m->month)->format('F') }}
                                </option>
                            @else
                                <option value="{{ $m->month }}">
                                    {{ DateTime::createFromFormat('!m', $m->month)->format('F') }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <select class="form-select" name="year" id="year" style="width:21rem;">
                        @foreach ($yearReports as $y)
                            @if ($selectedReports['year'] == $y->year)
                                <option value="{{ $y->year }}" selected>{{ $y->year }}</option>
                            @else
                                <option value="{{ $y->year }}">{{ $y->year }}</option>
                            @endif
                        @endforeach
                    </select> --}}
                <form action="/reports/fsic" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold" for="fromDate">From</label>
                    <input class="form-control" type="date" id="dateFrom" name="dateFrom" style="width:18rem;"
                        value="" required>

                    <label class="fw-bold" for="toDate">To</label>
                    <input class="form-control" type="date" id="dateTo" name="dateTo" style="width:18rem;"
                        value="" required>
                    <button class="btn btn-success" id="viewReport">View Report</button>

                    @if ($dateRange['from'] != null && $dateRange['to'] != null)
                        <div class="position-relative">
                            <button class="btn btn-success" id="viewSummary" type="button"
                                onclick="toggleShow('reportSummary')">View
                                Summary
                                <i class="bi bi-caret-down-fill text-white fs-6"></i>
                            </button>
                            <div id="reportSummary" class="position-absolute" id="printables" dropdown-menu
                                style="display: none !important; ">
                                <div class="bg-subtleBlue p-5" style="width:28rem; box-shadow:0px 3px 4px gray;">
                                    <div class="fs-4">Inspection Certificate Issued</div>
                                    <div class="fw-semibold">
                                        <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                                        @if ($dateRange['from'] != $dateRange['to'])
                                            <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-4 fs-4">Substation</div>

                                    @php
                                        $substations = ['Guadalupe', 'Labangon', 'Lahug', 'Mabolo', 'Pahina Central', 'Pardo', 'Pari-an', 'San Nicolas', 'Talamban '];
                                    @endphp

                                    <table style="width: 16rem;">
                                        @foreach ($substations as $substation)
                                            <tr>
                                                <td>{{ $substation }}</td>
                                                <td>{{ $fsicIssued['substations']->get(strtoupper($substation)) ? $fsicIssued['substations']->get(strtoupper($substation))->count() : 0 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <table class="mt-4" style="width:16rem;">
                                        <tr>
                                            <td class="fw-bold">CBP</td>
                                            <td>{{ $fsicIssued['totalCBP'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Total Substations</td>
                                            <td>{{ $fsicIssued['totalSubstation'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Grand Total</td>
                                            <td>{{ $fsicIssued['totalGrand'] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">New</td>
                                            <td>{{ $fsicIssued['totalNew'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
            <div id="pageContent">
                @if ($dateRange['from'] != null && $dateRange['to'] != null)
                    <iframe id="iFrameInspections"
                        src="{{ env('APP_URL') }}/reports/print/fsic?dateFrom={{ $dateRange['from'] }} &dateTo={{ $dateRange['to'] }}"
                        frameborder="0" width="100%" height="900px"></iframe>
                @else
                    <h1 class="text-secondary fs-2 mt-3">Select a date range</h1>
                @endif
            </div>
            {{-- Loading Message --}}
            <h2 class="text-secondary text-center mt-5 d-none" id="loadingMssg">Fetching Reports...</h2>

        </x-pageWrapper>
    </div>
    <script src="{{ asset('js/reports/reportsScript.js') }}"></script>
    <script>
        const APP_URL = "{{ env('APP_URL') }}";
        initReportLink(APP_URL);
    </script>
    {{-- @if (count($yearReports) != 0)
        <script>
            const yearlyReports = @json($reports);

            const yearSelect = document.querySelector('#year');
            const monthSelect = document.querySelector('#month')
            const btnViewRerport = document.querySelector('#viewReport')

            function updateMonth(year) {

                const months = [{
                        value: 1,
                        name: 'January'
                    },
                    {
                        value: 2,
                        name: 'February'
                    },
                    {
                        value: 3,
                        name: 'March'
                    },
                    {
                        value: 4,
                        name: 'April'
                    },
                    {
                        value: 5,
                        name: 'May'
                    },
                    {
                        value: 6,
                        name: 'June'
                    },
                    {
                        value: 7,
                        name: 'July'
                    },
                    {
                        value: 8,
                        name: 'August'
                    },
                    {
                        value: 9,
                        name: 'September'
                    },
                    {
                        value: 10,
                        name: 'October'
                    },
                    {
                        value: 11,
                        name: 'November'
                    },
                    {
                        value: 12,
                        name: 'December'
                    }
                ];

                monthSelect.innerHTML = "";
                for (let i = 0; i < yearlyReports[year].length; i++) {
                    const month = months[yearlyReports[year][i].month - 1];
                    const option = document.createElement('option');
                    option.value = month.value;
                    option.textContent = month.name;
                    monthSelect.appendChild(option);
                }
            }

            btnViewRerport.addEventListener('click', () => {
                location.href = `/reports/fsic?selectedYear=${yearSelect.value}&selectedMonth=${monthSelect.value}`
            })

            yearSelect.addEventListener('change', () => {
                updateMonth(yearSelect.value)
            })
        </script>
    @endif() --}}
@endsection
