{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">

        {{-- Put page content here --}}

        <table class="table">
            <thead>
                <th class="p-3">Record no.</th>
                <th class="p-3">Establishment</th>
                <th class="p-3">Name</th>
            </thead>
            <tbody>
                @foreach ($establishments as $establishment)
                    <tr class="align-middle">
                        <td> {{ $establishment->id }} </td>
                        <td> {{ $establishment->establishment_name }} </td>
                        <td> {{ $establishment->owner->first_name }} {{ $establishment->owner->last_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
