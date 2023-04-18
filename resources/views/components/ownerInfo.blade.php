@props(['establishment', 'owner'])

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Owner Information</h5>
</div>

<form>
    <div class="d-flex gap-2">
        <div class="my-2 w-100">
            <label class="info-label">First Name</label>
            <input type="text" class="form-control input-lg" value="{{ $establishment->owner->first_name }}" disabled>
        </div>

        <div class="my-2 w-100">
            <label class="info-label">Middle Name</label>
            <input type="text" class="form-control input-lg" value="{{ $establishment->owner->middle_name }}"
                disabled>
        </div>
        <div class="my-2 w-100">
            <label class="info-label">Last Name</label>
            <input type="text" class="form-control input-lg" value="{{ $establishment->owner->last_name }}" disabled>
        </div>
    </div>

    <div class="d-flex gap-3">
        <div class="my-2 w-100">
            <label class="info-label">Contact No.</label>
            <input type="text" class="form-control info-lg" value="{{ $establishment->owner->contact_no }}" disabled>
        </div>

    </div>
</form>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Owner Establishment(s)</h5>
</div>

<!--Establishment Table-->
<div class="w-100 h-75 overflow-y-auto mx-auto mt-4 border-3" style="height: 300px !important;">
    <table class="table">
        <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
            <th>Rec No.</th>
            <th>Establishment</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($owner->establishment as $establishment)
                <tr>
                    <td>{{ $establishment->id }}</td>
                    <td>{{ $establishment->establishment_name }}</td>
                    <td><a href="/establishments/{{ $establishment->id }}" class="btn btn-success">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <a  class="btn btn-success btn-lg fs-5" href="/establishments/create/{{$establishment->owner_id}}" >Add New Establishment</a> --}}
    <div class="d-flex justify-content-end">
        <a class="btn btn-success text-white px-5 py-2 align-middle"
            href="/establishments/create/{{ $establishment->owner_id }}"><span
                class="material-symbols-outlined align-middle">domain_add</span>Add New Establishment</a>
    </div>
</div>
