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
            <select name="reports" id="reportsSelect" class="w-50 fs-4 form-select">
                {{-- I added if statement this way so that the order doesnt change --}}
                @if (auth()->user()->type == 'ADMINISTRATOR')
                    <option value="inspection">Inspection Reports</option>
                @endif

                @if (auth()->user()->type == 'ADMINISTRATOR')
                    <option value="firedrill">Firedrill Reports</option>
                @endif

                <option value="buildingplan" selected>Building Plan Reports</option>
            </select>


            <div id="filter" class="my-2 d-flex align-items-center gap-2">
                <form action="/reports/fsec" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold" for="fromDate">From</label>
                    <input class="form-control" type="date" id="dateFrom" name="dateFrom" style="width:18rem;"
                        value="" required>

                    <label class="fw-bold" for="toDate">To</label>
                    <input class="form-control" type="date" id="dateTo" name="dateTo" style="width:18rem;"
                        value="" required>
                    <button class="btn btn-success text-nowrap" id="viewReport">View Report</button>
                </form>
            </div>

            <hr>
            <div id="pageContent">
                @if ($dateRange['from'] != null && $dateRange['to'] != null)
                    <iframe id="iFrameFsec"
                        src="{{ env('APP_URL') }}/reports/print/fsec?dateFrom={{ $dateRange['from'] }}&dateTo={{ $dateRange['to'] }}"
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
