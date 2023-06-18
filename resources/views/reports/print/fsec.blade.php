@php
    use App\Http;
@endphp

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
    {{-- {{ dd($evaluations[0]->buildingPlan) }} --}}
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
                {{-- @foreach ($buildingPlans as $plan)
                    @php
                        if ($plan->last_name != null) {
                            if ($plan->middle_name == null) {
                                $personName = $plan->first_name . ' ' . $plan->last_name;
                            } else {
                                $personName = $plan->first_name . ' ' . $plan->middle_name[0] . '. ' . $plan->last_name;
                            }
                        }
                        
                        if ($personName != null && $plan->corporate_name != null) {
                            $representative = $personName . '/' . $plan->corporate_name;
                        } elseif ($personName == null) {
                            $representative = $plan->corporate_name;
                        } else {
                            $representative = $personName;
                        }
                    @endphp
                    @endphp
                    <tr>
                        <td>{{ $plan->series_no }}</td>
                        <td>{{ date('m/d/Y', strtotime($plan->date_received)) }}</td>
                        <td>{{ $representative }}</td>
                        <td>{{ $plan->address }}</td>
                    </tr>
                @endforeach --}}
                @foreach ($evaluations as $evaluation)
                    @php
                        $buildingPlan = $evaluation->buildingPlan;
                        $building = $evaluation->buildingPlan->building;
                        $receipt = $evaluation->buildingPlan->receipt;
                        $owner = $evaluation->buildingPlan->owner;
                        
                        if ($owner->person->last_name != null) {
                            if ($owner->person->middle_name == null) {
                                $personName = $owner->person->first_name . ' ' . $owner->person->last_name;
                            } else {
                                $personName = $owner->person->first_name . ' ' . $owner->person->middle_name[0] . '. ' . $owner->person->last_name;
                            }
                        }
                        
                        if ($personName != null && $owner->corporate->corporate_name != null) {
                            $representative = $personName . '/' . $owner->corporate->corporate_name;
                        } elseif ($personName == null) {
                            $representative = $owner->corporate->corporate_name;
                        } else {
                            $representative = $personName;
                        }
                    @endphp
                    <tr>
                        <td>{{ $buildingPlan->series_no }}</td>
                        <td>{{ date('m/d/Y', strtotime($buildingPlan->date_received)) }}</td>
                        <td>{{ $representative }}</td>
                        <td>{{ $building->address }}</td>
                        <td>{{ date('m/d/Y', strtotime($buildingPlan->receipt->date_of_payment)) }}</td>
                        <td>{{ $buildingPlan->bp_application_no }}</td>
                        <td>{{ $building->occupancy }}</td>
                        <td>{{ $evaluation->evaluator }}</td>
                        <td>{{ date('m/d/Y', strtotime($evaluation->created_at)) }}</td>
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
    function sort(index) {
        const tableId = 'evaluations'
        sortTable(index, tableId)
    }
</script>

</html>
