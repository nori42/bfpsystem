{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.archive')

@section('archiveContent')
    <div class="mt-3" style="height: 650px">

        <table class="table">
            <thead>
                <th>Establishment</th>
                <th>Control No</th>
                <th>Validity</th>
                <th>Date of Drill</th>
                <th>Issued On</th>
                <th>Date Claimed</th>
                <th>Date Deleted</th>

            </thead>
            <tbody>
                @foreach ($firedrills as $item)
                    <tr>
                        <td>{{ $item->establishment_name }}</td>
                        <td>{{ $item->control_no ? $item->control_no : 'Not Issued' }}</td>
                        <td>{{ $item->validity_term }}</td>
                        <td>{{ date('F d, Y', strtotime($item->date_made)) }}</td>
                        <td>{{ $item->issued_on ? date('m/d/Y', strtotime($item->issued_on)) : 'Not Issued' }}</td>
                        <td>
                            @if ($item->date_claimed)
                                {{ date('m/d/Y', strtotime($item->date_claimed)) }}
                            @elseif ($item->issued_on)
                                <span class="text-danger">Unclaimed</span>
                            @else
                                Not Issued
                            @endif
                        </td>
                        <td>{{ date('m/d/Y g:i A', strtotime($item->deleted_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
    </div>
@endsection
