@props(['href', 'target' => '_self'])
<a class="inline-flex items-center justify-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary" target="{{$target}}" href="{{$href}}">
    {{$slot}}
</a>
