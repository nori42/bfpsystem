{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <div class="d-flex justify-content-end mt-5" onclick="openModal('addUser')">
                <button class="btn btn-success" onclick="">Add New User</button>
            </div>
            <table class="table">
                <thead>
                    <th>Username</th>
                    <th>User Type</th>
                    <th>Personnel</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </x-pageWrapper>

        <x-modal id="addUser" width="50" topLocation="8">

            <form action="/users" method="POST">
                @csrf
                <div class="d-flex gap-3">
                    <x-form.input label="Username" name="username" />
                    <x-form.input label="Password" name="password" />
                    <x-form.input label="Confirm Password" name="confirmPassword" />
                </div>
                <x-form.input label="Type" name="suffix" />
                <x-form.input label="Personnel" name="personnel" />

                <button class="btn btn-success w-25 ml-auto mt-3" type="submit">Add</button>
            </form>
        </x-modal>
    </div>
@endsection
