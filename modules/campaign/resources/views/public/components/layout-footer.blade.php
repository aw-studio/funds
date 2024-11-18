@inject('settings', \Funds\Foundation\SettingsService::class)
<footer class="p-8 border-t border-gray-500 page-footer">
    <div class="max-w-7xl mx-auto flex justify-center">
        <div>
            <x-public::public-logo />
        </div>
        <nav class="ml-auto">
            <x-public::footer-nav :$settings />
        </nav>
    </div>
</footer>
