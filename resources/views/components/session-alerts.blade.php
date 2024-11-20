@if (session('flashMessage'))
    <script>
        window.addEventListener('livewire:navigated', () => {
            window.dispatchEvent(new CustomEvent('notify', {
                detail: [{
                    message: @js(session('flashMessage')['message']),
                    type: @js(session('flashMessage')['type']),
                }]
            }));
        });
    </script>
@endif
<div
    x-data="{
        shown: false,
        timeout: null,
        message: '',
        type: 'info',
        onMessage(detail) {
            let { message, type } = detail[0];
            if (!message) return;

            this.message = message;
            this.type = type;

            console.log(this.message, this.type);
            clearTimeout(this.timeout);
            this.shown = true;
            this.timeout = setTimeout(() => {
                this.shown = false;
            }, 3000);
        }
    }"
    x-on:notify.window="onMessage($event.detail)"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="fixed right-4 bottom-4 max-w-xs space-y-2"
    x-cloak
>
    <div
        id="flash-message"
        role="alert"
        class="rounded-xl bg-black text-white p-4 "
    >
        <div class="flex items-start gap-4">
            <span
                x-text="message"
                class="text-sm"
                x-bind:class="{
                    'text-success-500': type === 'success',
                    'text-danger-500': type === 'danger',
                    'text-danger-500': type === 'error',
                    'text-warning-500': type === 'warning',
                    'text-gray-500': type === 'info',
                }"
            ></span>
        </div>
    </div>
</div>
