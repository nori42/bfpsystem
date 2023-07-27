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
                    {{-- <span class="d-block fw-bold fs-3">Expired inspections</span> --}}
                    <select name="expired" id="expiredSelect" class="fs-4 form-select">
                        <option value="inspection">Expired Inspections</option>
                        @if (auth()->user()->type == 'ADMINISTRATOR')
                            <option value="firedrill" selected>No Firedrill</option>
                        @endif
                    </select>
                    <span class="d-block fs-6 text-secondary">List of establishments with expired firedrill</span>
                </div>
                <form action="/expired/inspections" class="d-flex align-items-center gap-2" method="GET">
                    <label class="fw-bold text-nowrap" for="fromDate">Validity Type</label>
                    <label for="quarter">Quarter</label>
                    <input type="radio" name="validityType" id="quarter" value="Quarter">
                    <label for="semester">Semester</label>
                    <input type="radio" name="validityType" id="semester" value="Semester">

                    <select name="quarter" id="validitySelect" class="form-select" style="width:14rem">
                        <option value="inspection">1st Quarter</option>
                        <option value="inspection">2nd Quarter</option>
                        <option value="inspection">3rd Quarter</option>
                        <option value="inspection">4th Quarter</option>
                    </select>

                    <button id="btnViewExpired" class="btn btn-success text-nowrap">View Expired Firedrill</button>
                </form>
            </div>

            {{-- Loading --}}
            <h2 class="text-secondary text-center mt-5 d-none" id="loadingMssg">Fetching Data...</h2>

            <div id="pageContent">
                <div class="my-3 float-end fw-bold fs-5">

                </div>
                <table class="table">
                    <thead>
                        <th>Establishment Name</th>
                        <th>Owner</th>
                        <th>Substation</th>
                        <th>Barangay</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <h2 class="text-secondary">No Expired Firedrill</h2>
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
            window.location.href = '/expired/inspections'
        })

        dateFrom.addEventListener('change', () => {
            dateTo.value = dateFrom.value
        })
    </script>
@endsection
