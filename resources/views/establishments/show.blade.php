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
            border-radius: .5rem
        }

        .info-label {
            font-weight: 700;
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
        <div class="w-75 mx-auto">
            <div class="pt-5 d-flex justify-content-between owner-info">
                <h5 class="fw-bold"> Owner: {{$establishment->last_name." ".$establishment->first_name." ".$establishment->middle_name}}</h5>
                <button type="button" class="btn btn-show " id="Mbutton" >Establishment</button>
                
            </div>

            <div class="fs-5">Record No.: {{$establishment->record_no}}</div>
            <div class="w-100 text-black p-2 mt-2 fw-semibold" style="background-color: #D9D9D9;"><span class="fw-bold">Selected Establishment: </span>{{$establishment->establishment_name}}</div>
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
        <div class="w-75 mx-auto mt-3 py-3 px-5" style="background-color: #EFEFEF;">

            {{-- info --}}
            <div class="my-2">
                <label class="info-label">Establishment Name</label>
                <div class="info">{{$establishment->establishment_name}}</div>
            </div>
            
            <div class="my-2">
                <label class="info-label">Corporate Name</label>
                <div class="info">{{$establishment->corporate_name}}</div>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">Sub Type</label>
                    <div class="info">{{$establishment->sub_type}}</div>
                </div>

                <div class="my-2 w-100">
                    <label class="info-label">Building Type</label>
                    <div class="info">{{$establishment->building_type}}</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="my-2 w-100">
                    <label class="info-label">No Of Storey</label>
                    <div class="info">{{$establishment->no_of_story}}</div>
                </div>
    
                <div class="my-2 w-100">
                    <label class="info-label">Height</label>
                    <div class="info">{{$establishment->height}}</div>
                </div>
            </div>

            <div class="my-2">
                <label class="info-label">Building Permit No.</label>
                <div class="info">{{$establishment->building_permit_no}}</div>
            </div>

            <div class="my-2">
                <label class="info-label">Name of Fire Insurance Co/Co-Insurer</label>
                <div class="info">{{$establishment->fire_insurance_co}}</div>
            </div>

            <div class="my-2">
                <label class="info-label">Latest Mayor's/Business Permit</label>
                <div class="info">{{$establishment->latest_permit}}</div>
            </div>

            <div class="my-2">
                <label class="info-label">Barangay</label>
                <div class="info">{{$establishment->barangay}}</div>
            </div>

            <div class="my-2">
                <label class="info-label">Address</label>
                <div class="info">{{$establishment->address}}</div>
            </div>
        </div>
        
    </div>


<!-- The Modal -->
<div id="Modalowner" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="header">
        <h2>Owner Information</h3>
    </div>
  </div>

</div>


    
@endsection