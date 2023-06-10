@props(['draggable' => true, 'editable' => false, 'class' => '', 'position' => ['top' => 0, 'left' => 0]])

<div data-draggable="{{ $draggable }}" data-editable="{{ $editable }}" contenteditable="{{ $editable }}"
    style="position: absolute; top:{{ $position['top'] }}; left:{{ $position['left'] }};">
    <span class="{{ $class }}"></span>
</div>
