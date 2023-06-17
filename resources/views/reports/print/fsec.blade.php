<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/bootstrap.scss', 'resources/css/reports.css'])
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
    </div>
    <div class="printables">
        <div class="d-flex align-items-center justify-content-between heading">
            <div class="fs-3">Building Permit Applications</div>
            {{-- <div class="fs-4">{{ $date['month'] }} {{ $date['year'] }}</div> --}}
        </div>
        <table id="evaluations" class="table">
            <thead>
                <th><span onclick="sort(0)">Series No.</span></th>
                <th><span onclick="sort(1)">Date Received</span></th>
                <th><span onclick="sort(2)">Permit Applicant</span></th>
                <th><span onclick="sort(3)">Address</span></th>
                <th><span onclick="sort(4)">Date Paid</span></th>
                <th><span onclick="sort(5)">Building Permit App. No</span></th>
                <th><span onclick="sort(6)">Occupancy</span></th>
                <th><span onclick="sort(7)">Evaluator</span></th>
                <th><span onclick="sort(8)">Evaluation Date</span></th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</body>
<script src="{{ asset('js/reports/xlsx.full.min.js') }}"></script>
<script src="{{ asset('js/reports/exportToXLSX.js') }}"></script>
<script src="{{ asset('js/reports/tableSort.js') }}"></script>
<script>
    function sort(index) {
        const tableId = 'evaluations'
        sortTable(index, tableId)
    }
</script>

</html>
