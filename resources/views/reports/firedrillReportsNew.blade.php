@extends('layouts.reports')

@section('reportContent')
    @if ($dateRange['from'] != null && $dateRange['to'] != null)
        <div class="d-flex align-items-center justify-content-between heading">
            <div class="fs-5">Firedrill Issued</div>
            <div class="fs-6 fw-semibold">{{ $firedrills->count() }} Result{{ $firedrills->count() > 1 ? 's' : '' }}
            </div>
            <div class="fs-6">
                <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                @if ($dateRange['from'] != $dateRange['to'])
                    <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                @endif
            </div>
        </div>
        <div class="tableContainer">
            <table id="reportsTable" class="table" tablename="firedrill">
                <thead>
                    <th><span>Control No.</span></th>
                    <th><span>Date of Drill</span></th>
                    <th><span>Establishment</span></th>
                    <th><span>Owner</span></th>
                    <th><span>Issued On</span></th>
                    <th><span>Validity</span></th>
                    <th><span>O.R Number</span></th>
                    <th><span>Amount</span></th>
                    <th><span>Date of Payment</span></th>
                    @if (!$unclaimed)
                        <th><span>Claimed By</span></th>
                        <th><span>Date Claimed</span></th>
                    @endif
                </thead>
                <tbody>
                    @foreach ($firedrills as $firedrill)
                        @php
                            
                            $representative = $firedrill->establishment->getOwnerName();
                            
                        @endphp
                        <tr class="align-middle">
                            <td>{{ $firedrill->control_no }}</td>
                            <td>{{ date('m/d/Y', strtotime($firedrill->date_made)) }}</td>
                            <td>
                                @if ($unclaimed)
                                    <a href="/establishments/{{ $firedrill->establishment->id }}/firedrill" target="_parent">
                                        {{ $firedrill->establishment->establishment_name }}
                                    </a>
                                @else
                                    {{ $firedrill->establishment->establishment_name }}
                                @endif
                            </td>
                            <td>{{ $representative }}</td>
                            <td>{{ $firedrill->issued_on ? date('m/d/Y', strtotime($firedrill->issued_on)) : '' }}</td>
                            <td>{{ $firedrill->validity_term }}</td>
                            <td>{{ $firedrill->receipt->or_no }}</td>
                            <td>&#8369;{{ $firedrill->receipt->amount }}</td>
                            <td>{{ date('m/d/Y', strtotime($firedrill->receipt->date_of_payment)) }}</td>
                            @if (!$unclaimed)
                                <td>{{ $firedrill->claimed_by }}</td>
                                <td>{{ $firedrill->claimed_by ? date('m/d/Y', strtotime($firedrill->date_claimed)) : '' }}
                            @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @else
        <div class="fs-3 text-secondary fw-semibold">Select a date range</div>
    @endif
@endsection
