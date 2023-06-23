{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <div>
                <span class="d-block fw-bold fs-3">Activity log</span>
            </div>
            <table class="table mt-4">
                <thead>
                    <th>User Type</th>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Date and Time</th>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                        <tr>
                            <td>{{ $activity->type }}</td>
                            <td>{{ strtoupper($activity->name) }}</td>
                            <td>{{ $activity->activity }}</td>
                            <td>{{ date('m/d/Y g:i:s A', strtotime($activity->created_at)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-pageWrapper>
    </div>
@endsection
