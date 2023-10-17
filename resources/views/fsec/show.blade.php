@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('stylesheet')
    @vite(['resources/css/pages/buildingplan.show.css'])
@endsection
@section('content')
    @php
        $receipt = $buildingPlan->receipt;

        $applicant = $representative;
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            @if (session('mssg'))
                <x-toast :message="session('mssg')" type="success" />
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <h1 class="fs-3 my-2">Building Plan Application</h1>
                    @switch($buildingPlan->status)
                        @case('APPROVED')
                            <x-tag bgColor="bg-success" text="Approved" />
                        @break

                        @case('DISAPPROVED')
                            <x-tag bgColor="bg-danger" text="Disapproved" />
                        @break

                        @default
                            <x-tag bgColor="bg-warning" text="Pending" />
                    @endswitch

                    @if ($buildingPlan->date_released)
                        <x-tag bgColor="bg-success" text="Released" />
                    @endif
                </div>
                @if ($buildingPlan->date_released == null && $buildingPlan->status == 'APPROVED')
                    {{-- Update the building plan released date --}}
                    <form action="/fsec/release" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="buildingPlanId" value="{{ $buildingPlan->id }}">
                        <button class="btn btn-primary"> Release Certificate</button>
                    </form>
                @endif

                {{-- Actions --}}
                @if ($buildingPlan->status != 'APPROVED')
                    <div class="d-flex gap-2">


                        <a class="btn btn-primary px-4" href="/fsec/{{ $buildingPlan->id }}/edit">
                            <i class="bi bi-pencil-fill mx-1"></i>Update Application</a>

                        <div class="modal" id="deleteModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content px-5 py-4">
                                    <x-spinner :hidden="true" />
                                    <div id="deleteModalContent">
                                        <div class="fs-5">Do you want to delete this application?</div>
                                        <div class="fs-6 text-secondary">This action cannot be reverted.</div>
                                        <div class="d-flex justify-content-end gap-2 mt-3">
                                            <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>

                                            <form action="/fsec/{{ $buildingPlan->id }}/delete" method="POST">
                                                @csrf
                                                <button class="btn btn-danger px-2" onclick="showLoading()">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="position-relative py-0" dropdown>
                            <button class="btn btn-primary px-2" dropdown-btn>Action <i
                                    class="bi bi-caret-down-fill"></i></button>
                            <div id="actionMenu" class="action-menus py-3 px-2 border-1 text-white" dropdown-menu
                                style="display:none !important; width:180px; left:calc(-1 * (100% + 10px));">
                                <ul class="list-unstyled">

                                    <li><a href="/fsec/print/{{ $buildingPlan->id }}"
                                            class="btn btn-primary w-100 text-start"><i
                                                class="bi bi-file-earmark-check mx-2 fs-5"></i>Approve</a></li>
                                    <li><a href="/fsecdisapprove/print/{{ $buildingPlan->id }}"
                                            class="btn btn-outline-danger w-100 mt-2 text-start"><i
                                                class="bi bi-file-earmark-excel mx-2 fs-5"></i>Disapprove</a></li>

                                    <hr style="color: #1a1a1a;">

                                    <li>
                                        <button class="btn btn-danger w-100" data-bs-toggle="modal" dropdown-btn-dismiss
                                            data-bs-target="#deleteModal">
                                            <i class="bi bi-trash3-fill"></i></i>Delete</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <x-detailWrapper>

                <div class="d-flex justify-content-between">
                    <h2 class="fs-4">Permit</h2>
                    @if ($buildingPlan->date_released)
                        <div class="fw-bold">Date Released:{{ date('m/d/Y', strtotime($buildingPlan->date_released)) }}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <x-info label="Applicant Name" :value="$applicant" />
                </div>
                <div class="row my-3">
                    <x-info label="Series No." :value="$buildingPlan->series_no" />
                    <x-info label="Application No." :value="$buildingPlan->bp_application_no" />
                    <x-info label="Bill of Materials(BOQ)" :value="$buildingPlan->bill_of_materials ? $buildingPlan->bill_of_materials : 'N/A'" />
                    <x-info label="Date Received." value="{{ date('m/d/Y', strtotime($buildingPlan->date_received)) }}" />
                </div>
                <div class="row">
                    <x-info label="Name of Building/Structure/Facility" :value="$buildingPlan->name_of_building ? $buildingPlan->name_of_building : 'N/A'" />
                    <x-info label="Project Title" :value="$buildingPlan->project_title ? $buildingPlan->project_title : 'N/A'" />
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
                <div class="row my-3">
                    <x-info label="Building Story" :value="$buildingPlan->building_story ? $buildingPlan->building_story : 'N/A'" />
                    <x-info label="Floor Area" :value="$buildingPlan->floor_area ? $buildingPlan->floor_area : 'N/A'" />
                    <x-info label="Occupancy" :value="$buildingPlan->occupancy" />
                    <x-info label="Sub Type" :value="$buildingPlan->sub_type" />
                </div>
                <div class="my-3">
                    <x-info label="Address" :value="$buildingPlan->address" />
                </div>
                <h2 class="fs-4 mt-4">Receipt</h2>

                @if ($receipt->or_no)
                    <div class="row w-50">
                        <x-info label="OR No." :value="$receipt->or_no ? $receipt->or_no : 'N/A'" />
                        @php
                            $pesoSign = '₱';
                        @endphp
                        <x-info label="Amount" :value="$receipt->amount ? $pesoSign . $receipt->amount : 'N/A'" />
                        <x-info label="Date of Payment" value="{{ date('m/d/Y', strtotime($receipt->date_of_payment)) }}" />
                    </div>
                @else
                    <div class="text-secondary fs-5">No Payment (Update the application if available)</div>
                @endif
            </x-detailWrapper>
            <hr>
            <h1 class="fs-3 my-2">Evaluation List</h1>
            <table class="table">
                <thead>
                    <th>Remarks</th>
                    <th>Evaluation Date</th>
                    <th>Evaluator</th>
                    <th>Disapproval Notice</th>
                    <th>Checklist</th>
                </thead>
                <tbody>
                    @foreach ($evaluations as $evaluation)
                        <tr>
                            <td><span
                                    class="{{ $evaluation->remarks == 'DISAPPROVED' ? 'text-danger' : 'text-success' }}">{{ $evaluation->remarks }}</span>
                            </td>
                            <td>{{ date('m/d/Y', strtotime($evaluation->created_at)) }}</td>
                            <td>{{ $evaluation->evaluator }}</td>
                            <td>
                                @if ($evaluation->remarks == 'APPROVED')
                                    <span class="text-success">{{ $evaluation->remarks }}</span>
                                @else
                                    @if ($evaluation->disapprove_print_path == null)
                                        <button class="btn btn-primary" data-bs-toggle="modal" btnUplDisapp
                                            evaluationId="{{ $evaluation->id }}" data-bs-target="#addUploadModal">Upload <i
                                                class="bi bi-upload"></i>
                                        </button>
                                    @else
                                        <a href="/download/evaluations/disapproval/_{{ $evaluation->id }}">Disapproval
                                            Notice <i class="bi bi-file-earmark-arrow-down-fill"></i></a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($evaluation->remarks == 'APPROVED')
                                    <span class="text-success">{{ $evaluation->remarks }}</span>
                                @else
                                    @if ($evaluation->checklist_print_path == null)
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addUploadModal" btnUplChecklist
                                            evaluationId="{{ $evaluation->id }}">Upload <i class="bi bi-upload"></i>
                                        </button>
                                    @else
                                        <a href="/download/evaluations/disapproval/_{{ $evaluation->id }}">Checklist <i
                                                class="bi bi-file-earmark-arrow-down-fill"></i></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal -->
            <div class="modal fade" id="addUploadModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" style="min-width:800px;">
                    <div class="modal-content px-5 py-4">
                        <div class="text-center py-5 d-none" spinner>
                            <div class="spinner-border" role="status" style="width: 3rem; height:3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="text-secondary mt-3 fs-5">
                                Uploading Files...
                            </div>
                        </div>

                        <div modal-content>
                            <div class="bg-secondary-subtle filelist-container" style="display: none;">
                                <div class="overflow-y-auto pb-0" style="height: 150px;">
                                    <ul class="list-unstyled filelist p-3 fw-bold text-center">
                                    </ul>
                                </div>
                            </div>

                            <form action="" id="uploadForm"
                                class="rounded-2 d-flex flex-column justify-content-center gap-3 mx-auto w-100"
                                method="POST" enctype="multipart/form-data" style="height: 250px;" autocomplete="off">
                                @csrf
                                <div class="h-100 d-flex flex-column gap-3 mt-2">
                                    <div class="h-100 position-relative">
                                        <div class="fileuploadicon d-flex flex-column text-center p-2 position-absolute h-100 w-100"
                                            style="pointer-events:none;">
                                            <div class="my-auto">
                                                <span class="material-symbols-outlined fs-2">description</span>
                                                <span class="material-symbols-outlined fs-2">image</span>
                                                <span class="material-symbols-outlined fs-2">folder</span>
                                            </div>
                                            <div class="my-auto">
                                                <span>Click or Drag To Upload File</span>
                                            </div>
                                        </div>

                                        <input type="hidden" id="evaluationId" name="evaluationId" value="">
                                        <input id="fileUpload" name="fileUpload[]" class="btn bg-secondary-subtle h-100"
                                            type="file" value="Add" accept=".pdf"
                                            style="width: 100%; opacity: 1%;" />
                                    </div>
                                </div>
                            </form>

                            <div class="modal-footer">
                                <button id="submitFile" class="btn btn-primary float-end d-none" type="button">Submit
                                    Files</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-pageWrapper>
    </div>
@endsection
@section('page-script')
    @vite('resources/js/pages/fsec/show.js')
    <script type="module">
        window.showLoading = () => {
            toggleShow('loading-bar-spinner')
            document.querySelector('#deleteModalContent').style.visibility = 'hidden';
        }
    </script>
@endsection
