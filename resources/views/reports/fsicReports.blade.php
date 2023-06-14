{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    @php
        $subsationsIssued = [
            'GUADALUPE' => 279,
            'LABANGON' => 95,
            'LAHUG' => 109,
            'MABOLO' => 223,
            'PAHINA CENTRAL' => 272,
            'PARDO' => 167,
            'PARI-AN' => 116,
            'SAN NICOLAS' => 185,
            'TALAMBAN' => 145,
        ];
        
        $monthsString = [];
    @endphp
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
            {{-- {{ dd($reports) }} --}}
            {{-- <h1>Inspection Report</h1> --}}
            <select name="reports" id="reportsSelect" class="w-50 fs-4 form-select">
                <option value="inspection">Inspection Reports</option>
                <option value="firedrill">Firedrill Reports</option>
                <option value="buildingplan">Building Plan Reports</option>
            </select>
            <hr>

            @if (count($reports) != 0)
                <div class="d-inline-block" id="printables">
                    <div id="filter" class="my-2 d-flex align-items-center gap-2">
                        <label for="month">Month</label>
                        <select class="form-select" name="month" id="month">
                            {{-- @foreach ($monthReports as $m)
                            {{ array_push($monthsString, DateTime::createFromFormat('!m', $m)->format('F')) }}
                            <option value="{{ $m }}">
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                        @endforeach --}}
                        </select>

                        <label for="month">Year</label>
                        <select class="form-select" name="year" id="year">
                            @foreach ($yearReports as $y)
                                <option value="{{ $y->year }}">{{ $y->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="bg-subtleBlue p-5">
                        <div class="report-buttons">
                            {{-- <button class="btn btn-primary border-0" onclick="print()"> <i class="bi bi-printer-fill"></i>
                            Print</button> --}}
                        </div>
                        <div class="fs-3">Inspections Summary</div>
                        <div class="fw-bold"><span id="monthLabel"></span> <span id="yearLabel"></span></div>
                        <div class="mt-4 fs-4">Substation</div>
                        <div class="d-flex align-items-start gap-5">
                            <div id="substations"
                                style="display: grid; grid-template-columns: auto auto; min-width: 16rem;">
                            </div>
                            <div style="display: grid; grid-template-columns: auto auto; min-width: 16rem;">
                                <div class="fw-bold">CBP</div>
                                <div id="cbp" class="mx-4">null</div>

                                <div class="fw-bold">NEW</div>
                                <div id="newIssued" class="mx-4">null</div>

                                <div class="fw-bold">Total Substations</div>
                                <div id="totalSubstation" class="mx-4">null</div>

                                <div class="fw-bold">Grand Total</div>
                                <div id="totalGrand" class="mx-4">null</div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <iframe id="iFrameInspections" src="" frameborder="0" width="100%" height="800px"></iframe>
            @else
                <h2>Nothing to show</h2>
            @endif
        </x-pageWrapper>
    </div>
    <script src="{{ asset('js/reports/reportsScript.js') }}"></script>
    <script>
        const APP_URL = "{{ env('APP_URL') }}";
        const yearlyReports = @json($reports);

        const yearSelect = document.querySelector('#year');
        const monthSelect = document.querySelector('#month');

        const iframeInpsections = document.querySelector("#iFrameInspections")


        yearSelect.addEventListener('change', () => {
            updateMonth(yearSelect.value)
            fetchReport()

            iframeInpsections.src =
                `${APP_URL}/reports/print/fsic?month=${monthSelect.value}&year=${yearSelect.value}`
        })

        monthSelect.addEventListener('change', () => {
            fetchReport()
            iframeInpsections.src =
                `${APP_URL}/reports/print/fsic?month=${monthSelect.value}&year=${yearSelect.value}`
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

        function displayReport(substation, issuedInMonthAll, issuedInMonthNew) {
            const substations = document.querySelector('#substations')
            const newIssued = document.querySelector('#newIssued')
            const totalSubstationsEl = document.querySelector('#totalSubstation')
            const totalGrand = document.querySelector('#totalGrand')
            const cbp = document.querySelector('#cbp')

            const yearLabel = document.querySelector('#yearLabel')
            const monthLabel = document.querySelector('#monthLabel')


            let totalSubstation = 0;

            substations.innerHTML = ""
            cbp.textContent = substation["CBP"]

            newIssued.textContent = issuedInMonthNew
            totalGrand.textContent = issuedInMonthAll

            yearLabel.textContent = yearSelect.value;
            monthLabel.textContent = monthSelect.selectedOptions[0].text;

            for (const prop in substation) {
                if (prop == "CBP")
                    continue;

                substations.innerHTML +=
                    `
                        <div>${prop}</div>
                        <div>${substation[prop]}</div>
                `
                totalSubstation += substation[prop];
            }

            totalSubstationsEl.textContent = totalSubstation;
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

        iframeInpsections.src =
            `${APP_URL}/reports/print/fsic?month=${monthSelect.value}&year=${yearSelect.value}`
    </script>
@endsection
