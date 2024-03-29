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

                <div class="d-flex justify-content-between my-5 align-items-center">
                    <div>
                        <span class="d-block fw-bold fs-3">{{ count($users) - 1 }} Users</span>
                        <span class="d-block text-secondary ">Manage users</span>
                    </div>
                    <div>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#activeUsers">
                            <i class="bi bi-person-workspace fs-4"></i>
                            View Active
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
                            <i class="bi bi-person-fill-add fs-4"></i>
                            Add User
                        </button>
                    </div>
                </div>
                <table class="table w-100">
                    <thead>
                        <th>Personnel</th>
                        <th>User Type</th>
                        <th>Reset Password</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if ($user->id == 1)
                                @continue
                            @endif
                            <tr class="align-middle" style="height:3.5rem;">
                                @if ($user->personnel != null)
                                    <td style="width:21rem">
                                        <a href="/personnel/{{ $user->personnel_id }}">{{ $user->personnel->first_name }}
                                            {{ $user->personnel->last_name }}</a>
                                    </td>
                                @else
                                    <td style="width:21rem;">N/A</td>
                                @endif
                                <td style="width:21rem">{{ $user->type }}</td>
                                <td>
                                    @if ($user->request_password_reset)
                                        <form action="/request/passwordreset" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="userId" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-link">Reset Password</button>
                                        </form>
                                    @endif
                                    @if ($user->reset_password)
                                        <span class="fw-bold">Password: </span>{{ $user->reset_password }}
                                    @endisset
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-pageWrapper>

        <div class="modal fade" id="addUser" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content py-4 px-5" style="min-width:820px;">
                    <form action="/users" method="POST" autocomplete="off">
                        @csrf
                        <legend class="mb-3">Add New User</legend>
                        <div>
                            <label class="fw-bold" for="type">Type</label>
                            <div class="my-2">
                                <input type="radio" name="type" id="admin" value="ADMINISTRATOR">
                                <label for="admin">ADMINISTRATOR</label>
                                <br>
                                <input type="radio" name="type" id="fsic" value="FSIC">
                                <label for="fsic">FIRE SAFETY INSPECTION CERTIFICATE (FSIC)</label>
                                <br>
                                <input type="radio" name="type" id="fsec" value="FSEC">
                                <label for="fsec">FIRE SAFETY EVALUATION CERTIFICATE (FSEC)</label>
                                <br>
                                <input type="radio" name="type" id="firedill" value="FIREDRILL">
                                <label for="firedill">FIREDRILL</label>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            {{-- <x-form.input label="Username" name="username" :required="true" /> --}}
                            <x-form.inputWrapper>
                                <label class="fw-bold">Username</label>
                                <input class="form-control" id="username" name="username" type="text" required
                                    autocomplete="off">
                            </x-form.inputWrapper>
                            <x-form.inputWrapper>
                                <label id="labelPassword" class="fw-bold">Password <span class="fw-normal">Click
                                        here to
                                        generate
                                        new</span></label>
                                <input class="form-control" id="password" name="password" type="text" required
                                    readonly autocomplete="off">
                            </x-form.inputWrapper>
                        </div>

                        <div class="d-flex align-items-stretch gap-2 justify-content-end mt-3">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-person-add fs-4"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="activeUsers" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content py-4 px-5" style="min-width:780px;">
                    <div class="py-2">
                        <div class="fs-3">{{ count($loggedInUsers) }} Active User</div>
                        <div class="text-secondary">List of active users</div>
                    </div>
                    <table class="table mt-2">
                        <thead>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Type</th>
                        </thead>
                        <tbody>
                            @foreach ($loggedInUsers as $user)
                                @if ($user->username != 'adminDev')
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        @if ($user->personnel)
                                            <td>{{ $user->personnel->first_name . ' ' . $user->personnel->last_name }}
                                            </td>
                                        @endif
                                        <td>{{ $user->type }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
