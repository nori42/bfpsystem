@extends('layouts.reports')

@section('reportContent')
    @if ($dateRange['from'] != null && $dateRange['to'] != null)
        <div>
            <div class="d-flex align-items-center justify-content-between heading">
                <div class="fs-5">Approved Building Permit Applications</div>
                <div class="fs-6 fw-semibold">{{ $evaluations->count() }} Result{{ $evaluations->count() > 1 ? 's' : '' }}
                </div>
                <div class="fs-6">
                    <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                    @if ($dateRange['from'] != $dateRange['to'])
                        <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                    @endif
                </div>
            </div>
            <div class="tableContainer">
                <table id="reportsTable" class="table" tablename='fsec'>
                    <thead>
                        <th><span>Series No.</span></th>
                        <th><span>Date Received</span></th>
                        <th><span>Permit Applicant</span></th>
                        <th><span>Address</span></th>
                        <th><span>Date Paid</span></th>
                        <th><span>Building Permit App. No</span></th>
                        <th><span>Occupancy</span></th>
                        <th><span>Evaluator</span></th>
                        <th><span>Evaluation Date</span></th>
                        <th><span>Release Date</span></th>
                    </thead>
                    <tbody>
                        @foreach ($evaluations as $evaluation)
                            @php
                                $buildingPlan = $evaluation->buildingPlan;
                                $receipt = $evaluation->buildingPlan->receipt;
                                $representative = $buildingPlan->getOwnerName();

                                // $owner = $evaluation->buildingPlan->owner;
                                // $personName = null;

                                // if ($owner->person->last_name != null) {
                                //     if ($owner->person->middle_name == null) {
                                //         $personName = $owner->person->first_name . ' ' . $owner->person->last_name;
                                //     } else {
                                //         $personName = $owner->person->first_name . ' ' . $owner->person->middle_name[0] . '. ' . $owner->person->last_name;
                                //     }
                                // }

                                // if ($personName != null && $owner->corporate->corporate_name != null) {
                                //     $representative = $personName . '/' . $owner->corporate->corporate_name;
                                // } elseif ($personName == null) {
                                //     $representative = $owner->corporate->corporate_name;
                                // } else {
                                //     $representative = $personName;
                                // }

                            @endphp
                            <tr>
                                <td>{{ $buildingPlan->series_no }}</td>
                                <td>{{ date('m/d/Y', strtotime($buildingPlan->date_received)) }}</td>
                                <td>{{ $representative }}</td>
                                <td>{{ $buildingPlan->address }}</td>
                                <td>{{ date('m/d/Y', strtotime($buildingPlan->receipt->date_of_payment)) }}</td>
                                <td>{{ $buildingPlan->bp_application_no }}</td>
                                <td>{{ $buildingPlan->occupancy }}</td>
                                <td>{{ $evaluation->evaluator }}</td>
                                <td>{{ date('m/d/Y', strtotime($evaluation->created_at)) }}</td>
                                <td>{{ $buildingPlan->date_released != null ? date('m/d/Y', strtotime($buildingPlan->date_released)) : 'Not Release' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="fs-3 fw-semibold d-flex justify-content-center align-content-center mt-5">
            <div class="border border-3 border-gray-500 rounded-3 px-5 py-3 text-secondary">
                Choose a report and filter the date to see reports
            </div>
        </div>
    @endif
@endsection
