{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            <div class="d-flex align-items-center gap-4">
                <div>
                    <span class="d-block fw-bold fs-3">Activity log</span>
                    <span class="text-secondary">List of all user's activity</span>
                </div>
                <form action="/activity" class="d-flex align-items-center gap-2" method="GET">
                    @csrf
                    <input class="form-control" type="date" name="activtyDate" style="width:18rem;"
                        value="{{ $dateQuery }}">
                    <button class="btn btn-success">View Activity</button>
                </form>
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

            @if ($activities == null || count($activities) == 0)
                <h2 class="text-secondary">No Activity</h2>
            @endif
        </x-pageWrapper>
    </div>
@endsection
