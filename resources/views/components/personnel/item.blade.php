@props(['personnel'])

@php
    $name = $personnel->first_name . ' ' . $personnel->last_name;
@endphp
<div class="d-flex align-items-center justify-content-between border-0 boxshadow p-4" style="background-color: #F5F8FC;">
    <div class="d-flex align-items-center gap-5">
        <div class="align-self-center" style="height: 6rem; width: 6rem;" id="profile">
            <img class="bg-white rounded-circle" height="100%" width="100%"
                src="{{ $personnel->profile_pic_path ? asset($personnel->profile_pic_path) : asset('img/Firefighter.svg') }}"
                alt="fireman" height="125px">
        </div>
        <div>
            <div class="card-title text-center fw-bold fs-4"
                {{ strlen($name) >= 20 ? 'style="font-size:0.8rem !important;"' : '' }}>{{ $name }}</div>
            <div class="text-secondary text-start fs-5">{{ $personnel->user->type }}</div>
        </div>
    </div>
    <a class="btn btn-primary border-0 fw-bold px-5" href="/personnel/{{ $personnel->id }}">Details</a>
</div>
