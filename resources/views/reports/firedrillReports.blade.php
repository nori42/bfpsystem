{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <style>
        #filter {
            width: 656px;
        }

        @media print {

            body,
            #filter {
                visibility: hidden;
            }

            #printables {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                translate: (-50%, 0);
                page-break-after: always;
                display: block !important;
            }

            .report-buttons {
                display: none;
            }
        }
    </style>
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            {{-- {{ dd($debug) }} --}}
            <div class="d-flex align-items-center gap-3">
                <select name="reports" id="reportsSelect" class="w-50 fs-4 form-select">
                    @if (auth()->user()->type == 'ADMINISTRATOR')
                        <option value="inspection">Inspection Reports</option>
                    @endif

                    <option value="firedrill" selected>Firedrill Reports</option>

                    @if (auth()->user()->type == 'ADMINISTRATOR')
                        <option value="buildingplan">Building Plan Reports</option>
                    @endif
                </select>
            </div>
            <hr>

            <div id="filter" class="my-2 d-flex align-items-center gap-2">

                {{-- <label for="month">Month</label>
                    <select class="form-select" name="month" id="month" style="width:21rem;">
                        @foreach ($monthReports as $m)
                            @if ($selectedReports['month'] == $m->month)
                                <option value="{{ $m->month }}" selected>
                                    {{ DateTime::createFromFormat('!m', $m->month)->format('F') }}
                                </option>
                            @else
                                <option value="{{ $m->month }}">
                                    {{ DateTime::createFromFormat('!m', $m->month)->format('F') }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <select class="form-select" name="year" id="year" style="width:21rem;">
                        @foreach ($yearReports as $y)
                            @if ($selectedReports['year'] == $y->year)
                                <option value="{{ $y->year }}" selected>{{ $y->year }}</option>
                            @else
                                <option value="{{ $y->year }}">{{ $y->year }}</option>
                            @endif
                        @endforeach
                    </select> --}}
                <form action="/reports/firedrill" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold" for="fromDate">From</label>
                    <input class="form-control" type="date" id="dateFrom" name="dateFrom" style="width:18rem;"
                        value="" required>

                    <label class="fw-bold" for="toDate">To</label>
                    <input class="form-control" type="date" id="dateTo" name="dateTo" style="width:18rem;"
                        value="" required>
                    <button class="btn btn-success text-nowrap" id="viewReport">View Report</button>
                </form>
            </div>
            <div id="pageContent">
                @if ($dateRange['from'] != null && $dateRange['to'] != null)
                    <div class="d-inline-block" id="printables">
                        <div class="bg-subtleBlue p-5" style="max-width:28rem; box-shadow:0px 3px 4px gray;">
                            <div class="fs-4">Firedrill Certificate Issued</div>
                            <div class="fw-semibold">
                                <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                                @if ($dateRange['from'] != $dateRange['to'])
                                    <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                                @endif
                            </div>
                            <div class="mt-4 fs-4">Substation</div>

                            @php
                                $substations = ['Guadalupe', 'Labangon', 'Lahug', 'Mabolo', 'Pahina Central', 'Pardo', 'Pari-an', 'San Nicolas', 'Talamban'];
                            @endphp

                            <table style="width: 16rem;">
                                @foreach ($substations as $substation)
                                    <tr>
                                        <td>{{ $substation }}</td>
                                        <td>{{ $firedrillIssued['substations']->get(strtoupper($substation)) ? $firedrillIssued['substations']->get(strtoupper($substation))->count() : 0 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <table class="mt-4" style="width:16rem;">
                                <tr>
                                    <td class="fw-bold">CBP</td>
                                    <td>{{ $firedrillIssued['totalCBP'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total Substations</td>
                                    <td>{{ $firedrillIssued['totalSubstation'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Grand Total</td>
                                    <td>{{ $firedrillIssued['totalGrand'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Unclaimed</td>
                                    <td>{{ $firedrillIssued['totalUnclaimed'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    @php
                        //This is the query parameter for unclaimed firedrill
                        $queryParam = "dateFrom={$dateRange['from']}&dateTo={$dateRange['to']}";
                        
                        //This is the query parameter for claimed firedrill
                        if ($isUnclaimed) {
                            $queryParam = "dateFrom={$dateRange['from']}&dateTo={$dateRange['to']}&unclaimed=true";
                        }
                    @endphp
                    <iframe id="iFrameFiredrill" src="{{ env('APP_URL') }}/reports/print/firedrill?{{ $queryParam }}"
                        frameborder="0" width="100%" height="800px"></iframe>
                @else
                    <h1 class="text-secondary fs-2 mt-3">Select a date range</h1>
                @endif
            </div>

            {{-- Loading Message --}}
            <h2 class="text-secondary text-center mt-5 d-none" id="loadingMssg">Fetching Reports...</h2>
        </x-pageWrapper>

    </div>
    <script src="{{ asset('js/reports/reportsScript.js') }}"></script>
    <script>
        const APP_URL = "{{ env('APP_URL') }}";
        initReportLink(APP_URL);
    </script>
@endsection
