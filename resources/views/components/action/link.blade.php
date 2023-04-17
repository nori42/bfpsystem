@props([
    'active' => false,
    'href',
    'text'
])

<a href="{{$href}}" id="btnInspection" 
@class([
    'btn', 
    'btn-action',
    'rounded-0',
    'fs-5',
    'fsic-active' => $active
    ])>{{$text}}</a>