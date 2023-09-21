{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

@section('stylesheet')
    @vite('resources/css/components/spinner.css')
@endsection
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
                <form action="/reports/firedrill" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold" for="fromDate">From</label>
                    <input class="form-control" type="date" id="dateFrom" name="dateFrom" style="width:18rem;"
                        value="" required>

                    <label class="fw-bold" for="toDate">To</label>
                    <input class="form-control" type="date" id="dateTo" name="dateTo" style="width:18rem;"
                        value="" required>
                    <button class="btn btn-primary text-nowrap" id="viewReport">View Report</button>
                    @if ($dateRange['from'] != null && $dateRange['to'] != null)
                        <div class="position-relative" dropdown>
                            <button class="btn btn-success text-nowrap" id="viewSummary" type="button" dropdown-btn>View
                                Summary
                                <i class="bi bi-caret-down-fill text-white fs-6"></i>
                            </button>
                            <div id="reportSummary" class="position-absolute" id="printables" dropdown-menu
                                style="display: none !important; ">
                                <div class="bg-subtleBlue p-5" style="width:28rem; box-shadow:0px 3px 4px gray;">
                                    <div class="fs-4">Firedrill Certificate Issued</div>
                                    <div class="fw-semibold">
                                        <span>{{ date('F d, Y', strtotime($dateRange['from'])) }}</span>
                                        @if ($dateRange['from'] != $dateRange['to'])
                                            <span> - {{ date('F d, Y', strtotime($dateRange['to'])) }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-4 fs-4">Substation</div>

                                    @php
                                        $substations = ['Guadalupe', 'Labangon', 'Lahug', 'Mabolo', 'Pahina Central', 'Pardo', 'Pari-an', 'San Nicolas', 'Talamban '];
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
                        </div>
                    @endif
                </form>
            </div>
            <div id="pageContent">
                @if ($dateRange['from'] != null && $dateRange['to'] != null)
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

            {{-- Loading --}}
            <div class="d-none" id="loadingMssg">
                <div class="d-flex justify-content-center">
                    <x-spinner2 :hidden="false" />
                </div>
                <h4 class="text-secondary text-center mt-2">Fetching Reports...</h4>
            </div>
        </x-pageWrapper>

    </div>
    <script src="{{ asset('js/reports/reportsScript.js') }}"></script>
    <script>
        const APP_URL = "{{ env('APP_URL') }}";
        initReportLink(APP_URL);
    </script>
@endsection
