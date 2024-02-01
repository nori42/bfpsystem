<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/bootstrap.scss', 'resources/css/pages/personnelcreate.css'])

</head>

<body class="overflow-auto bg-primary-nb" style="height: 1000px;">
    <div>
        <div class="d-flex justify-content-center">
            <img class="mt-3 mx-auto" src="/img/LOGO.png" alt="BFP LOGO" height="150" width="150">
        </div>
        <div class="text-center text-white fs-5">Bureau of Fire Protection <br> Cebu City Fire Station</div>
    </div>
    <div class="vw-100 align-items-center d-flex justify-content-center create" style="margin-top:1rem !important;">
        <form class="form-wrapper p-5 d-flex overflow-x-auto create rounded-4" action="/personnel" method="POST"
            style="background-color: #eef3fc;">
            <div style="min-width: 570px;">
                <h3 class="fw-semibold">Personnel Info</h3>
                <div class="text-secondary text-start mb-2">
                    Fill in the required fields.
                </div>
                @csrf
                <div class="d-flex gap-2">
                    <x-form.input type="text" label="First Name" name="firstName" :required="true"
                        value="{{ old('firstName') ? old('firstName') : '' }}" />
                    <x-form.input type="text" label="Middle Name" name="middleName"
                        value="{{ old('middleName') ? old('middleName') : '' }}" />
                    <x-form.input type="text" label="Last Name" name="lastName" :required="true"
                        value="{{ old('lastName') ? old('lastName') : '' }}" />
                </div>
                <x-form.input class="w-25" type="text" label="Name Suffix" name="nameSuffix"
                    value="{{ old('nameSuffix') ? old('nameSuffix') : '' }}" />
                <div class="my-4">
                    <div class="my-2">Sex <span class="text-danger">*</span></div>
                    <span style="margin-right: 1rem;">
                        <label for="male">MALE</label>
                        <input class="ml-5" type="radio" name="sex" id="male" value="MALE"
                            {{ old('sex') == 'MALE' ? 'checked' : '' }}>
                    </span>
                    <label for="female">FEMALE</label>
                    <input type="radio" name="sex" id="female" value="FEMALE"
                        {{ old('sex') == 'MALE' ? 'checked' : '' }}>
                </div>

                <x-form.input class="w-50" type="date" label="Date of Birth" name="dateOfBirth" :required="true"
                    value="{{ old('dateOfBirth') ? old('dateOfBirth') : '' }}" />
                <x-form.input class="w-50" type="text" label="Contact No." name="contactNo"
                    value="{{ old('contactNo') ? old('contactNo') : '' }}" />
                <x-form.input type="text" label="Address" name="address"
                    value="{{ old('address') ? old('address') : '' }}" />
                <x-form.select class="w-50" name="rank" label="Rank" placeholder="SELECT RANK">
                    @php
                        $ranks = ['CINSP', 'INSP', 'SFO4', 'SFO3', 'SFO1', 'FO3', 'FO2', 'FO1', 'NUP'];
                    @endphp

                    @foreach ($ranks as $rank)
                        <option value="{{ $rank }}" {{ old('rank') == $rank ? 'selected' : '' }}>
                            {{ $rank }}
                        </option>
                    @endforeach
                </x-form.select>
            </div>
            <div class="align-self-stretch mx-5" style="border-right: 1px solid #8d8d8d;">
            </div>
            <div style="min-width: 500px;">
                <div>
                    <div class="w-60 mb-3">
                        <h3 class="fw-semibold text-start">Create New Password</h3>
                        <div class="text-secondary text-start">
                            New user is required to change the password.
                        </div>
                    </div>
                    <div>
                        <label class="fs-5 fw-normal">Password</label>
                        <input id="password" class="form-control d-block fs-6 w-100" type="password" name="password"
                            required>
                    </div>

                    <div>
                        <label class="fs-5 fw-normal">Confirm Password</label>
                        <input class="form-control d-block fs-6 w-100" id="confirmPassword" name="confirmPassword"
                            type="password" required autocomplete="off">
                    </div>

                    <div class="text-secondary mt-3">

                        @if ($errors->has('password'))
                            @foreach ($errors->get('password') as $error)
                                @if ($error === 'The password field must be at least 8 characters.')
                                    <span class="text-danger">{{ $error }}</span><br>
                                @elseif ($error === 'The password field must contain at least one uppercase and one lowercase letter.')
                                    <span class="text-danger">{{ $error }}</span><br>
                                @elseif ($error === 'The password field must contain at least one number.')
                                    <span class="text-danger">{{ $error }}</span><br>
                                @else
                                    <span>{{ $error }}</span><br>
                                @endif
                            @endforeach
                        @else
                            <span>The password field must be at least 8 characters.</span><br>
                            <span>The password field must contain at least one uppercase and one lowercase
                                letter.</span><br>
                            <span>The password field must contain at least one number.</span>
                        @endif
                    </div>
                    <div style="margin-top: 12rem;">
                        <button class="btn btn-primary mt-4 px-5 w-35 float-end">Save</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</body>

</html>
