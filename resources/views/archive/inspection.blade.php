{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.archive')

@section('archiveContent')
    <div class="mt-3" style="height: 650px">

        <table class="table">
            <thead>
                <th>Inspection Date</th>
                <th>Issued Date</th>
                <th>FSIC No.</th>
                <th>Registration Status</th>
                <th>Expiry Date</th>
                <th>Date Deleted</th>
            </thead>
            <tbody>
                @foreach ($inspections as $item)
                    <tr>
                        <td>{{ $item->inspection_date ? date('m/d/Y', strtotime($item->inspection_date)) : '' }}
                        </td>
                        <td>{{ $item->issued_on ? date('m/d/Y', strtotime($item->issued_on)) : 'Not Issued' }}</td>
                        <td>{{ $item->fsic_no }}</td>
                        <td>{{ $item->registration_status }}</td>
                        <td>{{ $item->expiry_date ? date('m/d/Y', strtotime($item->expiry_date)) : 'Not Issued' }}</td>
                        <td>{{ date('m/d/Y g:i A', strtotime($item->deleted_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
    </div>
@endsection
