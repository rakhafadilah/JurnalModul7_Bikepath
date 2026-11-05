@props(['name', 'size' => 24, 'color' => null, 'fill' => null])
<i data-lucide="{{ $name }}" {{ $attributes }} style="width:{{ $size }}px;height:{{ $size }}px;@if($color)color:{{ $color }};@endif @if($fill)fill:{{ $fill }};@endif display:inline-block;flex-shrink:0;"></i>
