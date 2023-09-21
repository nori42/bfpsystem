@extends('layouts.reports')

@section('reportContent')
    @if ($dateRange['from'] != null && $dateRange['to'] != null)
        <div class="d-flex align-items-center justify-content-between heading">
            <div class="fs-5">Inpsections Certificate Issued</div>
            <div class="fs-6">
                <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                @if ($dateRange['from'] != $dateRange['to'])
                    <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                @endif
            </div>
        </div>
        <div class="tableContainer">
            <table id="reportsTable" class="table" tablename="fsic">
                <thead>
                    <th><span>Fire Safety Inspection No.(FSIC No.)</span></th>
                    <th><span>Registration Status</span></th>
                    <th><span>Establishment Name</span></th>
                    <th><span>Address</span></th>
                    <th><span>Issued Date</span></th>
                    <th><span>Substation</span></th>
                </thead>
                <tbody>
                    @foreach ($inspections as $inspection)
                        <tr class="align-middle">
                            <td>{{ $inspection->fsic_no }}</td>
                            <td>{{ $inspection->registration_status }}</td>
                            <td>{{ $inspection->establishment->establishment_name }}</td>
                            <td>{{ $inspection->establishment->address }}</td>
                            <td>{{ date('m/d/Y', strtotime($inspection->issued_on)) }}</td>
                            <td>{{ $inspection->establishment->substation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="fs-3 text-secondary fw-semibold">Select a date range</div>
    @endif
@endsection
