{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}

        {{-- Update Message --}}
        @isset($toastMssg)
            <x-toast :message="$toastMssg" />
        @endisset
        @if (session('toastMssg'))
            <x-toast :message="session('toastMssg')" />
        @endif


        <x-pageWrapper>
            <div class="d-flex justify-content-between">
                <div>
                    <div class="fs-3 fw-bold">Account</div>
                    <div class="text-secondary">Manage Account</div>
                </div>
                {{-- <div class="align-self-center">
                    <button class="btn btn-danger"><i class="bi bi-trash3"></i>Deactivate</button>
                </div> --}}
            </div>
            <div class="d-flex flex-column gap-3 mt-3">
                {{-- Username --}}
                {{-- <div>
                    <x-account.btnEdit label="Username" value="{{ $user->username }}" menuId="usernameEdit" />

                    <div id="usernameEdit" class="fs-6 px-5 py-3 bg-subtleBlue" style="display: none !important;">
                        <div class="fw-bold my-3">Username</div>
                        <div>
                            <form action="/users/{{ $user->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="d-flex w-35">
                                    <label class="text-secondary fw-bold w-100 text-end">Username</label>
                                    <input class="mx-2 w-100" name="username" type="text" value="{{ $user->username }}"
                                        autocomplete="off">
                                </div>
                                <button class="btn btn-primary my-3" name="action" value="updateUsername">Save
                                    Changes</button>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <div>
                    {{-- <x-account.btnEdit label="Password" value="Change Password" menuId="passwordEdit" /> --}}
                    <button class="btn btn-subtleBlue w-100 fs-5 px-5 py-3" btnPassword>
                        <span class="float-start">
                            <span class="fw-bold">Password</span>
                            <span class="fw-normal mx-5">Change Password</span>
                        </span>
                        <span class="float-end edit-text"> <i class="bi bi-pencil edit-icon"></i> Edit </span>
                    </button>

                    <div id="passwordEdit"
                        class="fs-6 px-5 py-3 bg-subtleBlue {{ $errors->any() || session('pass_incorrect') ? '' : 'd-none' }} "
                        btnPassword-menu>
                        <div class="fw-bold my-3">Password</div>
                        <div>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="fs-6 text-danger my-2">{{ $error }}</div>
                                @endforeach
                            @endif

                            @if (session('pass_incorrect'))
                                <div class="fs-6 text-danger my-2">Enter the correct password and try again</ $div>
                            @endif
                            <form action="/users/{{ $user->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="d-flex w-35 align-items-center">
                                    <label class="text-secondary fw-bold w-100 text-end">Current</label>
                                    <input class="mx-2" name="passwordCurrent" type="password" autocomplete="off"
                                        required>
                                </div>
                                <div class="d-flex w-35 my-2 align-items-center">
                                    <label class="text-secondary fw-bold w-100 text-end">New Password</label>
                                    <input class=" mx-2" id="passwordNew" name="passwordNew" type="password" required
                                        autocomplete="off">
                                </div>

                                <div class="d-flex w-35 align-items-center">
                                    <label class="text-secondary fw-bold w-100 text-end">Confirm New Password</label>
                                    <input class="mx-2" id="passwordConfirmNew" name="passwordConfirmNew" type="password"
                                        required autocomplete="off">
                                </div>

                                <button class="btn btn-primary my-3" name="action" value="updatePassword">Save
                                    Changes</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            @php
                $personnel = $user->personnel;
            @endphp

            <div class="fs-3 fw-bold mt-3">Personnel Details</div>

            {{-- <h1 class="fs-3 fw-bold">Personnel</h1> --}}
            <div class="d-flex gap-4 justify-content-center mt-3">
                <div class="text-center">
                    <div class="bg-subtleBlue d-flex flex-column align-items-center p-3 boxshadow"
                        style="width:25rem; height: 21rem;">

                        <form class="d-flex flex-column align-items-center gap-2" enctype="multipart/form-data"
                            action="/users/{{ $user->id }}/changeprofile" autocomplete="off" method="POST">
                            @csrf
                            @method('POST')
                            <div class="position-relative" style="height: 13rem; width: 13rem;" id="profile">
                                <img class="bg-white rounded-circle" id="profilePic"
                                    src="{{ $user->personnel->profile_pic_path ? asset($personnel->profile_pic_path) : asset('img/Firefighter.svg') }}"
                                    alt="fireman" height="100%" width="100%">
                                <div class="position-absolute d-none" style="top:50%; left: 50%; translate: -50% -50%;"
                                    id="btnChangeProfile">
                                    <div class="btn btn-dark p-0 position-relative" style="width: 10rem">
                                        <input type="file" style="height: 100%; width: 100%; opacity: 0;"
                                            name="profilePicInp" id="profilePicInp">
                                        <div class="position-absolute text-nowrap"
                                            style="pointer-events: none; top: 50%; left:50%; translate: -50% -50%;">Change
                                            Picture</div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary d-none" id="btnUpdate">Update Profile</button>
                        </form>

                        @if ($personnel->middle_name != null || $personnel->middle_name == '')
                            <div class="fw-bold mt-4 fs-5">
                                {{ $personnel->first_name . ' ' . $personnel->middle_name . ' ' . $personnel->last_name }}
                            </div>
                        @else
                            <div class="fw-bold mt-4">{{ $personnel->first_name . ' ' . $personnel->last_name }}
                            </div>
                        @endif

                    </div>
                    <a class="btn btn-primary mt-4 px-5" href="/personnel/{{ $personnel->id }}/edit">Edit Info</a>

                </div>
                <div>
                    <div class="bg-subtleBlue boxshadow p-3" style="width:35rem; height: 24rem;">
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

@section('page-script')
    @vite('resources/js/pages/users/show.js')
@endsection
