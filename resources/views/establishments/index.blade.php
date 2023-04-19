@extends('layouts.app')


@section('content')
    <div class="page-content">
        {{-- search and add --}}
        <div class="d-flex align-items-center w-90 mx-auto justify-content-between my-3 mt-5 pr-2 gap-5">

            <form action="/establishments" method="GET"
                class="mb-0 d-flex align-content-stretch p-2 gap-2 rounded-2 search-container"
                style="background-color: #e2e7ed; width: 50%;">
                <input type="text" list="nameList" class="rounded-2 p-2 input-search flex-grow-1 border-0" name="search"
                    id="search" placeholder="Search..." autocomplete="off">
                <datalist id="estabList">
                    {{-- @foreach ($searchList['estabName'] as $establishment)
                    <option value="{{$establishment}}"></option>
                @endforeach --}}
                </datalist>

                <datalist id="nameList">
                    {{-- @foreach ($searchList['names'] as $name)
                    <option value="{{$name}}"></option>
                @endforeach --}}
                </datalist>

                <button class="btn my-auto p-2 btn-search rounded-2">
                    <span class="material-symbols-outlined align-middle">
                        search
                    </span>
                </button>

                <select class="searchFilter px-4" name="searchFilter" id="searchFilter">
                    <option value="name" selected>Name</option>
                    <option value="establishment_name">Establishment</option>
                </select>

                <div class="align-self-center"><b>Total Records:</b> {{ $totalRecords }}</div>
            </form>


            <a class="btn btn-success text-white px-5 py-2 align-middle" href="/establishments/create"><span
                    class="material-symbols-outlined align-middle">domain_add</span> New Establishment</a>
        </div>

        <div class="w-90 overflow-auto mx-auto px-2" style="height: 670px;">
            @if (session('mssg'))
                <h5 class="text-success w-90">{{ session('mssg') }}</h5>
            @endif

            @if ($isSearch && count($establishments) != 0)
                <div class="w-90 py-3 text-success fs-5">{{ count($establishments) }} Result</div>
            @endif

            <table class="table" id="table-estab">
                <thead class="sticky-top top">
                    <tr style="background-color: #1c3b64; color: white;">
                        <th class="p-3">Building Permit No.</th>
                        <th class="p-3">Establishment</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Barangay</th>
                        <th class="p-3">Substation</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- output each record -->
                    @if (count($establishments) == 0)
                        <tr>
                            <td colspan="100" class="py-5 text-center fs-3 fw-bold">No Result</td>
                        </tr>
                    @endif

                    @foreach ($establishments as $establishment)
                        <tr class="align-middle">
                            <td> {{ $establishment->building_permit_no }} </td>
                            <td> {{ $establishment->establishment_name }} </td>
                            <td> {{ $establishment->owner->person->first_name }}
                                {{ $establishment->owner->person->last_name }}</td>
                            <td> {{ $establishment->barangay }} </td>
                            <td> {{ $establishment->substation }} </td>
                            <td class="px-4 position-relative">
                                <div class="m-0 d-flex gap-1">
                                    <a href="/establishments/{{ $establishment->id }}"class="btn btn-success pl-5"><span
                                            class="material-symbols-outlined align-middle">wysiwyg</span>Details</a>
                                    <div class="dropdown-estab">
                                        <button class="btn p-0 fw-bold btn-success h-100"
                                            onclick="toggleShow('estMenu{{ $establishment->id }}')">
                                            <span class="material-symbols-outlined fs-2 align-middle">
                                                menu
                                            </span>
                                        </button>
                                        <div class="dropdown-menus p-2" data-dropdown-menu
                                            id="estMenu{{ $establishment->id }}"
                                            style="display:none !important; left: -38.5px; width: 200px;">
                                            <div class="d-inline flex-column">
                                                <a href="/establishments/fsic/{{ $establishment->id }}"
                                                    class="btn btn-outline-success border-0 w-100 text-end fw-semibold">Fire
                                                    Safety Inspection</a>
                                                <a href="/establishments/fsec/{{ $establishment->id }}"
                                                    class="btn btn-outline-success border-0 w-100 text-end fw-semibold">Fire
                                                    Safety Evaluation</a>
                                                <a href="/establishments/firedrill/{{ $establishment->id }}"
                                                    class="btn btn-outline-success border-0 w-100 text-end fw-semibold">Fire
                                                    Drill</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <script src="{{ asset('js/search.js') }}"></script>

    <script defer>
        document.getElementById('searchFilter').addEventListener('change', () => {
            switch (document.getElementById('searchFilter').value) {
                case 'establishment_name':
                    document.getElementById('search').setAttribute('list', "estabList")
                    break;
                case 'substation':
                    document.getElementById('search').setAttribute('list', "substationList")
                    break;
                case 'barangay':
                    document.getElementById('search').setAttribute('list', "barangayList")
                    break;
                case 'name':
                    document.getElementById('search').setAttribute('list', "nameList")
                    break;
                default:
                    break;
            }

        })

        const search = document.querySelector("#search")
        const datalist = document.querySelector("#nameList")
        search.addEventListener('input', (ev) => {
            populateSearchSuggestion("{{ env('APP_URL') }}", ev.target.value, datalist)
        })
    </script>
@endsection
