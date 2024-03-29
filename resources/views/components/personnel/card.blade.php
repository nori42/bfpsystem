@props(['personnel'])

<div class="card border-0 px-4 py-2 boxshadow" style="background-color: #F5F8FC; width: 18rem; ">
    {{-- <div class="card-img-top text-center">
        <span class="material-symbols-outlined border border-dark border-1 rounded-circle p-4 mt-4 bg-white"
            style="font-size: 3.5rem">
            person
        </span>
    </div> --}}
    {{-- <div class="bg-white rounded-circle p-3 justify-content-center d-flex">
        <img src="{{ $personnel->profile_pic_path ? asset($personnel->profile_pic_path) : asset('img/Firefighter.svg') }}"
            alt="fireman" height="125px">
    </div> --}}
    <div class="align-self-center" style="height: 13rem; width: 13rem;" id="profile">
        <img class="bg-white rounded-circle" height="100%" width="100%"
            src="{{ $personnel->profile_pic_path ? asset($personnel->profile_pic_path) : asset('img/Firefighter.svg') }}"
            alt="fireman" height="125px">
    </div>
    @php
        $name = $personnel->first_name . ' ' . $personnel->last_name;
    @endphp
    <div class="card-body">
        <h5 class="card-title text-center fw-bold fs-6"
            {{ strlen($name) >= 20 ? 'style="font-size:0.8rem !important;"' : '' }}>{{ $name }}</h5>
        <h6 class="text-secondary text-center">{{ $personnel->user->type }}</h6>
        <div class="mt-3">
        </div>

        <a class="btn btn-primary border-0 w-100 fw-bold mt-4" href="/personnel/{{ $personnel->id }}">Info</a>

    </div>
</div>
