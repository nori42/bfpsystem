{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        <x-pageWrapper>
            @if (session('toastMssg') != null)
                <x-toast :message="session('toastMssg')" />
            @endif

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="d-block fw-bold fs-3">{{ $personnelCount }} Personnel</span>
                    <span class="d-block text-secondary ">Manage personnel</span>
                </div>
            </div>
            {{-- Put page content here --}}
            <div class="d-flex gap-5">
            </div>
            {{-- <x-personnel.cardList>
                @foreach ($usersList as $user)
                    @if ($user->personnel != null)
                        <x-personnel.card :personnel="$user->personnel" />
                    @endif
                @endforeach
            </x-personnel.cardList> --}}
            <div class="d-flex flex-column justify-content-center gap-4 mt-3 w-75 mx-auto mt-5">
                @foreach ($usersList as $user)
                    @if ($user->personnel != null)
                        <x-personnel.item :personnel="$user->personnel" />
                    @endif
                @endforeach
            </div>
        </x-pageWrapper>
    </div>
@endsection
