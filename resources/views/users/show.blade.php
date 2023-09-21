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
                    <x-account.btnEdit label="Password" value="Change Password" menuId="passwordEdit" />

                    <div id="passwordEdit" class="fs-6 px-5 py-3 bg-subtleBlue" style="display: none !important;">
                        <div class="fw-bold my-3">Password</div>
                        <div>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="fs-6 text-danger my-2">{{ $error }}</div>
                                @endforeach
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

        <x-modal id="resetConfirm" width="40" topLocation="8" leftLocation="35">
            <div class="fs-5 fw-bold text-center">Are you sure you want to initiate a password reset for this account?</div>
            <div class="text-center">The new password for this account: <span class="fw-bold">cebucityfirestation</span>
            </div>
            <div class="d-flex justify-content-center py-4 gap-4 mt-3">
                <button class="btn btn-secondary px-4" onclick="closeModal('resetConfirm')">No, I change my mind</button>
                <button class="btn btn-danger px-4">Yes</button>
            </div>
        </x-modal>

    </div>
    <script>
        const passwordInput = document.getElementById('passwordNew');
        const confirmPasswordInput = document.getElementById('passwordConfirmNew');

        confirmPasswordInput.addEventListener('input', () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Passwords do not match');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });
    </script>
@endsection
