{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    @php
        $json = resource_path('json\printSettings.json');
        $jsonData = File::get($json);
        $printSettings = json_decode($jsonData, true);
        ['CityMarshal' => $marshal, 'ChiefFSES' => $chief] = $printSettings['settings'];
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        @isset($toastMssg)
            <x-toast :message="$toastMssg" />
        @endisset
        <x-pageWrapper>
            <form class="bg-subtleBlue p-4" action="" method="POST">
                @csrf
                <legend>Print Settings</legend>
                <div class="text-secondary">Print Signatory</div>
                <div class="w-25">
                    <x-form.input type="text" label="City Marshal" name="cityMarshal" :value="$marshal" />
                    <x-form.input type="text" label="Chief FSES" name="chiefFSES" :value="$chief" />
                </div>
                @isset($success)
                    <div class="text-success">Change Applied</div>
                @endisset ()
                <button class="btn btn-success my-3">Save
                    Changes</button>
            </form>
        </x-pageWrapper>
    </div>
@endsection
