@props(['for'])


<div class="dashboardSearch">
    <div style="width:50%;">
        <h1 class="text-white text-center py-5" style="font-size: 3rem;">
            {{ $for == 'establishment' ? 'Search Establishments' : 'Search Building Plan' }}</h1>

        @php
            $urlResource = $for == 'establishment' ? 'establishments/search' : 'resources/buildingplans';
        @endphp
        <form action={{ $urlResource }} method="GET">
            <div class="w-100">

                <input type="text" id="search" name="search" class="form-control fs-4 rounded-2"
                    list="establishments" autocomplete="off">
            </div>
        </form>
        <datalist id="establishments">
        </datalist>

        <div class="text-center fs-5 py-2" style="color: #CBCBCB;"></div>
    </div>
</div>

@if ($for == 'establishment')
    <script src="{{ asset('js/fetch.js') }}"></script>
    <script>
        const searchInput = document.querySelector('#search');
        const datalist = document.querySelector('#establishments')

        searchInput.addEventListener('input', (ev) => {
            populateEstablSearchSuggestion("{{ env('APP_URL') }}", ev.target.value, datalist)
        })
    </script>
@endif
