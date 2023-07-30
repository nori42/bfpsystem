<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/main.scss', 'resources/css/reports.css'])
</head>
<style>
    th span {
        cursor: pointer !important;
    }
</style>

<body>

    <div class="py-3 bg-white position-sticky w-100 top-0">
        <button class="btn btn-primary border-0" onclick="print()"> <i class="bi bi-printer-fill"></i>
            Print</button>
        <button class="btn btn-primary border-0"
            onclick="exportTableToXLSX('inspectionIssued','inspectionIssued.xlsx')"> <i class="bi bi-filetype-xlsx"></i>
            Export to Excel</button>
        <div class="d-inline">
            <input class="align-middle" type="checkbox" name="myReport" id="myReport"
                style="height: 1.325rem; width: 1.325rem;" {{ $selfReport ? 'checked' : '' }}>
            <label for="myReport" class="fw-bold">My Reports</label>
        </div>
    </div>
    <div class="printables">
        <div class="d-flex align-items-center justify-content-between heading">
            <div class="fs-3">Inpsections Certificate Issued</div>
            <div class="fs-4">
                <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                @if ($dateRange['from'] != $dateRange['to'])
                    <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                @endif
            </div>
        </div>
        <table id="inspectionIssued" class="table">
            <thead>
                <th><span onclick="sort(0)">Fire Safety Inspection No.(FSIC No.)</span></th>
                <th><span onclick="sort(1)">Registration Status</span></th>
                <th><span onclick="sort(2)">Establishment Name</span></th>
                <th><span onclick="sort(3)">Address</span></th>
                <th><span onclick="sort(4)">Issued Date</span></th>
                <th><span onclick="sort(5)">Substation</span></th>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                    <tr class="align-middle">
                        <td>{{ $inspection->fsic_no }}</td>
                        <td>{{ $inspection->registration_status }}</td>
                        <td>{{ $inspection->establishment->establishment_name }}</td>
                        <td>{{ $inspection->establishment->address }}</td>
                        <td>{{ date('m/d/Y', strtotime($inspection->issued_on)) }}</td>
                        <td>{{ $inspection->establishment->substation }}</td>
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
    const year = "{{ $date['year'] }}"
    const month = "{{ $date['monthInt'] }}"

    const dateFrom = "{{ $dateRange['from'] }}"
    const dateTo = "{{ $dateRange['to'] }}"

    checkboxMyReport.addEventListener('change', () => {
        if (checkboxMyReport.checked) {
            location.href =
                `/reports/print/fsic?dateFrom=${dateFrom}&dateTo=${dateTo}&selfReport=${checkboxMyReport.checked}`

            return
        }

        location.href = `/reports/print/fsic?dateFrom=${dateFrom}&dateTo=${dateTo}`
    })

    function sort(index) {
        const tableId = 'inspectionIssued'
        sortTable(index, tableId)
    }
</script>

</html>
