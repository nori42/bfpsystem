{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.archive')

@section('archiveContent')
    <div class="mt-3" style="height: 650px">

        <table class="table">
            <thead>
                <th>Username</th>
                <th>Personnel</th>
                <th>Date Deleted</th>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    @php
                        $personnel = $item->personnelDeleted;
                        $name = $personnel->first_name . ' ' . $personnel->last_name;
                    @endphp
                    <tr>
                        <td>{{ $item->username }}</td>
                        <td>{{ $name }}</td>
                        <td>{{ date('m/d/Y g:i A', strtotime($item->deleted_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
    </div>
@endsection
