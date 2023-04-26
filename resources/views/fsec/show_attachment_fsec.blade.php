@extends('layouts.layout')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
<a href="/establishments/{{$establishment->id}}" class="material-symbols-outlined btn-back mt-5">
    arrow_back
</a>
<div class="page-content">
        {{-- Put page content here --}}

        {{-- Owner Info & Selected Establishment --}}
    <div class="w-75 mx-auto">
        <div class="fs-5">Record No.: {{$establishment->id}}</div>

        <div>
            <p class="fs-5 mb-0"> Owner: {{$establishment->owner->last_name.", ".$establishment->owner->first_name." ".$establishment->owner->middle_name}}</p>
            <p class="fw-bold fs-5">Establishment: {{$establishment->establishment_name}}</p>
        </div>
        <div class="position-relative">
            <button type="button" class="btn btn-outline-success" style="width:auto !important" data-dropdown-btn onclick="toggleShow('establishmentDetail',this)"><span class="material-symbols-outlined fs-3 align-middle">domain</span>Establishment Info</button>
            <div class="dropdown-menus position-absolute p-3" id="establishmentDetail" data-dropdown-menu style="display: none !Important">
                <ul class="list-unstyled">
                    <li><span class="fw-bold">Establishment Name: </span>{{$establishment->establishment_name}}</li>
                    <li><span class="fw-bold">Substation: </span>{{$establishment->substation}}</li>
                    <li><span class="fw-bold">Occupancy: </span>{{$establishment->occupancy}}</li>
                    <li><span class="fw-bold">Sub Type: </span>{{$establishment->sub_type}}</li>
                    <li><span class="fw-bold">Building Type: </span>{{$establishment->building_type}}</li>
                    <li><span class="fw-bold">No. of storey: </span>{{$establishment->no_of_storey}}</li>
                    <li><span class="fw-bold">Height: </span>{{$establishment->height}}</li>
                    <li><span class="fw-bold">Building Permit: </span>{{$establishment->building_permit_no}}</li>
                    <li><span class="fw-bold">Fire Insurance Co: </span>{{$establishment->fire_insurance_co}}</li>
                    <li><span class="fw-bold">Latest Permit: </span>{{$establishment->latest_permit}}</li>
                    <li><span class="fw-bold">Barangay: </span>{{$establishment->barangay}}</li>
                    <li><span class="fw-bold">Address: </span>{{$establishment->address}}</li>
                </ul>
            </div>
            <button type="button" class="btn btn-outline-success" style="width:auto !important" onclick="openModal('modalOwner')"><span class="material-symbols-outlined fs-3 align-middle">account_box</span>Owner Info</button>
        </div>
{{--         
        @if (session('mssg'))
        <div class="mt-3">
            <h5 class="text-success w-90 w-25">{{session('mssg')}} {{session('files')}}</h5>
        </div>
        @endif --}}
    </div>

    {{-- FSEC Action --}}
    
    <div class="d-flex justify-content-between w-75 mx-auto mt-5">
        <a href="/establishments/fsec/{{$establishment->id}}"  id="btnPayment" class="btn btn-action rounded-0 fs-5 ">Process</a>
        <a href="/establishments/fsec/attachment/{{$establishment->id}}/fsec"  id="btnAttachments" class="btn btn-action rounded-0 fs-5 fsic-active">Attachments</a>
    </div>

    <div class="d-flex justify-content-end w-75 mx-auto pt-3">
        <button class="btn btn-success" id="addPaymentBtn" onclick="openModal('addAttachmentModal')">
            <span class="material-symbols-outlined align-middle">
                attach_file
            </span>
            Add Attachment
        </button>
    </div>
        {{-- Attachments --}}
        <div id="attachments" class="w-75 h-75 overflow-y-auto mx-auto mt-4 border-3">
            <table class="table">
                <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                    <th>File</th>
                    <th>File Extension</th>
                    <th>Date Added</th>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                    <tr>
                        <td><a href="/download/attachments/{{$file->file_path}}">{{$file->file_name}}</a></td>
                        <td>{{$file->file_extension}}</td>
                        <td>{{$file->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        

        <!-- The Modal -->
        {{--Attachment--}}
        <div id="addAttachmentModal" class="modal" data-modal>
            <!-- Modal content -->
            <div class="modal-content" style="font-size: 0.9rem;">
                <div class="bg-secondary-subtle filelist-container" style="display: none;">
                    <div class="overflow-y-auto pb-0" style="height: 150px;">
                        <ul class="list-unstyled filelist p-3 fw-bold text-center">
                        </ul>
                    </div>
                    <button id="submitFile" class="btn btn-success float-start" type="button" onclick="uploadFile()">Submit Files</button>
                </div>
                <form id="fileFormFsec" class="rounded-2 d-flex flex-column justify-content-center gap-3 mx-auto w-100" action="/establishments/attachment/fsec/{{$establishment->id}}/upload" method="POST" enctype="multipart/form-data" style="height: 190px;">
                    @csrf
                    <div class="h-100 d-flex flex-column gap-3 mt-2">
                        <button id="submitFile" class="btn btn-success ml-auto" type="submit" style="display: none;">Submit Files</button>
                        <div class="h-100 position-relative">
                            <div class="fileuploadicon d-flex flex-column text-center p-2 position-absolute h-100 w-100" style="pointer-events:none;">
                                <div class="my-auto">
                                    <span class="material-symbols-outlined fs-2">description</span>
                                    <span class="material-symbols-outlined fs-2">image</span>
                                    <span class="material-symbols-outlined fs-2">folder</span>
                                </div>
                                <div class="my-auto">
                                    <span>Click To Upload File(s)</span>
                                </div>
                            </div>

                            {{--This is hidden it used for reference --}}
                            {{-- <input class="d-none" id="attachFor" name="attachFor" type="text" value="fsec"/> --}}

                            <input id="fileUpload" name="fileUpload[]" 
                            class="btn bg-secondary-subtle h-100" 
                            type="file" 
                            value="Add"
                            accept="image/*,.docx,.pdf,.doc,.xlsx,.xls,.txt" 
                            multiple 
                            style="width: 100%; opacity: 1%;"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>

         <!-- Modal -->
        {{-- OwnerInfo --}}
        <div id="modalOwner" class="modal" data-modal>

            <!-- Modal content -->
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Owner Information</h5>
            </div>
        
                <form>
                    <div class="d-flex gap-2">
                        <div class="my-2 w-100">
                            <label class="info-label">First Name</label>
                            <input type="text"  class="form-control input-lg" value="{{$establishment->owner->first_name}}" disabled>
                        </div>
            
                        <div class="my-2 w-100">
                            <label class="info-label">Middle Name</label>
                            <input type="text" class="form-control input-lg" value="{{$establishment->owner->middle_name}}" disabled>
                        </div>
                        <div class="my-2 w-100">
                            <label class="info-label">Last Name</label>
                            <input type="text" class="form-control input-lg" value="{{$establishment->owner->last_name}}" disabled>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <div class="my-2 w-100">
                            <label class="info-label">Contact No.</label>
                            <input type="text" class="form-control info-lg" value="{{$establishment->owner->contact_no}}" disabled>
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
                                <td>{{$establishment->id}}</td>
                                <td>{{$establishment->establishment_name}}</td>
                                <td><a href="/establishments/{{$establishment->id}}" class="btn btn-success">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <a  class="btn btn-success btn-lg fs-5" href="/establishments/create/{{$establishment->owner_id}}" >Add New Establishment</a> --}}
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-success text-white px-5 py-2 align-middle" href="/establishments/create/{{$establishment->owner_id}}"><span class="material-symbols-outlined align-middle">domain_add</span>Add New Establishment</a>
                    </div>
                </div>
        
            </div>
            </div>
        
        
        </div>

    </div>
</div>

<script>
    function uploadFile(){
        const modalContent = document.querySelector('#addAttachmentModal').children[0]
        Array.from(modalContent.children).forEach(element => {
            element.style.opacity = '0%';
            element.style.pointerEvents = 'none';
        });
        // Add the loading screen
        modalContent.insertAdjacentHTML('afterbegin','<div><div class="fw-bold fs-5" id="loading-message">Uploading...</div><div id="loading-bar-spinner" class="spinner"><div class="spinner-icon"></div></div></div>') 
        
        // Submit the file
        document.querySelector('#fileFormFsec').submit();
    }

    fileUpload.addEventListener('change', function(){
        const fileUpload = document.querySelector('#fileUpload')
        const files = fileUpload.files

        if(files != null)
        {
            document.querySelector('.filelist-container').style.display = "block"
            document.querySelector('#submitFile').style.display = "block"
            
            const filelist = document.querySelector('.filelist')
            filelist.innerHTML = ""

            Array.from(files).forEach(file => {
                const li = document.createElement('li');
                li.textContent = file.name
                filelist.appendChild(li)
            });
        }
    })
</script>
@endsection