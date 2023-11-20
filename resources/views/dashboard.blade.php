{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('stylesheet')
    @vite(['resources/css/pages/dashboard.css'])
@endsection
@section('content')
    @php
        $summaryCardStyle = "
            max-width:28rem;
            box-shadow:0px 3px 4px gray;
    ";

        $totalCardStyle = "
            height:16rem;
            width:18rem;
            display:flex;
            align-items:center;
            justify-content:center;
            background-color:#123B5A;
            color:white;
        ";

        $cardTotal = "
            width:100%;
            background-color:var(--nav);
            color:white;
        ";
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>

            <div class="mb-4">
                <span class="d-block fw-bold fs-2">Dashboard</span>
            </div>

            <div class="d-flex justify-content-center gap-3 mb-5">
                <div class="d-flex justify-content-center align-items-center p-3 py-4 rounded-3 gap-3"
                    style="{{ $cardTotal }}">
                    <div><i class="bi bi-building border border-2 p-2 rounded-3" style="font-size: 54px;"></i></div>
                    <div>
                        <div class="fs-5">Total Establishments</div>
                        <div class="text-center fs-2">{{ $totalEstablishments }}</div>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center p-3 rounded-3 gap-3"
                    style="{{ $cardTotal }}">
                    <div><i class="bi bi-hourglass-split border border-2 p-2 rounded-3" style="font-size: 54px;"></i></div>
                    <div>
                        <div>
                            <a href="/fsec" class="text-white mt-2" style="text-decoration: none;">
                                <span class="fs-5">Pending Building
                                    Plans</span><i class="bi bi-arrow-left mx-2"></i>
                            </a>
                        </div>
                        <div class="text-center fs-2">{{ $totalPending }}</div>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center p-3 rounded-3 gap-3"
                    style="{{ $cardTotal }}">
                    <div class="text-center"><i class="bi bi-building-exclamation border border-2 p-2 rounded-3"
                            style="font-size: 54px;"></i>
                    </div>
                    <div>
                        <div class="fs-5">Expired Inpsection</div>
                        <div class="text-center fs-2">{{ $expiredInspectionCount }}</div>
                    </div>
                </div>
            </div>

            <div class="" style="width: 890px;">

                <div class="d-flex justify-content-between mb-3">
                    <div class="fs-4 fw-bold">Issued Certificates</div>
                    <div class="fw-bold fs-4"><span id="monthLabel">{{ date('F') }}</span> <span
                            id="yearLabel">{{ date('Y') }}</span></div>
                </div>

                <div class="d-flex gap-4">
                    <div class="bg-subtleBlue rounded-3" style="{{ $summaryCardStyle }}">
                        <div class="fs-5 fw-bold bg-primary text-white px-4 py-3 rounded-top-3 text-center">Inspection
                            Certificate Issued
                        </div>

                        @php
                            $substations = ['Guadalupe', 'Labangon', 'Lahug', 'Mabolo', 'Pahina Central', 'Pardo', 'Pari-an', 'San Nicolas', 'Talamban'];
                        @endphp

                        <div class="px-5 py-3">
                            <div class="fs-4">Substation</div>
                            <table style="width: 21rem;">
                                @foreach ($substations as $substation)
                                    <tr>
                                        <td>{{ $substation }}</td>
                                        <td>{{ $fsicIssued['substations']->get(strtoupper($substation)) ? $fsicIssued['substations']->get(strtoupper($substation))->count() : 0 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <table class="mt-4" style="width:21rem;">
                                <tr>
                                    <td class="fw-bold">CBP</td>
                                    <td>{{ $fsicIssued['totalCBP'] }}</td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">New</td>
                                    <td>{{ $fsicIssued['totalNew'] }}</td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">Total Substation</td>
                                    <td>{{ $fsicIssued['totalSubstation'] }}</td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">Grand Total</td>
                                    <td>{{ $fsicIssued['totalGrand'] }}</td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">Occupancy</td>
                                    <td>{{ $fsicIssued['totalOccupancy'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="bg-subtleBlue" style="{{ $summaryCardStyle }}">
                        <div class="fs-5 fw-bold bg-primary text-white px-4 py-3 rounded-top-3 text-center">Firedrill
                            Certificate Issued
                        </div>
                        <div class="px-5 py-3">
                            <div class="fs-4">Substation</div>

                            <table style="width: 21rem;">
                                @foreach ($firedrillIssued['issuedBySubstation'] as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <table class="mt-4" style="width:21rem;">
                                <tr>
                                    <td class="fw-bold">Total Substations</td>
                                    <td>{{ $firedrillIssued['totalSubstation'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Grand Total</td>
                                    <td>{{ $firedrillIssued['totalGrand'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </x-pageWrapper>
    </div>
    <script></script>
@endsection
