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
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <div class="mb-4">
                <span class="d-block fw-bold fs-3">Dashboard</span>
            </div>

            <div class="d-flex">
                <div class="d-flex gap-4" style="border-right: 2px solid black; padding-right: 3rem;">

                    <div class="bg-subtleBlue p-5" style="{{ $summaryCardStyle }}">
                        <div class="fs-5">Inspection Certificate Issued</div>
                        <div class="fw-bold fs-6"><span id="monthLabel">{{ date('F') }}</span> <span
                                id="yearLabel">{{ date('Y') }}</span></div>
                        <div class="mt-4 fs-4">Substation</div>
                        <table style="width: 16rem;">
                            @foreach ($fsicIssued['issuedBySubstation'] as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <table class="mt-4" style="width:16rem;">
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
                                <td>{{ $fsicIssued['new'] }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="bg-subtleBlue p-5" style="{{ $summaryCardStyle }}">
                        <div class="fs-5">Firedrill Certificate Issued</div>
                        <div class="fw-bold fs-6"><span id="monthLabel">{{ date('F') }}</span> <span
                                id="yearLabel">{{ date('Y') }}</span></div>
                        <div class="mt-4 fs-4">Substation</div>
                        <table style="width: 16rem;">
                            @foreach ($firedrillIssued['issuedBySubstation'] as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <table class="mt-4" style="width:16rem;">
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

                <div class="px-3 d-flex gap-3">

                    <div class="d-flex flex-column rounded-3 h-100 justify-content-start" style="{{ $totalCardStyle }}">
                        <div class="mt-4">
                            <div class="text-center"><i class="bi bi-building" style="font-size: 54px;"></i></div>
                            <div class="text-center fs-1">{{ $totalEstablishments }}</div>
                            <div><span class="text-center fs-5">Total Establishments</span></div>
                            <div style="margin:5.5rem 0;"></div>
                            <div class="text-center"><i class="bi bi-building-exclamation" style="font-size: 54px;"></i>
                            </div>
                            <div class="fs-1 text-center">{{ $expiredInspectionCount }}</div>
                            <div class="text-center"><span class="fs-5">Expired Inpsection</span></div>
                        </div>
                    </div>

                    <div class="mb-4 d-flex flex-column rounded-3" style="{{ $totalCardStyle }}">
                        <div><i class="bi bi-hourglass-split" style="font-size: 54px;"></i></div>
                        <div class="fs-1">{{ $totalPending }}</div>
                        <div><span class="mx-4 fs-5">Pending Building Plans</span></div>
                        <a href="{{ env('APP_URL') }}/fsec" class="text-white mt-2">View Pending</a>
                    </div>
                </div>
            </div>

        </x-pageWrapper>
    </div>
    <script></script>
@endsection
