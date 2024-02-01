{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.archive')

@section('archiveContent')
    <div class="mt-3" style="height: 650px">

        <table class="table">
            <thead>
                <th>Establishment Name</th>
                {{-- <th>Owner</th> --}}
                {{-- <th>Total Inspections</th>
                <th>Total Firedrill</th> --}}
                <th>Date Archived</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($establishments as $item)
                    @php
                        // if ($item->last_name != null) {
                        //     $representative = $item->first_name . ' ' . $item->last_name;
                        // } else {
                        //     $representative = $item->corporate_name;
                        // }
                    @endphp
                    <tr>
                        <td>{{ $item->establishment_name }}</td>
                        {{-- <td>{{ $representative }}</td> --}}
                        {{-- <td>{{ count($item->inspection) }}
                        </td>
                        <td>{{ count($item->firedrill) }}</td> --}}
                        <td>{{ date('m/d/Y g:i A', strtotime($item->deleted_at)) }}</td>
                        <td>
                            <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                btnKey="{{ $item->id }}">
                                <i class="bi bi-trash3-fill"></i></i>Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Delete Modal --}}
    <div class="modal" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content px-5 py-4">
                <x-spinner :hidden="true" />
                <div id="deleteModalContent">
                    <div class="fs-5">Do you want to delete this data?</div>
                    <div class="fs-6 text-secondary">This action cannot be reverted.</div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <form action="/establishments/delete" method="post">
                            @csrf
                            <input type="hidden" id="deletionId" name="deletionId">
                            <button class="btn btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        {{ $establishments->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
