{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.layout')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        
        {{-- Put page content here --}}
        <div class="w-75 h-75 overflow-y-auto mx-auto">
            <table class="table">
                    <thead class="sticky-top top bg-white z-0 border-5 border-dark-subtle">
                        <tr>
                            <th>FSEC NO.</th>
                            <th>Date</th>
                            <th>Establishment <span>(Building, Structure, Faculty)</span></th>
                            <th>Barangay</th>
                            <th>Substation</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
            </table>
        </div>

    </div>
@endsection