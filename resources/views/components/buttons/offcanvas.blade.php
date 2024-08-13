@props(["href"=>"", "target" => "", "icon"=>"icon-add-new", "title", "small"=>"", "class"=>""])


@if($href)
<a href='{{$href}}'
    class='btn btn-primary {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-bs-toggle="tooltip"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</a>
@else
<button type="button"
    class='btn btn-primary {{($small=='true')? 'btn-sm' : ''}} {{$class}}'
    data-crud-id="0"
    title="{{ $title }}">
    <i class="{{$icon}}"></i>
    {{ $slot }}
</button>
@endif
