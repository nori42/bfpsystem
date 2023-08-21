{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        @if (session('toastMssg') != null)
            <x-toast :message="session('toastMssg')" />
        @endif

        <x-pageWrapper>
            <div class="d-flex align-items-center gap-4">
                <div>
                    <span class="d-block fw-bold fs-3">Expired inspections</span>
                    {{-- <select name="expired" id="expiredSelect" class="fs-4 form-select">
                        <option value="inspection">Expired Inspections</option>
                        @if (auth()->user()->type == 'ADMINISTRATOR')
                            <option value="firedrill">Expired Firedrills</option>
                        @endif
                    </select> --}}
                    <span class="d-block fs-6 text-secondary">List of establishments with expired inspection</span>
                </div>
                <form action="/expired/inspections" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold" for="fromDate">From</label>
                    <input class="form-control" type="date" id="dateFrom" name="dateFrom" style="width:18rem;"
                        value="" required>

                    <label class="fw-bold" for="toDate">To</label>
                    <input class="form-control" type="date" id="dateTo" name="dateTo" style="width:18rem;"
                        value="" required>
                    <button id="btnViewExpired" class="btn btn-success">View Expired Inpsections</button>
                </form>
            </div>

            {{-- Loading --}}
            <h2 class="text-secondary text-center mt-5 d-none" id="loadingMssg">Fetching Data...</h2>

            <div id="pageContent">
                <div class="my-3 float-end fw-bold fs-6">
                    @if ($dateRange[0] != null && $dateRange[1] != null && $dateRange[0] != $dateRange[1])
                        <div>
                            <span>{{ date('F d, Y', strtotime($dateRange[0])) }}</span>
                            <span> - </span>
                            <span>{{ date('F d, Y', strtotime($dateRange[1])) }}</span>
                        </div>
                    @else
                        @if ($dateRange[0] == null)
                            {{-- <span>{{ date('F d, Y', strtotime($dateQuery)) }}</span> --}}
                        @else
                            <span>{{ date('F d, Y', strtotime($dateRange[0])) }}</span>
                        @endif
                    @endif
                </div>

                @if ($dateRange[0] == null)
                    <h2 class="text-secondary my-3">Select a date range</h2>
                @endif
                @if ($dateRange[0] != null)
                    <table class="table">
                        <thead>
                            <th>Establishment Name</th>
                            <th>Owner</th>
                            <th>Substation</th>
                            <th>Barangay</th>
                            <th>Expiry Date</th>
                        </thead>
                        <tbody>
                            @foreach ($expired_inspections as $inspection)
                                @php
                                    $person = $inspection->establishment->owner->person ? $inspection->establishment->owner->person : null;
                                    $corporate = $inspection->establishment->owner->corporate ? $inspection->establishment->owner->corporate : null;
                                    
                                    $representative = null;
                                    
                                    if ($person->last_name != null) {
                                        $representative = $person->first_name . ' ' . $person->last_name;
                                    } else {
                                        $representative = $corporate->corporate_name;
                                    }
                                    
                                @endphp
                                <tr>
                                    <td>
                                        <a href="/establishments/{{ $inspection->establishment->id }}/fsic">
                                            {{ $inspection->establishment->establishment_name }}
                                        </a>
                                    </td>
                                    <td>{{ $representative }}</td>
                                    <td>{{ $inspection->establishment->substation }}</td>
                                    <td>{{ $inspection->establishment->barangay }}</td>
                                    <td>{{ date('m/d/Y', strtotime($inspection->expiry_date)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($expired_inspections == null || count($expired_inspections) == 0)
                        <h2 class="text-secondary">No Expired Inspection</h2>
                    @endif
                @endif
            </div>
        </x-pageWrapper>
    </div>

    <script defer>
        const dateFrom = document.querySelector(["#dateFrom"])
        const dateTo = document.querySelector(["#dateTo"])

        const loadingMssg = document.querySelector(["#loadingMssg"])
        const activtiyContent = document.querySelector(["#pageContent"])

        const expiredSelect = document.querySelector(['#expiredSelect'])

        document.querySelector('#btnViewExpired').addEventListener('click', () => {
            if (dateFrom.value != "" && dateTo.value != "") {
                loadingMssg.classList.remove('d-none')
                activtiyContent.classList.add('d-none')
            }
        })

        expiredSelect.addEventListener('change', () => {
            window.location.href = '/expired/firedrills'
        })

        dateFrom.addEventListener('change', () => {
            dateTo.value = dateFrom.value
        })
    </script>
@endsection
