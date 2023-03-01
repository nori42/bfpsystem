@extends('layouts.layout')


@section('content')
    <style>
        .btn-show{
            background-color: #53A3D8;
            color: black;
            font-weight: 600;
            width: 80%;
        }
        .btn-show:hover{
            background-color: #53A3D8 !important;
            color: black !important;
        }

        .owner-info .btn:hover {
            background-color: #8ED2FF !important;
            color: black !important;
        }

        .info {
            border: 1px solid gray;
            padding: .4rem .3rem;
            background: white;
            border-radius: .5rem;
            width: 100%;
        }

        .info-label {
            font-weight: 700;
        }

        #editBtn{
            background: #53A3D8;
            color: #FFFFFF;
            cursor: pointer;
        }

        #saveBtn{
            background-color: #28A644;
            margin-right: 5px;
            cursor: pointer;
            display: none;
        }

        .editable{
            border: 2px solid;
            border-color: #28A644;
            outline: #28A644;
        }

    </style>

    <div class="page-content">
        {{-- Put page content here --}}
        
        {{-- Details Action --}}
        <div class="d-flex justify-content-between gap-4 w-75 mx-auto mt-5">
            <button class="btn btn-show fs-5">FSEC</button>
            <a href="/establishments/fsic/{{$establishment->record_no}}" class="btn btn-show fs-5">FSIC</a>
            <button class="btn btn-show fs-5">FIRE DRILL</button>
        </div>

        {{-- Owner Info & Selected Establishment --}}
        <div class="w-75 mx-auto ">
            <div class="pt-5 d-flex justify-content-between owner-info ">
                <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
                <button type="button" class="btn btn-show btn-lg" id="Mbutton" >Establishment</button>
            </div>

            <div class="fs-5">Record No.: {{$establishment->record_no}}</div>
            <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;">
                <span class="fw-bold">Selected Establishment: </span>{{$establishment->establishment_name}}
                <span class="float-start text-decoration-none px-2 rounded-1 text-black" id="editBtn">Edit Details</span>
                <span class="float-start text-decoration-none px-2 rounded-1 text-white" id="saveBtn">Done</span>
                <input type="hidden" value="false" id="isEditable">
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>

        {{-- Establishment Info --}}
        <form class="w-75 mx-auto mt-3 py-3 px-5" style="background-color: #EFEFEF;" action="/establishments/update" method="POST" id="updateForm">
            {{-- add @csrf every form --}}
            @csrf
            <input type="hidden" name="record_no" value="{{$establishment->record_no}}">
            <div class="my-2">
                <label class="info-label">Establishment Name</label>
                <input class="info" type="text" value="{{$establishment->establishment_name}}" name="establishmentName" readonly>
            </div>
            
            <div class="my-2">
                <label class="info-label">Corporate Name</label>
                <input class="info" type="text" value="{{$establishment->corporate_name}}" name="corporateName" readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Substation</label>
                
                {{-- arrays of sub-stations --}}
                @php
                    $stations = [
                        'CCSF','CPB','GUADALUPE','LABANGON','LAHUG','MABOLO','PAHINA CENTRAL','PARDO','PARI-AN','SAN NICOLAS','TALAMBAN'
                    ];
                @endphp

                <div class="my-2">
                    <label class="info-label">Substation</label>
                    <select class="info" name="substation" id="substation" readonly>
                        <option value="">Select Substation</option>
                        @foreach ($stations as $station)
                            @if($establishment->substation == $station)
                                <option value="{{$station}}" selected>{{$station}}</option>
                            @endif
                            <option value="{{$station}}">{{$station}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">Sub Type</label>
                    <input class="info" type="text" value="{{$establishment->sub_type}}" name="subType" readonly>
                </div>

                <div class="my-2 w-100">
                    <label class="info-label">Building Type</label>
                    <input class="info" type="text" value="{{$establishment->building_type}}" name="buildingType" readonly>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">No Of Storey</label>
                    <input class="info" type="text" value="{{$establishment->no_of_story}}" name="noOfStory" readonly>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Height</label>
                    <input class="info" type="text" value="{{$establishment->height}}" name="height" readonly>
                </div>
            </div>

            <div class="my-2">
                <label class="info-label">Building Permit No.</label>
                <input class="info" type="text" value="{{$establishment->building_permit_no}}" name="buildingPermitNo" readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Name of Fire Insurance Co/Co-Insurer</label>
                <input class="info" type="text" value="{{$establishment->fire_insurance_co}}" name="fireInsuranceCo" readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Latest Mayor's/Business Permit</label>
                <input class="info" type="text" value="{{$establishment->latest_permit}}" name="latestPermit" readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Barangay</label>
                <input class="info" type="text" value="{{$establishment->barangay}}" name="barangay" readonly>
            </div>

            <div class="my-2">
                <label class="info-label">Address</label>
                <input class="info" type="text" value="{{$establishment->address}}" name="address" readonly>
            </div>
        </form>
        
    </div>


<!-- The Modal -->
<div id="Modalowner" class="modal " >

  <!-- Modal content -->
  <div class="modal-content ">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Owner Information</h5>
    </div>
    <div class="modal-body">
    <label for="recipient-name" class="col-form-label">Record No.:</label>
    </div>
    <div class="modal-body" >
        <form>
        <div class="form-group d-flex justify-content-between" style="width:100%;">
            <div class=".col-md-6">
            
                <label class="col-form-label">First-Name:</label>
                <input type="text" class="form-control">
                
            </div>
            <br>
            <div class=".col-md-6">
            
                <label class="col-form-label">Middle-Name:</label>
                <input type="text" class="form-control">
                
            </div>
            <br>
            <div class=".col-md-6">
            
                <label class="col-form-label">Last-Name:</label>
                <input type="text" class="form-control">
                
            </div>
          </div>
          
         
        </form>
        <form>
          <div class="form-group d-flex justify-content-between" style="width:100%;">
            <div class=".col-md-6">
            
                <label class="col-form-label">Contact No.:</label>
                <input type="text" class="form-control">
                
            </div>
            <br>
            <div class=".col-md-6">
            
                <label class="col-form-label">Address:</label>
                <input type="text" class="form-control" style="width: 450px">
                
            </div>
            <div class=".col-md-6">

            </div>
            
          </div>
          
         
        </form>
    </div>
  </div>
</div>

<script src="/js/script.establishment-edit.js"></script>
@endsection