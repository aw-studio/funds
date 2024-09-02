@props(['title'])
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex min-h-12 border-b py-2">
            <span class="font-serif font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $title }}
            </span>
        </div>
        {{ $slot }}
    </div>
</div>
