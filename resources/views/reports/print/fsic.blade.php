<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/bootstrap.scss', 'resources/css/reports.css'])
</head>

<body>
    <div class="py-3 bg-white position-sticky w-100 top-0">
        <button class="btn btn-primary border-0" onclick="print()"> <i class="bi bi-printer-fill"></i>
            Print</button>
        <button class="btn btn-primary border-0"
            onclick="exportTableToXLSX('inspectionIssued','inspectionIssued.xlsx')"> <i class="bi bi-filetype-xlsx"></i>
            Export to Excel</button>
    </div>
    <div class="printables">
        <div class="d-flex align-items-center justify-content-between heading">
            <div class="fs-3">Inpsections Issued</div>
            <div class="fs-4">{{ $date['month'] }} {{ $date['year'] }}</div>
        </div>
        <table id="inspectionIssued" class="table">
            <thead>
                <th>Fire Safety Inspection No.(FSIC No.)</th>
                <th>Establishment Name</th>
                <th>Address</th>
                <th>Issued Date</th>
                <th>Substation</th>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->fsic_no }}</td>
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

</html>
