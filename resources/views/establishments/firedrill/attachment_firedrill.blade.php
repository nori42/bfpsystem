@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-attachment for='firedrill' :establishment="$establishment" :owner="$owner" :files="$files" page="Firedrill" />
    </div>
@endsection
