{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <style>
        #filter {
            width: 656px;
        }

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
            {{-- {{ dd($reports) }} --}}
            <select name="reports" id="reportsSelect" class="w-50 fs-4 form-select">
                {{-- I added if statement this way so that the order doesnt change --}}
                @if (auth()->user()->type == 'ADMIN')
                    <option value="inspection">Inspection Reports</option>
                @endif

                <option value="firedrill" selected>Firedrill Reports</option>

                @if (auth()->user()->type == 'ADMIN')
                    <option value="buildingplan">Building Plan Reports</option>
                @endif
            </select>
            <hr>

            @if (count($reports) != 0)
                <div id="filter" class="my-2 d-flex align-items-center gap-2 w-100">
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

                    <label for="unclaimed">Unclaimed</label>
                    <input class="form-check" type="checkbox" name="unclaimed" id="unclaimed"
                        {{ $selectedReports['unclaimed'] ? 'checked' : '' }}>

                    <button class="btn btn-success" id="viewReport">View Report</button>
                </div>
                <div class="bg-subtleBlue p-5" style="max-width:28rem; box-shadow:0px 3px 4px gray;">
                    <div class="fs-4">Firedrill Certificate Issued</div>
                    <div>{{ DateTime::createFromFormat('!m', $selectedReports['month'])->format('F') }}
                        {{ $selectedReports['year'] }}</div>
                    <div class="mt-4 fs-4">Substation</div>
                    <table style="width: 16rem;">
                        @foreach ($firedrillIssued['issuedBySubstation'] as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <table class="mt-4" style="width:16rem;">
                        <tr>
                            <td class="fw-bold">CBP</td>
                            <td>{{ $firedrillIssued['CBP'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total Substations</td>
                            <td>{{ $firedrillIssued['totalSubstation'] }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Grand Total</td>
                            <td>{{ $firedrillIssued['totalGrand'] }}</td>
                        </tr>

                        <tr>
                            <td class="fw-bold">Unclaimed</td>
                            <td>{{ $firedrillIssued['unclaimed'] }}</td>
                        </tr>
                    </table>
                </div>
                <hr>

                @php
                    //This is the query parameter for unclaimed firedrill
                    $queryParam = "month={$selectedReports['month']}&year={$selectedReports['year']}";
                    
                    //This is the query parameter for claimed firedrill
                    if ($selectedReports['unclaimed']) {
                        $queryParam = "month={$selectedReports['month']}&year={$selectedReports['year']}&unclaimed=true";
                    }
                @endphp
                <iframe id="iFrameFiredrill" src="{{ env('APP_URL') }}/reports/print/firedrill?{{ $queryParam }}"
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

    @if (count($reports) != 0)
        <script>
            const yearlyReports = @json($reports);
            const yearSelect = document.getElementById('year')
            const monthSelect = document.getElementById('month')
            const claimed = document.querySelector('#claimed')
            const btnViewRerport = document.querySelector('#viewReport')

            const iframeFiredrill = document.querySelector("#iFrameFiredrill")

            yearSelect.addEventListener('change', () => {
                updateMonth(yearSelect.value)
            })

            btnViewRerport.addEventListener('click', () => {
                if (unclaimed.checked) {
                    location.href =
                        `/reports/firedrill?selectedYear=${yearSelect.value}&selectedMonth=${monthSelect.value}&unclaimed=true`
                    return
                }
                location.href = `/reports/firedrill?selectedYear=${yearSelect.value}&selectedMonth=${monthSelect.value}`
            })

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

                console.log(yearlyReports)

                for (let i = 0; i < yearlyReports[year].length; i++) {
                    const month = months[yearlyReports[year][i].month - 1];
                    const option = document.createElement('option');
                    option.value = month.value;
                    option.textContent = month.name;
                    monthSelect.appendChild(option);
                }
            }
        </script>
    @endif
@endsection
