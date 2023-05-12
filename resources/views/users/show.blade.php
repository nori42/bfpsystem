{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <div class="fs-3 fw-bold">Account</div>
            <div class="text-secondary">Manage Account</div>
            <div class="d-flex flex-column gap-3 mt-3">
                <div>
                    <x-account.btnEdit label="Username" value="{{ auth()->user()->username }}" menuId="usernameEdit" />

                    <div id="usernameEdit" class="fs-6 px-5 py-3 bg-subtleBlue" style="display: none !important;">
                        <div class="fw-bold my-3">Username</div>
                        <div>
                            <form action="">
                                <div class="d-flex w-35">
                                    <label class="text-secondary fw-bold w-100 text-end">Username</label>
                                    <input class="mx-2 w-100" name="username" type="text"
                                        value="{{ auth()->user()->username }}" autocomplete="off">
                                </div>
                                <button class="btn btn-success my-3">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div>
                    <x-account.btnEdit label="Password" value="Change Password" menuId="passwordEdit" />

                    <div id="passwordEdit" class="fs-6 px-5 py-3 bg-subtleBlue" style="display: none !important;">
                        <div class="fw-bold my-3">Password</div>
                        <div>
                            <form action="">
                                <div class="d-flex w-35">
                                    <label class="text-secondary fw-bold w-100 text-end">Current</label>
                                    <input class="w-100 mx-2" name="passwordCurrent" type="password">
                                </div>
                                <div class="d-flex w-35 my-2">
                                    <label class="text-secondary fw-bold w-100 text-end">New Password</label>
                                    <input class="w-100 mx-2" name="passwordNew" type="password">
                                </div>

                                <div class="d-flex w-35">
                                    <label class="text-secondary fw-bold w-100 text-end">Confirm New Passowrd</label>
                                    <input class="w-100 mx-2" name="passwordConfirmNew" type="password">
                                </div>

                                <button class="btn btn-success my-3">Save Changes</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </x-pageWrapper>
    </div>
@endsection
