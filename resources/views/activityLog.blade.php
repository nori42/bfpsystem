{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <h1>Activity log</h1>
            <table class="table mt-4">
                <thead>
                    <th style="width: 48rem;">Activity</th>
                    <th>Name</th>
                    <th>Date and Time</th>
                </thead>
                <tbody>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                </tbody>
            </table>
        </x-pageWrapper>
    </div>
@endsection
