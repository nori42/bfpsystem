@props(['for'])

@section('stylesheet')
    @vite(['resources/css/components/search.css'])
@endsection
<div class="dashboardSearch">
    <div style="width:50%;">
        <h1 class="text-white text-center py-5 fw-bold" style="font-size: 2.5rem;">
            {{ $for == 'establishment' ? 'Search Establishments' : 'Search Building Plan Application' }}</h1>

        @php
            $urlResource = $for == 'establishment' ? 'establishments/search' : 'fsec/search';
        @endphp
        <form action={{ $urlResource }} method="POST">
            @csrf
            <div class="w-100">

                {{-- Hidden Values --}}
                <input name="userType" type="hidden" value="{{ auth()->user()->type }}">
                <input id="dataId" name="dataId" type="hidden" value="">
                <div class="position-relative">
                    <div class="d-flex">
                        <input type="text" id="search" name="search"
                            class="form-control fs-4 rounded-2 bg-white text-uppercase" list="searchSuggestion"
                            autocomplete="off" placeholder="SEARCH"
                            style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;">
                        <button class="btn btn-subtleBlue bg-white fs-4"
                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;"><i
                                class="bi bi-search text-dark"></i></button>
                    </div>
                    <ul id="autocomplete-list">
                        <li>Item 1</li>
                    </ul>
                </div>
                @if ($for == 'establishment')
                    <div class="text-center fs-5" style="color:#CBCBCB;">Search by Business Permit, Owner Name
                        or
                        Establishment
                        Name</div>
                @else
                    <div class="text-center fs-5" style="color:#CBCBCB;">Search by Applicant Name</div>
                @endif

                <input class="visually-hidden" type="submit" value="Search">
            </div>
        </form>
        <datalist id="searchSuggestion">
        </datalist>

        <div class="text-center fs-5 py-2" style="color: #CBCBCB;"></div>
    </div>
</div>

@section('component-script')
    {{-- Fetching the establishments --}}
    <script src="{{ asset('js/autocomplete.js') }}"></script>
    <script src="{{ asset('js/fetch.js') }}"></script>
    <script>
        const searchInput = document.querySelector('#search');
        const datalist = document.querySelector('#searchSuggestion')

        if ("{{ $for }}" == "establishment")
            searchInput.addEventListener('input', (e) => {
                selectedIndex = -1;
                if (e.target.value.length != 0) {
                    populateEstablSearchSuggestion("{{ env('APP_URL') }}", e.target.value, datalist);
                } else {
                    hideAutocomplete();
                }
            })
        else {
            searchInput.addEventListener('input', (e) => {
                selectedIndex = -1;
                if (e.target.value.length != 0)
                    populateBuildPlanSearchSuggestion("{{ env('APP_URL') }}", e.target.value, datalist);
                else
                    hideAutocomplete();

            })
        }
    </script>
@endsection
