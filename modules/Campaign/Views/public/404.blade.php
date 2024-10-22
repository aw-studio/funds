<x-public::campaign-layout>
    <div class="my-10">
        <div class="text-center">
            <h1 class="text-3xl font-bold">
                {{ __('404 - Page not found') }}
            </h1>
            <p>
                {{ __('The page you are looking for does not exist.') }}
            </p>
            <p>
                <a
                    href="/"
                    class="text--general-color underline underline-offset-4 text-accent-1"
                >
                    {{ __('Back to campaigns') }}
                </a>
            </p>
        </div>

    </div>
</x-public::campaign-layout>
