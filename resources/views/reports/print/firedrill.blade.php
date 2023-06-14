<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/bootstrap.scss', 'resources/css/reports.css'])

    <style>
        .fs-7 {
            font-size: 0.725rem;
        }

        @media print {

            body {
                font-size: 6pt !important;
            }
        }
    </style>
</head>

<body>
    <div class="py-3 bg-white position-sticky w-100 top-0">
        <button class="btn btn-primary border-0" onclick="print()"> <i class="bi bi-printer-fill"></i>
            Print</button>
        <button class="btn btn-primary border-0" onclick="exportTableToXLSX('firedrillIssued','firedrillIssued.xlsx')">
            <i class="bi bi-filetype-xlsx"></i>
            Export to Excel</button>
    </div>
    <div class="printables">
        <div class="heading">
            <div class="fs-3">Firedrill Issued</div>
        </div>
        <table id="firedrillIssued" class="table">
            <thead>
                <th>Control No.</th>
                <th>Date of Drill</th>
                <th>Address</th>
                <th>Owner</th>
                <th>Issued On</th>
                <th>Validity</th>
                <th>Amount</th>
                <th>O.R Number</th>
                <th>Date of Payment</th>
                <th>Claimed By</th>
                <th>Date Claimed</th>
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
                    <tr>
                        <td>{{ $firedrill->control_no }}</td>
                        <td>{{ date('m/d/Y', strtotime($firedrill->date_made)) }}</td>
                        <td>{{ $firedrill->establishment->address }}</td>
                        <td>{{ $representative }}</td>
                        <td>{{ $firedrill->issued_on ? date('m/d/Y', strtotime($firedrill->issued_on)) : '' }}</td>
                        <td>{{ $firedrill->validity_term }}</td>
                        <td>{{ $firedrill->receipt->amount }}</td>
                        <td>{{ $firedrill->receipt->or_no }}</td>
                        <td>{{ date('m/d/Y', strtotime($firedrill->receipt->date_of_payment)) }}</td>
                        <td>{{ $firedrill->claimed_by }}</td>
                        <td>{{ $firedrill->claimed_by ? date('m/d/Y', strtotime($firedrill->date_claimed)) : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

<script src="{{ asset('js/reports/xlsx.full.min.js') }}"></script>
<script src="{{ asset('js/reports/exportToXLSX.js') }}"></script>

</html>
