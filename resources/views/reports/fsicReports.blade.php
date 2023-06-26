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
        <x-pageWrapper>
            <div class="d-flex align-items-center gap-3">
                <select name="reports" id="reportsSelect" class="w-50 fs-4 form-select">
                    <option value="inspection">Inspection Reports</option>
                    @if (auth()->user()->type == 'ADMIN')
                        <option value="firedrill">Firedrill Reports</option>
                        <option value="buildingplan">Building Plan Reports</option>
                    @endif
                </select>
            </div>
            <hr>

            @if (count($yearReports) != 0)
                <div id="filter" class="my-2 d-flex align-items-center gap-2">

                    <label for="month">Month</label>
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
                    </select>
                    {{-- <div class="fs-6">
                        <input class="fs-2 align-middle" type="checkbox" name="myReport" id="myReport"
                            style="height: 1rem; width: 1.325rem;">
                        <label for="myReport">My Reports</label>
                    </div> --}}
                    <button class="btn btn-success" id="viewReport">View Report</button>
                </div>
                <div class="d-inline-block" id="printables">
                    <div class="bg-subtleBlue p-5" style="max-width:28rem; box-shadow:0px 3px 4px gray;">
                        <div class="fs-4">Inspection Certificate Issued</div>
                        <div>{{ DateTime::createFromFormat('!m', $selectedReports['month'])->format('F') }}
                            {{ $selectedReports['year'] }}</div>
                        <div class="mt-4 fs-4">Substation</div>
                        <table style="width: 16rem;">
                            @foreach ($fsicIssued['issuedBySubstation'] as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <table class="mt-4" style="width:16rem;">
                            <tr>
                                <td class="fw-bold">CBP</td>
                                <td>{{ $fsicIssued['CBP'] }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">New</td>
                                <td>{{ $fsicIssued['new'] }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total Substations</td>
                                <td>{{ $fsicIssued['totalSubstation'] }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Grand Total</td>
                                <td>{{ $fsicIssued['totalGrand'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <iframe id="iFrameInspections"
                    src="{{ env('APP_URL') }}/reports/print/fsic?month={{ $selectedReports['month'] }}&year={{ $selectedReports['year'] }}"
                    frameborder="0" width="100%" height="800px"></iframe>
            @else
                <h2>Nothing to show</h2>
            @endif

        </x-pageWrapper>
    </div>
    <script src="{{ asset('js/reports/reportsScript.js') }}"></script>
    <script>
        const APP_URL = "{{ env('APP_URL') }}";
        initReportLink(APP_URL);
    </script>
    @if (count($yearReports) != 0)
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
    @endif()
@endsection
