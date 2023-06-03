@extends('layouts.app')


@section('content')
    @php
        $totalSubstation = 0;
        foreach ($issuedThisMonth as $key => $value) {
            if ($key != 'CBP') {
                $totalSubstation += $value;
            }
        }
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        <x-dashboard for="establishment" />
        @if (session()->get('searchQuery'))
            @php
                $message = "\"" . session()->get('searchQuery') . "\"" . ' Returns no result';
            @endphp
            <x-toast :message="$message" />
        @endif
        <x-pageWrapper>
            <div class="d-flex justify-content-center">

                @if (auth()->user()->type === 'FSIC' || auth()->user()->type === 'ADMIN')
                    <a class="btn btn-success text-white px-5 py-2 align-middle mt-1" href="/establishments/create"><span
                            class="material-symbols-outlined align-middle">domain_add</span> New Establishment</a>
                @endif
            </div>
            <h1 class="fs-2 my-5">This Month Report</h1>
            <div class="d-flex">
                <div>
                    <div>
                        <h3 class="m-0">Substations</h3>
                        <div class="col"></div>
                    </div>
                    @foreach ($issuedThisMonth as $key => $value)
                        @if ($key != 'CBP')
                            <div class="row " style="width: 21rem">
                                <div class="col">{{ $key }}</div>
                                <div class="col">{{ $value }}</div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div style="width: 21rem">
                    <h3>Total</h3>
                    <div class="my-4">
                        <div class="row">
                            <div class="col fw-bold">CBP</div>
                            <div class="col">{{ $issuedThisMonth['CBP'] }}</div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">NEW</div>
                            <div class="col">{{ $issuedNewThisMonth }}</div>
                        </div>
                    </div>

                    <div class="my-4">
                        <div class="row">
                            <div class="col fw-bold">Total Substations</div>
                            <div class="col">{{ $totalSubstation }}</div>
                        </div>
                        <div class="row">
                            <div class="col fw-bold">Grand Total</div>
                            <div class="col">{{ $issuedThisMonthAll }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </x-pageWrapper>
    </div>
@endsection
