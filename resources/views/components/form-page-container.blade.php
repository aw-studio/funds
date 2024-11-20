@props(['title'])
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex min-h-12 border-b py-2">
            <x-page-headline :value="$title" />
        </div>
        {{ $slot }}
    </div>
</div>
