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

    tbody tr:hover {
        background-color: #ddecff;
    }
</style>

<body>
    <div class="position-sticky top-0 d-flex align-items-center justify-content-between heading my-4 bg-white">
        <div class="py-2">
            <div class="fs-3">{{ count($buildingPlans) }} Pending</div>
            <div class="text-secondary">List of pending applications</div>
        </div>
    </div>

    @if (count($buildingPlans) != 0)

        <table id="evaluations" class="table">
            <thead>
                <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(0)">Series No.</span></th>
                <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(1)">Date Received</span></th>
                <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(3)">Permit Applicant</span>
                </th>
                <th class="position-sticky bg-white" style="top:9%;"><span onclick="sort(4)">Building Name</span></th>
            </thead>
            <tbody>
                @foreach ($buildingPlans as $plan)
                    {{-- @php
                    $showURL = env('APP_URL') . '/fsec' . '/' . $plan->id;
                @endphp --}}

                    @php
                        $owner = $plan->owner;
                        $personName = null;
                        
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
                        <td>{{ $plan->series_no }}</td>
                        <td>{{ date('m/d/Y', strtotime($plan->date_received)) }}</td>
                        <td>{{ $representative }}</td>
                        <td>{{ $plan->name_of_building }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
<script src="{{ asset('js/reports/tableSort.js') }}"></script>
<script>
    function sort(index) {
        const tableId = 'evaluations'
        sortTable(index, tableId)
    }
</script>

</html>
