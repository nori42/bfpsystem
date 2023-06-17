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
                <div class="align-self-center">
                    <button class="btn btn-danger"><i class="bi bi-trash3"></i>Deactivate</button>
                </div>
            </div>
            <div class="d-flex flex-column gap-3 mt-3">
                <div>
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
                                <button class="btn btn-success my-3" name="action" value="updateUsername">Save
                                    Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
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
                                <div class="d-flex w-35">
                                    <label class="text-secondary fw-bold w-100 text-end">Current</label>
                                    <input class="w-100 mx-2" name="passwordCurrent" type="password" autocomplete="off"
                                        required>
                                </div>
                                <div class="d-flex w-35 my-2">
                                    <label class="text-secondary fw-bold w-100 text-end">New Password</label>
                                    <input class="w-100 mx-2" id="passwordNew" name="passwordNew" type="password" required
                                        autocomplete="off">
                                </div>

                                <div class="d-flex w-35">
                                    <label class="text-secondary fw-bold w-100 text-end">Confirm New Passowrd</label>
                                    <input class="w-100 mx-2" id="passwordConfirmNew" name="passwordConfirmNew"
                                        type="password" required autocomplete="off">
                                </div>

                                <button class="btn btn-success my-3" name="action" value="updatePassword">Save
                                    Changes</button>
                            </form>
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
