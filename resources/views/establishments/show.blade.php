@extends('layouts.layout')


@section('content')
    <style>
        .btn-show{
            background-color: #1C3B64;
            color: white;
            font-weight: 600;
            width: 80%;
        }
        .btn-show:hover{
            background-color: #234a7d !important;
            color: white !important;
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
            <a href="/establishments/fsec/{{$establishment->id}}" class="btn btn-show fs-5">FSEC</a>
            <a href="/establishments/fsic/{{$establishment->id}}" class="btn btn-show fs-5">FSIC</a>
            <a href="/establishments/firedrill/{{$establishment->id}}" class="btn btn-show fs-5">FIRE DRILL</a>
        </div>

        {{-- Owner Info & Selected Establishment --}}
        <div class="w-75 mx-auto ">
            <div class="pt-5 d-flex justify-content-between owner-info ">
                <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
                <button type="button" class="btn btn-show px-4 py-2" id="button" style="width:auto !important" onclick="openModal('modalOwner')">Owner Info</button>
            </div>

            <div class="fs-5">Record No.: {{$establishment->id}}</div>
            <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;">
                <span class="fw-bold">Selected Establishment: </span>{{$establishment->establishment_name}}
                <span class="float-start text-decoration-none px-2 rounded-1 text-black" id="editBtn">Edit Details</span>
                <span class="float-start text-decoration-none px-2 rounded-1 text-white" id="saveBtn">Done</span>
                <input type="hidden" value="false" id="isEditable">
            </div>
        </div>

        {{-- Establishment Info --}}
        <form class="w-75 mx-auto mt-3 py-3 px-5" style="background-color: #EFEFEF;" action="/establishments/create" method="POST" id="updateForm">
            {{-- add @csrf every form --}}
            @csrf
            <input type="hidden" name="id" value="{{$establishment->id}}">
            <div class="my-2">
                <label class="info-label">Establishment Name</label>
                <input class="info" type="text" value="{{$establishment->establishment_name}}" name="establishmentName" readonly>
            </div>
            
            <div class="my-2">
                <label class="info-label">Corporate Name</label>
                <input class="info" type="text" value="{{$establishment->corporate_name}}" name="corporateName" readonly>
            </div>

            <div class="my-2">                
                {{-- arrays of sub-stations --}}
                @php
                    $stations = [
                        'CCSF','CPB','GUADALUPE','LABANGON','LAHUG','MABOLO','PAHINA CENTRAL','PARDO','PARI-AN','SAN NICOLAS','TALAMBAN'
                    ];

                    $building_type = [
                        'Small', 'Medium', 'Large', 'High Rise'
                    ]
                @endphp

                <div class="my-2">
                    <label class="info-label">Substation</label>
                    <select class="info" name="substation" id="substation" disabled>
                        <option value="">Select Substation</option>
                        @foreach ($stations as $station)
                            @if($establishment->substation == $station)
                                <option value="{{$station}}" selected>{{$station}}</option>
                            @else
                                <option value="{{$station}}">{{$station}}</option>
                            @endif
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
                    <select class="info"  name="buildingType" id="buildingType" readonly>
                        <option value="">Select Building Type</option>
                        @foreach ($building_type as $btype)
                            @if($establishment->building_type == $building_type)
                                <option value="{{$btype}}" selected>{{$btype}}</option>
                            @else
                                <option value="{{$btype}}">{{$btype}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">No Of Storey</label>
                    <input class="info" type="text" value="{{$establishment->no_of_storey}}" name="no_of_storey" readonly>
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
<div id="modalOwner" class="modal">

  <!-- Modal content -->
  <div class="modal-content ">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Owner Information</h5>
    </div>

        <form>
            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">First Name</label>
                    <input type="text"  class="form-control input-lg" value="{{$establishment->first_name}}" disabled>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Middle Name</label>
                    <input type="text" class="form-control input-lg" value="{{$establishment->middle_name}}" disabled>
                </div>
                <div class="my-2 w-100">
                    <label class="info-label">Last Name</label>
                    <input type="text" class="form-control input-lg" value="{{$establishment->last_name}}" disabled>
                </div>
            </div>
            
            <div class="d-flex gap-3">
                <div class="my-2 w-100">
                    <label class="info-label">Contact No.</label>
                    <input type="text" class="form-control info-lg" value="{{$establishment->contact_no}}" disabled>
                </div>
                
            </div>
            
        </form>
        
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Owner Establishment(s)</h5>
        </div>
        <a  class="btn btn-success btn-lg fs-5" onclick="openModal('NewEstablishment')" >Add New Establishment for this Owner</a>
        <!--Establishment Table-->
        <div class="w-75 h-75 overflow-y-auto mx-auto mt-4 border-3">
            <table class="table">
                <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                    <th>Rec No.</th>
                    <th>Establishment Name</th>
                    <th></th>
                    <th></th>
                    
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->establishment_name}}</td>
                        <td><button class="btn btn-success">Update</button></td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
  </div>


</div>

<!-- The Modal -->
<div id="NewEstablishment" class="modal">

    <!-- Modal content -->
    <div class="modal-content ">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Owner Information</h5>
      </div>
  
          <form action="/establishments/owner/create/{{$establishment->owner_id}}" method="POST">
            @csrf
            <div class="w-75 mx-auto mt-3 py-3 px-5 rounded-2 page" style="background-color: #EFEFEF;" id="establismentDetails">
                <div class="header">
                    <h2>Establishment Information</h2>
                </div>
                <hr>
                <div class="my-2">
                    <label class="info-label">Establishment Name</label>
                    <input type="text" id="establishmentName" name="establishmentName" class="input" required>
                </div>
                
                <div class="my-2">
                    <label class="info-label">Corporate Name</label>
                    <input type="text" id="corporateName" name="corporateName" class="input">
                </div>
    
                <div class="my-2">
                    <label class="info-label">Occupancy</label>
                    <select name="occupancy" id="occupancy" required>
                        <option value="">Select Occupancy</option>
                        @foreach ($occupancies as $occupancy)
                            <option value="{{$occupancy['OCCUPANCY_TYPE']}}">{{$occupancy['OCCUPANCY_TYPE']}}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Sub Type</label>
                    <select name="subType" id="subType" required>
                        <option value="">Select Sub Type</option>
                        @foreach ($occupancies as $occupancy)
                            <option value="{{$occupancy['OCCUPANCY_TYPE']}}">{{$occupancy['OCCUPANCY_TYPE']}}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="d-flex gap-2">
                    <div class="my-2 w-100">
                        <label class="info-label">Substation</label>
                        <select name="substation" id="substation" required>
                            <option value="">Select Substation</option>
                            @foreach ($stations as $station)
                                <option value="{{$station}}">{{$station}}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="my-2 w-100">
                        <label class="info-label">Building Type</label>
                        <select name="buildingType" id="buildingType" required>
                            <option value="">Select Building Type</option>
                            @foreach ($building_type as $btype)
                                <option value="{{$btype}}">{{$btype}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="my-2 w-100">
                        <label class="info-label">No Of Storey</label>
                        <input type="text" id="noOfStory" name="noOfStory" class="input" required>
                    </div>
        
                    <div class="my-2 w-100">
                        <label class="info-label">Height</label>
                        <input type="text" id="height" name="height" class="input" required>
                    </div>
                </div>
        
                <div class="my-2">
                    <label class="info-label">Building Permit No.</label>
                    <input type="text" id="buildingPermitNo" name="buildingPermitNo" class="input" required>
                </div>
        
                <div class="my-2">
                    <label class="info-label">Name of Fire Insurance Co/Co-Insurer</label>
                    <input type="text" id="fireInsuranceCo" name="fireInsuranceCo" class="input" required>
                </div>
        
                <div class="my-2">
                    <label class="info-label">Latest Mayor's/Business Permit</label>
                    <input type="text" id="latestPermit" name="latestPermit" class="input" required>
                </div>
        
                <div class="my-2">
                    <label class="info-label">Barangay</label>
                    <input type="text" id="barangay" name="barangay" class="input" required>
                </div>
        
                <div class="my-2">
                    <label class="info-label">Address</label>
                    <input type="text" id="address" name="address" class="input" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-lg fs-5">Add New Establishment for this Owner</button>
          </form>
          
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Owner Establishment(s)</h5>
          </div>
          
         
      </div>
    </div>
  
  
  </div>

<script src="/js/script.establishment-edit.js"></script>
@endsection
