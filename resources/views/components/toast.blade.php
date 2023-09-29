@props(['message', 'type' => 'default'])

@switch($type)
    @case('success')
        <div class="w-35 rounded-2 p-3 toastnb" style="background-color: #407b40;">
            <div class="fs-5 text-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-check2-circle mr-3"></i>{{ $message }}</span>
            </div>
        </div>
    @break

    @default
        <div class="bg-secondary w-35 rounded-2 p-3 toastnb">
            <div class="fs-5 text-white d-flex justify-content-between align-items-center">
                <span>{{ $message }}</span>
            </div>
        </div>
@endswitch
