{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <div class="d-flex justify-content-end mt-5 ">
                <button class="btn btn-success">Add New User</button>
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
    </div>
@endsection
