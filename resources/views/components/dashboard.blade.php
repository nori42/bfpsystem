@props(['for'])

<div class="dashboardSearch">
    <div style="width:50%;">
        <h1 class="text-white text-center py-5" style="font-size: 3rem;">
            {{ $for == 'establishment' ? 'Search Establishments' : 'Search Building Plan' }}</h1>

        @php
            $urlResource = $for == 'establishment' ? 'resources/establishments' : 'resources/buildingplans';
        @endphp
        <form action="{{ $urlResource }}" method="GET">
            <input type="text" id="search" name="search" class="form-control fs-4 w-100 rounded-2"
                list="establishments" autocomplete="off">
        </form>
        <datalist id="establishments">

        </datalist>

        <div class="text-center fs-5 py-2" style="color: #CBCBCB;"></div>
    </div>
</div>

<script src="{{ asset('js/fetch.js') }}"></script>
@if ($for == 'establishment')
    <script>
        const searchInput = document.querySelector('#search');
        const datalist = document.querySelector('#establishments')

        searchInput.addEventListener('input', (ev) => {

            populateEstablSearchSuggestion("{{ env('APP_URL') }}", ev.target.value, datalist)
        })
    </script>
@endif
