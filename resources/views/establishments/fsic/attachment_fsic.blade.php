@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('stylesheet')
    @vite(['resources/css/components/headingInfo.css'])
@endsection

@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-attachment for='fsic' :representative="$representative" :establishment="$establishment" :owner="$owner" :files="$files"
            page="Inspection" />
    </div>
@endsection

@section('page-script')
    @yield('component-scripts')
@endsection
