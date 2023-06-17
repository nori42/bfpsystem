{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>

            @isset($toastMssg)
                <x-toast :message="$toastMssg" />
            @endisset
            @if (session('toastMssg') != null)
                <x-toast :message="session('toastMssg')" />
            @endif
            <div class="d-flex justify-content-between my-5 align-items-center">
                <div>
                    <span class="d-block fw-bold fs-3">{{ count($users) }} Users</span>
                    <span class="d-block text-secondary ">Manage users</span>
                </div>
                <button class="btn btn-success" onclick="openModal('addUser')">
                    <span class="material-symbols-outlined fs-2 align-middle">
                        person_add
                    </span>
                    Add User
                </button>
            </div>
            <table class="table">
                <thead>
                    <th>Username</th>
                    <th>User Type</th>
                    <th>Name</th>
                    <th>Request Reset</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $personnel = null;
                            if ($user->personnel_id != 0) {
                                $person = $user->personnel->person;
                                $personnel = $user->personnel_id != 0 ? $person->first_name . ' ' . $person->middle_name[0] . '. ' . $person->last_name . ' ' . $person->suffix : '';
                            }
                        @endphp
                        <tr>
                            <td style="width:21rem">{{ $user->username }}</td>
                            <td style="width:21rem">{{ $user->type }}</td>
                            <td style="width:21rem">{{ strtoupper($user->name) }}</td>
                            {{-- <td><a href="/users/{{ $user->id }}" class="btn btn-success"><i
                                        class="bi bi-person fs-5 mx-1"></i>Account</a></td> --}}
                            <td>
                                @if ($user->request_password_reset)
                                    <form action="/request/passwordreset" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="userId" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-link">Reset Password</button>
                                    </form>
                                @endif

                                @isset($newpassword)
                                    @if ($user->id == $newpassword['id'])
                                        <span class="fw-bold">Password: </span>{{ $newpassword['password'] }}
                                    @endif
                                @endisset
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-pageWrapper>

        <x-modal id="addUser" width="50" topLocation="8">

            <form action="/users" method="POST" autocomplete="off">
                @csrf

                <legend class="mb-3">Add New User</legend>

                <x-form.select name="type" label="Type" placeholder="SELECT TYPE">
                    <option value="FSIC">FIRE SAFETY INSPECTION(FSIC)</option>
                    <option value="FSEC">FIRE SAFETY EVALUATION(FSEC)</option>
                    <option value="FIREDRILL">FIREDRILL</option>
                </x-form.select>

                <div class="d-flex gap-3">
                    {{-- <x-form.input label="Username" name="username" :required="true" /> --}}
                    <x-form.inputWrapper>
                        <label class="info-label">Username</label>
                        <input class="form-control" id="username" name="username" type="text" required
                            autocomplete="off">
                    </x-form.inputWrapper>
                    <x-form.inputWrapper>
                        <label id="labelPassword" class="info-label">Password <span class="fw-normal">Click here to generate
                                new</span></label>
                        <input class="form-control" id="password" name="password" type="text" required readonly
                            autocomplete="off">
                    </x-form.inputWrapper>
                    {{-- <x-form.inputWrapper>
                        <label class="info-label">Confirm Password</label>
                        <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" required
                            autocomplete="off">
                    </x-form.inputWrapper> --}}
                </div>

                <label class="info-label">Name</label>
                <input class="form-control text-uppercase" id="name" name="name" type="text" required
                    autocomplete="off">

                {{-- <x-form.select name="personnelId" label="Personnel" placeholder="Assign user to personnel"
                    customAttr="required">
                    @foreach ($personnelList as $personnel)
                        @php
                            $name = $personnel->person->last_name . ' ' . $personnel->person->suffix . ', ' . $personnel->person->first_name . ' ' . $personnel->person->middle_name[0] . '.';
                        @endphp
                        <option value="{{ $personnel->id }}">{{ $name }}</option>
                    @endforeach
                </x-form.select> --}}

                <div class="d-flex align-items-stretch gap-2 justify-content-end mt-3">
                    <button class="btn btn-success" type="submit">
                        <i class="bi bi-person-add fs-4"></i> Add
                    </button>

                </div>
            </form>
        </x-modal>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        passwordInput.value = generatePassword();

        document.querySelector("#labelPassword").addEventListener('click', () => passwordInput.value = generatePassword())

        function generatePassword() {
            const chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const passwordLength = 8;
            let password = "";

            for (let i = 0; i <= passwordLength; i++) {
                var randomNumber = Math.floor(Math.random() * chars.length);
                password += chars.substring(randomNumber, randomNumber + 1);
            }

            return password;
        }
    </script>
@endsection
