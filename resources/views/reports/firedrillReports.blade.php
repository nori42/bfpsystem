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
                <option value="inspection">Inspection Reports</option>
                <option value="firedrill" selected>Firedrill Reports</option>
                <option value="buildingplan">Building Plan Reports</option>
            </select>
            <hr>
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
            <iframe id="iFrameFiredrill" src="{{ env('APP_URL') }}/reports/print/firedrill" frameborder="0" width="100%"
                height="800px"></iframe>
        </x-pageWrapper>
    </div>
    <script src="{{ asset('js/reports/reportsScript.js') }}"></script>
    <script>
        const APP_URL = "{{ env('APP_URL') }}";
        const yearlyReports = @json($reports);
        const yearSelect = document.getElementById('year');
        const monthSelect = document.getElementById('month');

        const iframeFiredrill = document.querySelector("#iFrameFiredrill")

        yearSelect.addEventListener('change', () => {
            updateMonth(yearSelect.value)
            iframeFiredrill.src =
                `${APP_URL}/reports/print/firedrill?month=${monthSelect.value}&year=${yearSelect.value}`
        })

        monthSelect.addEventListener('change', () => {
            iframeFiredrill.src =
                `${APP_URL}/reports/print/firedrill?month=${monthSelect.value}&year=${yearSelect.value}`
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

            console.log(yearlyReports)

            for (let i = 0; i < yearlyReports[year].length; i++) {
                const month = months[yearlyReports[year][i].month - 1];
                const option = document.createElement('option');
                option.value = month.value;
                option.textContent = month.name;
                monthSelect.appendChild(option);
            }
        }

        function displayReport(substation, issuedInMonthAll, issuedInMonthNew) {

        }

        async function fetchReport() {
            try {

                const hostUrl = "{{ env('APP_URL') }}"
                const response = await fetch(hostUrl +
                    `/resources/reports/fsic?year=${yearSelect.value}&month=${monthSelect.value}`)

                const json = await response.json();
                const reports = json.data


                displayReport(reports.substation, reports.issuedInMonthAll, reports.issuedInMonthNew)
            } catch (err) {
                console.log(err)
            }
        }

        fetchReport()

        iframeFiredrill.src =
            `${APP_URL}/reports/print/firedrill?month=${monthSelect.value}&year=${yearSelect.value}`
    </script>
@endsection
