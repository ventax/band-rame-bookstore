<!-- Toast Notification Component -->
<div x-data="toastManager()" x-init="init()" @toast.window="show($event.detail)"
    class="fixed top-4 right-4 z-50 space-y-2">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.visible" x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            :class="{
                'bg-green-500': toast.type === 'success',
                'bg-red-500': toast.type === 'error',
                'bg-blue-500': toast.type === 'info',
                'bg-yellow-500': toast.type === 'warning'
            }"
            class="flex items-center p-4 rounded-lg shadow-lg text-white min-w-[300px] max-w-md">
            <div class="flex-shrink-0">
                <i :class="{
                    'fa-check-circle': toast.type === 'success',
                    'fa-exclamation-circle': toast.type === 'error',
                    'fa-info-circle': toast.type === 'info',
                    'fa-exclamation-triangle': toast.type === 'warning'
                }"
                    class="fas text-xl"></i>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium" x-text="toast.message"></p>
            </div>
            <button @click="remove(toast.id)" class="ml-4 flex-shrink-0">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </template>
</div>

<script>
    function toastManager() {
        return {
            toasts: [],
            nextId: 1,

            init() {
                // Listen for Laravel flash messages
                @if (session('success'))
                    this.show({
                        message: '{{ session('success') }}',
                        type: 'success'
                    });
                @endif
                @if (session('error'))
                    this.show({
                        message: '{{ session('error') }}',
                        type: 'error'
                    });
                @endif
            },

            show(config) {
                const id = this.nextId++;
                const toast = {
                    id,
                    message: config.message || 'Notification',
                    type: config.type || 'info',
                    visible: true
                };

                this.toasts.push(toast);

                setTimeout(() => {
                    this.remove(id);
                }, config.duration || 3000);
            },

            remove(id) {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index > -1) {
                    this.toasts[index].visible = false;
                    setTimeout(() => {
                        this.toasts.splice(index, 1);
                    }, 200);
                }
            }
        };
    }
</script>
