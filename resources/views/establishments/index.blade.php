@extends('layouts.layout')


@section('content')
<div class="page-content h-100">
    <!-- heading -->
    <div class="d-flex align-items-center justify-content-between w-75 mx-auto mt-5">
        <h1>Records</h1>
        <a class="btn btn-success" href="/establishments/create">New Record</a>
    </div>
<div class="w-75 h-75 overflow-y-scroll mx-auto">
    @if (session('mssg'))
        <h2 class="text-success">{{session('mssg')}}</h2>
    @endif
    <table class="table mt-5">
            <thead class="sticky-top top bg-info text-white">
                <tr>
                    <th>Record no.</th>
                    <th>Establishment</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Barangay</th>
                    <th>Substation</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- output each record -->
                @foreach ($establishments as $establishment)
                    @if ($loop->index == 0 && session('newPost'))
                    {{-- green bg for new record --}}
                    <tr class="bg-success text-white">
                        <td> {{ $establishment->record_no }} </td>
                        <td> {{ $establishment->establishment_name }} </td>
                        <td>    {{$establishment->last_name}} </td>
                        <td>    {{$establishment->first_name}}  </td>
                        <td> {{ $establishment->barangay }} </td>
                        <td> {{ $establishment->substation }} </td>
                        <td> {{ $establishment->status }} </td>
                        <td><a href="/establishments/{{$establishment->record_no}}"class="btn btn-primary">Details</a></td>
                    </tr>
                    @else
                    <tr>
                        <td> {{ $establishment->record_no }} </td>
                        <td> {{ $establishment->establishment_name }} </td>
                        <td>    {{$establishment->last_name}} </td>
                        <td>    {{$establishment->first_name}}  </td>
                        <td> {{ $establishment->barangay }} </td>
                        <td> {{ $establishment->substation }} </td>
                        <td> {{ $establishment->status }} </td>
                        <td><a href="/establishments/{{$establishment->record_no}}" class="btn btn-primary">Details</a></td>
                    </tr>
                    @endif   
                @endforeach
            </tbody>
            </div>
    </table>
</div>
@endsection