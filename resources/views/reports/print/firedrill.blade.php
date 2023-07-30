<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/main.scss', 'resources/css/reports.css'])

    <style>
        .fs-7 {
            font-size: 0.725rem;
        }

        th span {
            cursor: pointer !important;
        }

        td,
        th {
            /* white-space: nowrap; */
        }

        @media print {

            body {
                font-size: 6pt !important;
            }

            td,
            th {
                white-space: normal;
            }


        }
    </style>
</head>
{{-- {{ dd($debug) }} --}}

<body>
    <div class="py-3 bg-white position-sticky w-100 top-0">
        <button class="btn btn-primary border-0" onclick="print()"> <i class="bi bi-printer-fill"></i>
            Print</button>
        <button class="btn btn-primary border-0" onclick="exportTableToXLSX('firedrillIssued','firedrillIssued.xlsx')">
            <i class="bi bi-filetype-xlsx"></i>
            Export to Excel</button>
        <div class="d-inline">
            <input class="align-middle" type="checkbox" name="myReport" id="myReport"
                style="height: 1.325rem; width: 1.325rem;" {{ $selfReport ? 'checked' : '' }}>
            <label for="myReport" class="fw-bold">My Reports</label>
            <input class="align-middle" type="checkbox" name="unclaimed" id="unclaimed"
                style="height: 1.325rem; width: 1.325rem; margin-left: 8px;" {{ $unclaimed ? 'checked' : '' }}>
            <label for="unclaimed" class="fw-bold">Unclaimed</label>
        </div>
    </div>
    <div class="printables">
        <div class="d-flex align-items-center justify-content-between heading">
            <div class="fs-3">Firedrill Issued</div>
            <div class="fs-4">
                <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                @if ($dateRange['from'] != $dateRange['to'])
                    <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                @endif
            </div>
        </div>
        <table id="firedrillIssued" class="table">
            <thead>
                <th><span class="cursor-pointer" onclick="sort(0)">Control No.</span></th>
                <th><span onclick="sort(1)">Date of Drill</span></th>
                <th><span onclick="sort(2)">Establishment</span></th>
                <th><span onclick="sort(3)">Owner</span></th>
                <th><span onclick="sort(4)">Issued On</span></th>
                <th><span onclick="sort(5)">Validity</span></th>
                <th><span onclick="sort(6)">O.R Number</span></th>
                <th><span onclick="sort(7)">Amount</span></th>
                <th><span onclick="sort(8)">Date of Payment</span></th>
                @if (!$unclaimed)
                    <th><span onclick="sort(9)">Claimed By</span></th>
                    <th><span onclick="sort(10)">Date Claimed</span></th>
                @endif
            </thead>
            <tbody>
                @foreach ($firedrills as $firedrill)
                    @php
                        $company = $firedrill->establishment->owner->corporate;
                        $person = $firedrill->establishment->owner->person;
                        $representative = null;
                        
                        $personName = $person->first_name . ' ' . $person->last_name;
                        
                        if ($company->corporate_name != null && $person->last_name != null) {
                            $representative = $company->corporate_name . '/' . $personName;
                        } elseif ($company->corporate_name == null) {
                            $representative = $personName;
                        } else {
                            $representative = $company->corproate_name;
                        }
                        
                    @endphp
                    <tr class="align-middle">
                        <td>{{ $firedrill->control_no }}</td>
                        <td>{{ date('m/d/Y', strtotime($firedrill->date_made)) }}</td>
                        <td>
                            @if ($unclaimed)
                                <a href="/establishments/{{ $firedrill->establishment->id }}/firedrill"
                                    target="_parent">
                                    {{ $firedrill->establishment->establishment_name }}
                                </a>
                            @else
                                {{ $firedrill->establishment->establishment_name }}
                            @endif
                        </td>
                        <td>{{ $representative }}</td>
                        <td>{{ $firedrill->issued_on ? date('m/d/Y', strtotime($firedrill->issued_on)) : '' }}</td>
                        <td>{{ $firedrill->validity_term }}</td>
                        <td>{{ $firedrill->receipt->or_no }}</td>
                        <td>&#8369;{{ $firedrill->receipt->amount }}</td>
                        <td>{{ date('m/d/Y', strtotime($firedrill->receipt->date_of_payment)) }}</td>
                        @if (!$unclaimed)
                            <td>{{ $firedrill->claimed_by }}</td>
                            <td>{{ $firedrill->claimed_by ? date('m/d/Y', strtotime($firedrill->date_claimed)) : '' }}
                        @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</body>

<script src="{{ asset('js/reports/xlsx.full.min.js') }}"></script>
<script src="{{ asset('js/reports/exportToXLSX.js') }}"></script>
<script src="{{ asset('js/reports/tableSort.js') }}"></script>
<script>
    const checkboxMyReport = document.querySelector('#myReport')
    const checkboxUnclaimed = document.querySelector('#unclaimed')
    const year = "{{ $date['year'] }}"
    const month = "{{ $date['monthInt'] }}"
    const unclaimed = "{{ $unclaimed }}"

    const dateFrom = "{{ $dateRange['from'] }}"
    const dateTo = "{{ $dateRange['to'] }}"

    function checkBoxChange() {
        let baseParam = `/reports/print/firedrill?dateFrom=${dateFrom}&dateTo=${dateTo}`

        if (checkboxMyReport.checked) {
            baseParam = `${baseParam}&selfReport=${checkboxMyReport.checked}`
        }

        if (checkboxUnclaimed.checked) {
            baseParam = `${baseParam}&unclaimed=${checkboxUnclaimed.checked}`
        }

        location.href = baseParam
    }

    checkboxMyReport.addEventListener('change', checkBoxChange)

    checkboxUnclaimed.addEventListener('change', checkBoxChange)

    function sort(index) {
        const tableId = 'firedrillIssued'
        sortTable(index, tableId)
    }
</script>

</html>
