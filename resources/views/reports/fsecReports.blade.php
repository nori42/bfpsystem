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
    {{-- {{ dd($reports) }} --}}
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            {{-- {{ dd($reports) }} --}}
            <select name="reports" id="reportsSelect" class="w-50 fs-4 form-select">
                {{-- I added if statement this way so that the order doesnt change --}}
                @if (auth()->user()->type == 'ADMIN')
                    <option value="inspection">Inspection Reports</option>
                @endif

                @if (auth()->user()->type == 'ADMIN')
                    <option value="firedrill">Firedrill Reports</option>
                @endif

                <option value="buildingplan" selected>Building Plan Reports</option>
            </select>
            <hr>
            @if (count($reports) != 0)
                <div class="d-inline-block" id="printables">
                    <div id="filter" class="my-2 d-flex align-items-center gap-2">
                        <label for="month">Month</label>
                        <select class="form-select" name="month" id="month">
                        </select>

                        <label for="month">Year</label>
                        <select class="form-select" name="year" id="year">
                            @foreach ($yearReports as $y)
                                <option value="{{ $y->year }}">{{ $y->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <iframe id="iFrameFsec" src="{{ env('APP_URL') }}/reports/print/fsec" frameborder="0" width="100%"
                    height="800px"></iframe>
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
            const yearSelect = document.getElementById('year');
            const monthSelect = document.getElementById('month');

            const iframeFsec = document.querySelector("#iFrameFsec")

            yearSelect.addEventListener('change', () => {
                updateMonth(yearSelect.value)
                iframeFsec.src =
                    `${APP_URL}/reports/print/fsec?month=${monthSelect.value}&year=${yearSelect.value}`
            })

            monthSelect.addEventListener('change', () => {
                iframeFsec.src =
                    `${APP_URL}/reports/print/fsec?month=${monthSelect.value}&year=${yearSelect.value}`
            })


            if (yearlyReports[new Date().getFullYear()]) {
                updateMonth(new Date().getFullYear())
            } else {
                updateMonth(new Date().getFullYear() - 1)
            }

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

            iframeFsec.src =
                `${APP_URL}/reports/print/fsec?month=${monthSelect.value}&year=${yearSelect.value}`
        </script>
    @endif
@endsection
