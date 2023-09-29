{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')


@section('stylesheet')
    @vite('resources/css/components/spinner.css')
@endsection
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
                    <span class="d-block fw-bold fs-3">Expired Inspection</span>
                    <span class="d-block fs-6 text-secondary">List of establishments with expired inspection</span>
                </div>
                <div id="filterBtns" class="d-flex gap-2">
                    <button id="btnViewAll" class="btn btn-primary">View All</button>
                    <form id="filter" action="/expired/inspections" method="GET">
                        <x-dateFilter />
                    </form>
                </div>
            </div>


            <div id="pageContent">
                <div class="d-flex justify-content-between align-items-center my-3">

                    @if ($dateRange[0] != null || $isAll)
                        <div class="fw-bold">{{ $expired_inspections->count() }}
                            Result{{ $expired_inspections->count() > 1 ? 's' : '' }}</div>
                    @endif

                    <div class=" fw-bold fs-6 ">
                        @if ($dateRange[0] != null && $dateRange[1] != null && $dateRange[0] != $dateRange[1])
                            <div>
                                <span>{{ date('F d, Y', strtotime($dateRange[0])) }}</span>
                                <span> - </span>
                                <span>{{ date('F d, Y', strtotime($dateRange[1])) }}</span>
                            </div>
                        @else
                            @if ($dateRange[0] == null && $isAll)
                                <span>All</span>
                            @endif
                            @if ($dateRange[0] != null)
                                <span>{{ date('F d, Y', strtotime($dateRange[0])) }}</span>
                            @endif
                        @endif
                    </div>
                </div>

                @if ($dateRange[0] == null && !$isAll)
                    <h2 class="text-secondary my-3">Select a date range</h2>
                @endif
                @if ($dateRange[0] != null || $isAll)
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
                                @if ($inspection->establishment == null)
                                    @continue
                                @endif

                                @php
                                    // $person = $inspection->establishment->owner->person ? $inspection->establishment->owner->person : null;
                                    // $corporate = $inspection->establishment->owner->corporate ? $inspection->establishment->owner->corporate : null;
                                    
                                    $representative = $inspection->establishment->getOwnerName();
                                    
                                    // if ($person->last_name != null) {
                                    //     $representative = $person->first_name . ' ' . $person->last_name;
                                    // } else {
                                    //     $representative = $corporate->corporate_name;
                                    // }
                                    
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
                        <h2 class="text-secondary">No Establishment</h2>
                    @endif
                @endif
            </div>
            {{-- Loading --}}
            <div class="d-none" id="loadingMssg">
                <div class="d-flex justify-content-center">
                    <x-spinner2 :hidden="false" />
                </div>
                <h4 class="text-secondary text-center mt-2">Fetching Data...</h4>
            </div>
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    <script type="module" defer>
        function showLoading() {
            select('#loadingMssg').classList.remove('d-none')
            select('#pageContent').classList.add('d-none')
            select('#filterBtns').classList.add('d-none');
        }

        addEvent('click', select('#btnViewFilter'), () => {
            if (select('#dateFrom').value && select('#dateTo').value) {
                showLoading()
            }
        })

        addEvent('click', select('#btnViewAll'), () => {
            select("#isAll").checked = true
            select("#filter").submit()
            showLoading()
        })
    </script>
@endsection
