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
            }
        }
    </style>
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            {{-- {{ dd($reports) }} --}}
            <h1>Inspection Report</h1>
            <hr>
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
                <div class="bg-success text-white p-2">
                    <h1>Reports</h1>
                    <h3> <span id="monthLabel">February</span> <span id="yearLabel">2023</span></h3>
                </div>
                {{-- <div style="width: 800px;"><canvas id="certificateIssued"></canvas></div> --}}
                <div class="px-4 py-5 bg-subtleBlue d-inline-block">
                    <div class="row w-100">
                        <div class="col fw-bold">Substation</div>
                        <div class="col"></div>
                    </div>
                    <div id="substations" class="row bg-subtleBlue" style="width: 21rem">
                        <div class="col">test</div>
                        <div class="col">5</div>
                    </div>
                    <div class="my-4">
                        <div class="row">
                            <div class="col fw-bold">CBP</div>
                            <div id="cbp" class="col"></div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">NEW</div>
                            <div id="newIssued" class="col"></div>
                        </div>
                    </div>

                    <div class="my-4">
                        <div class="row">
                            <div class="col fw-bold">Total Substations</div>
                            <div id="totalSubstation" class="col"></div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">Grand Total</div>
                            <div id="totalGrand" class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </x-pageWrapper>
    </div>
    <script>
        const yearlyReports = @json($reports);

        const yearSelect = document.getElementById('year');
        const monthSelect = document.getElementById('month');

        if (yearlyReports[new Date().getFullYear()].length != 0) {
            updateMonth(new Date().getFullYear())
        } else {
            updateMonth(new Date().getFullYear() - 1)
        }

        yearSelect.addEventListener('change', () => {
            updateMonth(yearSelect.value)
            fetchReport()
        })

        monthSelect.addEventListener('change', () => {
            fetchReport()
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
                    <div class="row">
                        <div class="col">${prop}</div>
                        <div class="col">${substation[prop]}</div>
                    </div>
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
            } catch (err) {}
        }
    </script>
@endsection
