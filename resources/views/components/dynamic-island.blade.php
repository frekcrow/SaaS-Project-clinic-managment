<div x-data="dynamicIsland()"
     x-init="initIsland()"
     class="fixed top-4 left-1/2 transform -translate-x-1/2 z-[100] flex justify-center items-start pointer-events-none"
     dir="rtl">

    <div :class="{
            'w-8 h-8 rounded-full opacity-0': !activeNotification,
            'w-96 min-h-[5rem] rounded-3xl opacity-100 pointer-events-auto': activeNotification
         }"
         class="bg-black/90 text-white backdrop-blur-md shadow-2xl overflow-hidden transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] relative flex items-center p-4">

        <template x-if="activeNotification">
            <div class="flex items-center gap-4 w-full"
                 x-show="showContent"
                 x-transition:enter="transition ease-out duration-300 delay-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">

                <!-- Icon based on type -->
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <template x-if="activeNotification.data.icon === 'clock'">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <template x-if="activeNotification.data.icon === 'play'">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <template x-if="activeNotification.data.icon === 'check-circle'">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                    <template x-if="!['clock', 'play', 'check-circle'].includes(activeNotification.data.icon)">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </template>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate" x-text="activeNotification.data.message"></p>
                </div>

                <button @click="dismissNotification()" class="flex-shrink-0 text-white/50 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </template>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dynamicIsland', () => ({
            activeNotification: null,
            showContent: false,
            interval: null,
            timeoutId: null,

            initIsland() {
                // Poll every 5 seconds
                this.interval = setInterval(() => {
                    if (!this.activeNotification) {
                        this.fetchLatest();
                    }
                }, 5000);

                // Initial check
                setTimeout(() => this.fetchLatest(), 1000);
            },

            async fetchLatest() {
                try {
                    const response = await fetch('/api/notifications/latest', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (response.ok) {
                        const notifications = await response.json();
                        if (notifications && notifications.length > 0) {
                            this.showNotification(notifications[0]);
                        }
                    }
                } catch (error) {
                    console.error('Error fetching notifications:', error);
                }
            },

            showNotification(notification) {
                this.activeNotification = notification;

                // Show content after a slight delay for the expand animation
                setTimeout(() => {
                    this.showContent = true;
                }, 300);

                // Auto dismiss after 4 seconds
                this.timeoutId = setTimeout(() => {
                    this.dismissNotification();
                }, 4000);
            },

            async dismissNotification() {
                if (this.timeoutId) {
                    clearTimeout(this.timeoutId);
                }

                // Hide content first
                this.showContent = false;

                if (this.activeNotification) {
                    const notifId = this.activeNotification.id;

                    // Shrink island
                    setTimeout(() => {
                        this.activeNotification = null;
                    }, 200); // Wait for content fade out

                    // Mark as read in backend
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        await fetch(`/api/notifications/${notifId}/read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        // Dispatch event to update bell counter if it exists
                        window.dispatchEvent(new CustomEvent('notification-read'));
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                }
            },

            destroy() {
                if (this.interval) clearInterval(this.interval);
                if (this.timeoutId) clearTimeout(this.timeoutId);
            }
        }));
    });
</script>
