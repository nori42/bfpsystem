@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-attachment for='fsic' :establishment="$establishment" :owner="$owner" :files="$files" page="Inspection" />
    </div>
@endsection