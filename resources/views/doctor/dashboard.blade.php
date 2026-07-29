<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Dashboard Workspace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 mb-6 border-b">
                    {{ __('Welcome Dr. :name - Doctor Dashboard Workspace', ['name' => auth()->user()->name]) }}
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Live Queue - Today's Appointments</h3>

                    @if($todaysAppointments->isEmpty())
                        <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                            لا توجد بيانات (No appointments today)
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Turn</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($todaysAppointments as $appointment)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $appointment->queue_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $appointment->patient_name ?? ($appointment->patient ? $appointment->patient->name : '-') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($appointment->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @elseif($appointment->status === 'in_progress')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                                @elseif($appointment->status === 'completed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($appointment->status === 'pending')
                                                    <form method="POST" action="{{ route('appointments.update_status', $appointment) }}" class="inline-block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="in_progress">
                                                        <button type="submit" class="bg-black text-white shadow-sm hover:bg-neutral-800 transition-colors px-3 py-1 rounded">
                                                            بدء الجلسة
                                                        </button>
                                                    </form>
                                                @elseif($appointment->status === 'in_progress')
                                                    <div class="flex items-center gap-4">
                                                        <form method="POST" action="{{ route('appointments.update_status', $appointment) }}" class="inline-block">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="bg-black text-white shadow-sm hover:bg-neutral-800 transition-colors px-3 py-1 rounded">
                                                                إنهاء الجلسة
                                                            </button>
                                                        </form>

                                                        <div x-data="liveTimer('{{ $appointment->session_started_at ? $appointment->session_started_at->toIso8601String() : now()->toIso8601String() }}')" class="text-blue-600 font-mono font-bold text-lg flex items-center gap-2 bg-blue-50 px-3 py-1 rounded border border-blue-100">
                                                            <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                            <span x-text="timeString"></span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('liveTimer', (startedAtIso) => ({
            startedAt: new Date(startedAtIso),
            now: new Date(),
            timeString: '00:00',
            interval: null,
            init() {
                this.updateTimer();
                this.interval = setInterval(() => {
                    this.now = new Date();
                    this.updateTimer();
                }, 1000);
            },
            updateTimer() {
                const diffMs = this.now - this.startedAt;
                if (diffMs < 0) {
                    this.timeString = '00:00';
                    return;
                }
                const totalSeconds = Math.floor(diffMs / 1000);
                const minutes = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
                const seconds = (totalSeconds % 60).toString().padStart(2, '0');
                this.timeString = `${minutes}:${seconds}`;
            },
            destroy() {
                if (this.interval) clearInterval(this.interval);
            }
        }));
    });
</script>
</x-app-layout>
