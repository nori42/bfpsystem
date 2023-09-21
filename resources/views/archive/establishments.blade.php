{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.archive')

@section('archiveContent')
    <div class="mt-3" style="height: 650px">

        <table class="table">
            <thead>
                <th>Establishment Name</th>
                <th>Owner</th>
                {{-- <th>Total Inspections</th>
                <th>Total Firedrill</th> --}}
                <th>Date Deleted</th>
            </thead>
            <tbody>
                @foreach ($establishments as $item)
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
                        <td>{{ $item->establishment_name }}</td>
                        <td>{{ $representative }}</td>
                        {{-- <td>{{ count($item->inspection) }}
                        </td>
                        <td>{{ count($item->firedrill) }}</td> --}}
                        <td>{{ date('m/d/Y g:i A', strtotime($item->deleted_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $establishments->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
