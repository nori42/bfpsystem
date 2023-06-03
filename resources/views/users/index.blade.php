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
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->type }}</td>
                            <td>{{ strtoupper($user->name) }}</td>
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
                        <label class="info-label">Password</label>
                        <input class="form-control" id="password" name="password" type="password" required
                            autocomplete="off">
                    </x-form.inputWrapper>
                    <x-form.inputWrapper>
                        <label class="info-label">Confirm Password</label>
                        <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" required
                            autocomplete="off">
                    </x-form.inputWrapper>
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

                <button class="btn btn-success mt-3 float-end" type="submit">
                    <span class="material-symbols-outlined fs-2 align-middle">
                        person_add
                    </span>
                    Add
                </button>
            </form>
        </x-modal>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');

        confirmPasswordInput.addEventListener('input', () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Passwords do not match');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });
    </script>
@endsection
