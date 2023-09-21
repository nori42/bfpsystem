{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

@section('stylesheet')
    @vite('resources/css/components/spinner.css')
    @vite('resources/css/pages/reports.css')
@endsection

@php
    $routeArr = explode('/', Route::current()->uri);
    $currentReport = end($routeArr);
@endphp

@section('content')
    <x-pageWrapper>
        @if (session('toastMssg') != null)
            <x-toast :message="session('toastMssg')" />
        @endif
        <div class="d-flex align-items-center">
            <div style="width:230px;">
                <div class="fs-3 fw-semibold">Reports</div>
                <div class="text-secondary">
                    List of
                    @if ($currentReport == 'fsic')
                        issued inspections
                    @elseif ($currentReport == 'firedrill')
                        issued firedrills
                    @else
                        approved applications
                    @endif
                </div>
            </div>
            <div>
                <label class="fs-5 fw-semibold" for="rfsic">Inspections</label>
                <input class="fs-3" type="radio" name="page" id="rfsic" route="fsic"
                    {{ $currentReport == 'fsic' ? 'checked' : '' }}>
                <span class="mx-4">
                    <label class="fs-5 fw-semibold" for="rfiredrill">Firedrills</label>
                    <input class="fs-3" type="radio" name="page" id="rfiredrill" route="firedrill"
                        {{ $currentReport == 'firedrill' ? 'checked' : '' }}>
                </span>
                <label class="fs-5 fw-semibold" for="rfsec">Building Plan Applications</label>
                <input class="fs-3" type="radio" name="page" id="rfsec" route="fsec"
                    {{ $currentReport == 'fsec' ? 'checked' : '' }}>
            </div>
        </div>

        <div id="reportContent">

            <div class="d-flex align-items-center justify-content-between gap-3 my-2">
                <form id="filter" class="d-flex align-items-center gap-3"
                    action="{{ '/reports' . '/' . $currentReport }}" method="GET">
                    <x-dateFilter action="{{ '/reports' . '/' . $currentReport }}" :dateRange="['from' => $dateRange['from'], 'to' => $dateRange['to']]" :selfReport="$selfReport" />

                    @if ($dateRange['from'] != null && $dateRange['to'] != null)
                        @if ($currentReport == 'fsic')
                            <div class="position-relative" dropdown>
                                <button class="btn btn-primary" id="viewSummary" type="button" dropdown-btn>View
                                    Summary
                                    <i class="bi bi-caret-down-fill text-white fs-6"></i>
                                </button>
                                <div id="reportSummary" class="position-absolute" id="printables" dropdown-menu
                                    style="display: none !important; ">
                                    <div class="bg-subtleBlue p-5" style="width:28rem; box-shadow:0px 3px 4px gray;">
                                        <div class="fs-4">Inspection Certificate Issued</div>
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
                                                    <td>{{ $fsicIssued['substations']->get(strtoupper($substation)) ? $fsicIssued['substations']->get(strtoupper($substation))->count() : 0 }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        <table class="mt-4" style="width:16rem;">
                                            <tr>
                                                <td class="fw-bold">CBP</td>
                                                <td>{{ $fsicIssued['totalCBP'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Total Substations</td>
                                                <td>{{ $fsicIssued['totalSubstation'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Grand Total</td>
                                                <td>{{ $fsicIssued['totalGrand'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">New</td>
                                                <td>{{ $fsicIssued['totalNew'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @elseif($currentReport == 'firedrill')
                            <div class="position-relative" dropdown>
                                <button class="btn btn-primary text-nowrap" id="viewSummary" type="button"
                                    dropdown-btn>View
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

                        <div>
                            <input class="align-middle" type="checkbox" name="selfReport" id="myReport" checkboxquery
                                style="height: 1.325rem; width: 1.325rem;" {{ $selfReport ? 'checked' : '' }}>
                            <label for="myReport" class="fw-bold">My Reports</label>
                        </div>


                        @if ($currentReport == 'firedrill')
                            <div>
                                <input class="align-middle" type="checkbox" name="unclaimed" id="unclaimed"
                                    style="height: 1.325rem; width: 1.325rem; margin-left: 8px;" checkboxquery
                                    {{ $unclaimed ? 'checked' : '' }}>
                                <label for="unclaimed" class="fw-bold">Unclaimed</label>
                            </div>
                        @endif

                    @endif

                </form>

                {{-- current date range value --}}
                @if ($dateRange['from'] != null && $dateRange['to'] != null)
                    <input type="hidden" name="dateFromCurrent" id="dateFromCurrent" value="{{ $dateRange['from'] }}">
                    <input type="hidden" name="dateToCurrent" id="dateToCurrent" value="{{ $dateRange['to'] }}">
                @endif

                @if ($dateRange['from'] != null && $dateRange['to'] != null)
                    <div>
                        <button class="btn btn-primary border-0" id='btnExport'>
                            <i class="bi bi-filetype-xlsx"></i>
                            Export to Excel</button>
                    </div>
                @endif
            </div>

            @yield('reportContent')
        </div>

        <div class="d-none" id="loadingMssg">
            <div class="d-flex justify-content-center">
                <x-spinner2 :hidden="false" />
            </div>
            <h4 class="text-secondary text-center mt-2">Fetching Reports...</h4>
        </div>

    </x-pageWrapper>
@endsection

@section('page-script')
    @yield('components-script')
    @vite(['resources/js/pages/reports.js'])
@endsection
