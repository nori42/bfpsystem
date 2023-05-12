@props(['label', 'value', 'menuId'])
<button class="btn btn-subtleBlue w-100 fs-5 px-5 py-3" onclick="toggleShow('{{ $menuId }}')">
    <span class="float-start">
        <span class="fw-bold">{{ $label }}</span>
        <span class="fw-normal mx-5">{{ $value }}</span>
    </span>
    <span class="float-end edit-text"> <i class="bi bi-pencil edit-icon"></i> Edit </span>
</button>
