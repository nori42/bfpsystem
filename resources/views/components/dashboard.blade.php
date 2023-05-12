@props(['for'])


<div class="dashboardSearch">
    <div style="width:50%;">
        <h1 class="text-white text-center py-5" style="font-size: 3rem;">
            {{ $for == 'establishment' ? 'Search Establishments' : 'Search Building Plan' }}</h1>

        @php
            $urlResource = $for == 'establishment' ? 'establishments/search' : 'resources/buildingplans';
        @endphp
        <form action={{ $urlResource }} method="POST">
            @csrf
            <div class="w-100">

                {{-- Hidden Values --}}
                <input name="userType" type="text" class="d-none" value="{{ auth()->user()->type }}">

                <input type="text" id="search" name="search" class="form-control fs-4 rounded-2"
                    list="establishments" autocomplete="off">
                @if ($for == 'establishment')
                    <div class="text-center fs-5" style="color:#CBCBCB;">Search by Business Permit, Owner Name or
                        Establishment
                        Name</div>
                @else
                    <div class="text-center fs-5" style="color:#CBCBCB;">Search by Building Permit or Owner Name </div>
                @endif

                <input class="visually-hidden" type="submit" value="Search">
            </div>
        </form>
        <datalist id="establishments">
        </datalist>

        <div class="text-center fs-5 py-2" style="color: #CBCBCB;"></div>
    </div>
</div>

@if ($for == 'establishment')
    {{-- Fetching the establishments --}}
    <script src="{{ asset('js/fetch.js') }}"></script>
    <script>
        const searchInput = document.querySelector('#search');
        const datalist = document.querySelector('#establishments')

        searchInput.addEventListener('input', (ev) => {
            populateEstablSearchSuggestion("{{ env('APP_URL') }}", ev.target.value, datalist)
        })
    </script>
@endif
