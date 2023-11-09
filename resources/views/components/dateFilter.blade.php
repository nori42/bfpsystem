@props(['btnName' => 'Date Filter', 'withFsecFlt' => false])

<div class="position-relative" dropdown>
    <button id="btnDateFilter" class="btn btn-primary py-2 px-5" type="button" dropdown-btn>{{ $btnName }}<i
            class="bi bi-caret-down-fill text-white fs-6 mx-1"></i></button>
    <div id="filterMenu" class="p-3 position-absolute bg-subtleBlue boxshadow" style="display: none;" dropdown-menu>
        <label class="fw-bold" for="fromDate">From</label>
        <input class="form-control" type="date" id="dateFrom" name="dateFrom" style="width:18rem;" required>
        <label class="fw-bold mt-2" for="toDate">To</label>
        <input class="form-control" type="date" id="dateTo" name="dateTo" style="width:18rem;" required>
        <input type="radio" name="isAll" id="isAll" hidden>
        {{-- For firedrill --}}
        <button id="btnViewFilter" class="btn btn-primary mt-3 float-end" type="submit">View</button>
    </div>
</div>

@section('component-script')
    <script type="module">
        select('#dateFrom').addEventListener('change', () => {
            select('#dateTo').value = select('#dateFrom').value
        })
    </script>
@endsection
