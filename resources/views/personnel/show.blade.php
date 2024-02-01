{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

@php
    //UserType
    $type = $personnel->user->type;
@endphp

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            @if (session('toastMssg') != null)
                <x-toast :message="session('toastMssg')" />
            @endif

            <h1 class="fs-3 fw-bold">Personnel</h1>
            <div class="d-flex gap-4 justify-content-center">
                <div class="text-center">
                    <div class="bg-subtleBlue d-flex flex-column align-items-center p-3 boxshadow"
                        style="width:25rem; height: 19rem;">
                        <div class="align-self-center" style="height: 13rem; width: 13rem;" id="profile">
                            <img class="bg-white rounded-circle" height="100%" width="100%"
                                src="{{ $personnel->profile_pic_path ? asset($personnel->profile_pic_path) : asset('img/FireFighter.svg') }}"
                                alt="fireman" height="125px">
                        </div>
                        @if ($personnel->middle_name != null || $personnel->middle_name == '')
                            <div class="fw-bold mt-4 fs-5">
                                {{ $personnel->first_name . ' ' . $personnel->middle_name . ' ' . $personnel->last_name }}
                            </div>
                        @else
                            <div class="fw-bold mt-4">{{ $personnel->first_name . ' ' . $personnel->last_name }}
                            </div>
                        @endif
                    </div>
                    {{-- <a class="btn btn-success mt-4 px-5" href="/personnel/{{ $personnel->id }}/edit">Edit Personnel</a> --}}
                    <div class="d-flex flex-column justify-content-center gap-2 mx-auto w-50 mt-3">

                        @if (auth()->user()->username != $personnel->user->username)
                            <button class="btn btn-danger px-5 mt-3 text-nowrap" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="bi bi-person-dash align-middle mr-2" style="font-size: 1.5rem"></i>
                                Deactivate
                            </button>

                            <div class="modal" id="deleteModal">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content px-5 py-4">
                                        <x-spinner :hidden="true" />
                                        <div class="text-start" id="deleteModalContent">
                                            <div class="fs-5">Do you want to deactivate this personnel?</div>
                                            <div class="fs-6 text-secondary">This action cannot be reverted.</div>
                                            <div class="d-flex justify-content-end gap-2 mt-3">
                                                <button class="btn btn-secondary px-4"
                                                    data-bs-dismiss="modal">Cancel</button>

                                                <form action="/personnel/{{ $personnel->id }}/delete" method="POST">
                                                    @csrf
                                                    <button class="btn btn-danger px-2"
                                                        onclick="showLoading()">Deactivate</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- 
                        @if (auth()->user()->id == $personnel->user->id)
                            <a class="btn btn-primary px-5" href="/personnel/{{ $personnel->id }}/edit"> <i
                                    class="bi bi-pencil-fill"></i> Edit Info</a>
                        @endif --}}

                        @if ($personnel->user->type != 'ADMINISTRATOR')
                            <button class="btn btn-primary" id="btnChangeDesig">Change Designation</button>
                        @endif
                    </div>


                    {{-- <x-modal topLocation="15" width="50" id="deleteModal" leftLocation="30">
                    </x-modal> --}}
                </div>
                <div>
                    <div class="bg-subtleBlue boxshadow p-3" style="width:35rem; height: 26rem;">
                        <div class="mb-3 fw-bold">Personnel Details</div>

                        <div class="row my-3">
                            <div class="col-4 text-secondary text-nowrap">ID Number/Username</div>
                            <div class="col-8">{{ $personnel->user->username }}</div>
                        </div>

                        <div class="row my-3">
                            <div class="col-4 text-secondary">Designation</div>

                            @if ($personnel->user->type == 'FSIC')
                                <div class="col-8" textDesig>{{ 'Fire Safety Inspection Certificate (FSIC)' }}
                                </div>
                            @elseif($personnel->user->type == 'FSEC')
                                <div class="col-8" textDesig>{{ 'Fire Safety Evaluatioin Certificate (FSEC)' }}
                                </div>
                            @elseif($personnel->user->type == 'FIREDRILL')
                                <div class="col-8" textDesig>{{ $personnel->user->type }}
                                </div>
                            @else
                                <div class="col-8" textDesig>{{ $personnel->user->type }}
                                </div>
                            @endif

                            <form class="col-8 d-none" id="designationForm"
                                action="/users/{{ $personnel->user_id }}/updatedesignation" method="post"
                                autocomplete="off">
                                @csrf
                                @method('put')
                                <select name="designation" id="designation" class="form-select">
                                    <option value="FSIC" {{ $type == 'FSIC' ? 'selected' : '' }}>FSIC</option>
                                    <option value="FSEC" {{ $type == 'FSEC' ? 'selected' : '' }}>FSEC</option>
                                    <option value="FIREDRILL" {{ $type == 'FIREDRILL' ? 'selected' : '' }}>FIREDRILL
                                    </option>
                                    <option value="ADMINISTRATOR" {{ $type == 'ADMINISTRATOR' ? 'selected' : '' }}>
                                        ADMINISTRATOR</option>
                                </select>
                            </form>
                        </div>

                        <div class="row my-3">
                            <div class="col-4 text-secondary">Rank</div>
                            <div class="col-8">{{ $personnel->rank }}</div>
                        </div>

                        <div class="row my-3">
                            <div class="col-4 text-secondary">Contact No.</div>
                            <div class="col-8">{{ $personnel->contact_no }}</div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4 text-secondary">Date of Birth</div>
                            <div class="col-8">{{ $personnel->date_of_birth }}</div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4 text-secondary">Sex</div>
                            <div class="col-8">{{ $personnel->sex }}</div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4 text-secondary">Address</div>
                            <div class="col-8">{{ $personnel->address }}</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 d-none" id="btnDesigConfirm">
                            <button class="btn btn-outline-secondary" id="btnCancelDesig" type="button">Cancel</button>
                            <button class="btn btn-success" id="btnUpdateDesig">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    @vite('resources/js/pages/personnel/show.js');
@endsection

@section('scripts')
    <script type="module">
        window.showLoading = () => {
            toggleShow('loading-bar-spinner')
            document.querySelector('#deleteModalContent').style.visibility = 'hidden';
        }
    </script>
@endsection
