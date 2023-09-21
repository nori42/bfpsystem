{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

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
                        <div class="bg-white rounded-circle p-3">
                            <img src="{{ asset('img/Firefighter.svg') }}" alt="fireman" height="150px" width="100%">
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

                    @if (auth()->user()->username != $personnel->user->username)
                        <button class="btn btn-danger px-5 mt-3" onclick="openModal('deleteModal')">
                            <i class="bi bi-trash3-fill"></i>
                            Delete</button>
                    @endif

                    <x-modal topLocation="15" width="50" id="deleteModal" leftLocation="30">
                        <x-spinner :hidden="true" />
                        <div class="text-start" id="deleteModalContent">
                            <div class="fs-5">Do you want to delete this personnel?</div>
                            <div class="fs-6 text-secondary">The associated account of this personnel will also be deleted.
                            </div>
                            <div class="fs-6 text-secondary">This action cannot be reverted.</div>
                            <div class="d-flex justify-content-end gap-2">
                                <form action="/personnel/{{ $personnel->id }}/delete" method="POST">
                                    @csrf
                                    <button class="btn btn-danger px-2" onclick="showLoading()">Yes</button>
                                </form>
                                <button class="btn btn-secondary px-4" onclick="closeModal('deleteModal')">No</button>
                            </div>
                        </div>
                    </x-modal>
                </div>
                <div>
                    <div class="bg-subtleBlue boxshadow p-3" style="width:35rem; height: 24rem;">
                        <div class="mb-3 fw-bold">Personnel Details</div>

                        {{-- <div class="row my-3">
                            <div class="col-4 text-secondary">ID Number</div>
                            <div class="col-8">{{ $personnel->user->username }}</div>
                        </div> --}}

                        <div class="row my-3">
                            <div class="col-4 text-secondary">Designation</div>
                            @if ($personnel->user->type == 'FSIC')
                                <div class="col-8">{{ 'Fire Safety Inspection Certificate (FSIC)' }}
                                </div>
                            @elseif($personnel->user->type == 'FSEC')
                                <div class="col-8">{{ 'Fire Safety Evaluatioin Certificate (FSEC)' }}
                                </div>
                            @elseif($personnel->user->type == 'FIREDRILL')
                                <div class="col-8">{{ $personnel->user->type }}
                                </div>
                            @else
                                <div class="col-8">{{ $personnel->user->type }}
                                </div>
                            @endif
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

                    </div>
                </div>
            </div>
        </x-pageWrapper>
    </div>
@endsection

@section('scripts')
    <script type="module">
        window.showLoading = () => {
            toggleShow('loading-bar-spinner')
            document.querySelector('#deleteModalContent').style.visibility = 'hidden';
        }
    </script>
@endsection
