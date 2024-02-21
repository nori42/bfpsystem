@extends('layouts.reports')

@section('reportContent')
    @if ($dateRange['from'] != null && $dateRange['to'] != null)
        <div class="d-flex align-items-center justify-content-between heading">
            <div class="fs-5 fw-bold">Inpsections Certificate Issued</div>
            <div class="fs-6 fw-semibold">{{ $inspections->count() }} Result{{ $inspections->count() > 1 ? 's' : '' }}
            </div>
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
                    <th></th>
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
                            <td>
                                @if ($inspection->status == 'Error')
                                    <span class="text-danger">Error</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="fs-3 fw-semibold d-flex justify-content-center align-content-center mt-5">
            <div class="border border-3 border-gray-500 rounded-3 px-5 py-3 text-secondary">
                Choose a report and filter the date to see reports
            </div>
        </div>
    @endif
@endsection
