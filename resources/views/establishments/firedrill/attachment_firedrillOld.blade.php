@extends('layouts.app')


@section('stylesheet')
    @vite(['resources/css/components/headingInfo.css', 'resources/css/pages/attachments.css'])
@endsection

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-attachment for='firedrill' :representative="$representative" :establishment="$establishment" :owner="$owner" :files="$files"
            page="Firedrill" />
    </div>
@endsection

@section('page-script')
    @yield('component-scripts')
@endsection
