@props(['title', 'value', 'description'])

<div class="border rounded-2xl p-4 shadow bg-[#f8f8f8]">
    <header class="flex items-center mb-4 justify-between">
        <h4 class="font-medium">{{$title}}</h4>
        {{$slot}}
    </header>
    <section>
        <p class="font-bold text-lg">
            {{$value}}
        </p>
        <p class="text-sm">
            {{$description}}
        </p>
    </section>
</div>
