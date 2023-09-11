{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.archive')

@section('archiveContent')
    <div class="mt-3" style="height: 650px">

        <table class="table">
            <thead>
                <th>Applicant</th>
                <th>Project Title</th>
                <th>Evaluation Status</th>
                <th>Date Deleted</th>
            </thead>
            <tbody>
                @foreach ($buildingPlan as $item)
                    @php
                        $owner = $item->owner;
                        if ($owner->person->last_name != null) {
                            $person = $owner->person;
                            $representative = $person->first_name . ' ' . $person->last_name;
                        } else {
                            $representative = $owner->corporate->corporate_name;
                        }
                        
                    @endphp
                    <tr>
                        <td>{{ $representative }}</td>
                        <td>{{ $item->project_title }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ date('m/d/Y g:i A', strtotime($item->deleted_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
    </div>
@endsection
