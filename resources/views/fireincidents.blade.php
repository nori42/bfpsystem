{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

@section('stylesheet')
    @vite('resources/css/pages/fireincidents.css')
@endsection
{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <x-pageWrapper>
        @if (session('mssg'))
            <x-toast message="{{ session('mssg') }}" type="success" />
        @endif
        <div class="position-sticky bg-white py-3" style="top:0;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-semibold fs-3">Fire Incidents</div>
                    <div class="text-secondary">List of fireincidents within cebu city</div>
                </div>

                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecord"><i
                            class="bi bi-plus-lg"></i> Add Record</button>
                </div>
            </div>
        </div>

        {{-- Modal add record --}}
        <div id="addRecord" class="modal">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content py-4 px-5">
                    <form class="fw-bold" action="/fireincidents" method="POST" autocomplete="off">
                        @csrf
                        @method('post')
                        <legend class="fw-semibold fs-4 mt-3">New Fire Incident</legend>

                        <x-form.input label="Location" name="location" :required="true" />

                        <div class="my-2">
                            <label class="info-label">Substation <span class="text-danger">*</span></label>
                            <select class="form-select" name="substation" id="substation" data-establishment-input required>
                                <option value="" disabled selected>--Select Substation--</option>
                                <x-options.substation />
                            </select>
                        </div>

                        <x-form.input label="Date of incident" name="dateOfIncident" type="date" :required="true" />

                        <button class="btn btn-primary float-end mt-3">Add Record</button>
                    </form>
                </div>
            </div>
        </div>

        <table class="table my-3 table-striped">
            <thead class="position-sticky" style="top:5.5rem;">
                <th>Location</th>
                <th>Substation</th>
                <th>Date of incident</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($fireincidents as $fireincident)
                    <tr class="align-middle">
                        <td>{{ $fireincident->barangay }}</td>
                        <td>{{ $fireincident->substation }}</td>
                        <td>{{ date('F d, Y', strtotime($fireincident->date_of_incident)) }}</td>
                        <td><button class="btn btn-danger" data-bs-toggle="modal" btnKey="{{ $fireincident->id }}"
                                data-bs-target="#deleteModal"><i class="bi bi-trash-fill"></i>Delete</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Modal add record --}}
        <div id="deleteModal" class="modal">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content py-4 px-5">
                    <div id="deleteSpinner" class="text-center d-none my-5">
                        <div class="spinner-border" role="status" style="width: 4rem; height: 4rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="fs-4 mt-2 text-secondary">Deleting Record...</div>
                    </div>
                    <div id="modalDeleteCont">
                        <div class="fs-5 fw-semibold">Do you want to delete this record?</div>
                        <form class="fw-bold" action="/fireincidents/delete" method="POST" autocomplete="off">
                            @csrf
                            @method('post')
                            <input type="hidden" id="deletionId" name="deletionId">
                            <div class="d-flex gap-2 justify-content-end mt-3">
                                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                                <button class="btn btn-danger" id="deleteBtn">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($fireincidents == null || count($fireincidents) == 0)
            <h2 class="text-secondary">No Incidents</h2>
        @endif
    </x-pageWrapper>
@endsection

@section('page-script')
    @vite('resources/js/pages/fireincidents.js')
@endsection
