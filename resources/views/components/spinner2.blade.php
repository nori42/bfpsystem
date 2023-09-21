@props(['hidden' => false])
<div class="position-relative" style="height: 100px; width:0px;">
    <div class="spinner loading-bar-spinner" style="display: {{ $hidden ? 'none' : 'block' }};">
        <div class="spinner-icon">
        </div>
    </div>
</div>


@section('')
@endsection
