@inject('settings', \Funds\Foundation\SettingsService::class)
<footer class="p-8 border-t border-gray-500 page-footer">
    <div class="container flex flex-col flex-wrap items-center gap-y-10 md:flex-row md:justify-between">
        <div>
            <x-public::public-logo />
        </div>
        <nav>
            <x-public::footer-nav :$settings />
        </nav>
    </div>
</footer>
