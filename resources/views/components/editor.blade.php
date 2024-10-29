@props(['content'])
<style>
    h2.ce-header {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    h3.ce-header {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    h4.ce-header {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>
<div class="min-h-32 mb-8">
    <textarea
        id="content"
        type="hidden"
        name="content"
        hidden
    >{{ $content }}</textarea>

    <div
        id="editorjs"
        class="border border-gray-200 rounded-lg p-2 bg"
    ></div>
</div>

@error('content')
    <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
@enderror
