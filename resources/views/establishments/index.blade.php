@extends('layouts.layout')


@section('content')
<div class="page-content">
    {{-- search and add --}}
    <div class="d-flex align-items-center justify-content-between w-90 mx-auto my-3 mt-5 pr-2">
        <form action="" class="py-2 px-3 mb-0" style="background-color: #E6E6E6;">
            <label for="search">Search</label>
            <input type="text" name="search" id="search">

            {{-- margin --}}
            <span class="mx-2"></span>

            <label for="searchFilter">By:</label>
            <select name="searchFilter" id="searchFilter">
                <option value="recordNo">Record No.</option>
                <option value="establishment">Establishment</option>
                <option value="establishment">Substation</option>
                <option value="establishment">Barangay</option>
                <option value="establishment">Last Name</option>
            </select>
        </form>
        <a class="btn text-white px-5 py-2 align-middle" href="/establishments/create" style="background-color: #74B976;"><span class="material-symbols-outlined align-middle">domain_add</span> New Establishment</a>
    </div>

<div class="w-90 overflow-auto mx-auto px-2" style="height: 600px;">
    @if (session('mssg'))
        <h5 class="text-success w-90">{{session('mssg')}}</h5>
    @endif
    <table class="table h-50" id="table-estab">
            <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                <tr style="background-color: #1c3b64; color: white;">
                    <th>Record no.</th>
                    <th>Establishment</th>
                    <th>Name</th>
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
                    <tr class="bg-success text-white align-middle">
                        <td> {{ $establishment->id }} </td>
                        <td> {{ $establishment->establishment_name }} </td>
                        <td> {{$establishment->owner->first_name}} {{$establishment->owner->last_name}}</td>
                        <td> {{ $establishment->barangay }} </td>
                        <td> {{ $establishment->substation }} </td>
                        <td> {{ $establishment->status }} </td>
                        <td class="px-4"><a href="/establishments/{{$establishment->id}}"class="btn pl-5" style="background-color: #53A3D8;"><span class="material-symbols-outlined align-middle">wysiwyg</span>Details</a></td>
                    </tr>
                    @else
                    <tr class="align-middle">
                        <td> {{ $establishment->id}} </td>
                        <td> {{ $establishment->establishment_name }} </td>
                        <td> {{$establishment->owner->first_name}} {{$establishment->owner->last_name}}</td>
                        <td> {{ $establishment->barangay }} </td>
                        <td> {{ $establishment->substation }} </td>
                        <td> {{ $establishment->status }} </td>
                        <td class="px-4"><a href="/establishments/{{$establishment->id}}" class="btn text-white" style="background-color: #53A3D8;"><span class="material-symbols-outlined align-middle">wysiwyg</span>Details</a></td>
                    </tr>
                    @endif   
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>
@endsection