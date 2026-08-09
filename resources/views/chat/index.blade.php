<x-dynamic-component :component="auth()->user()->role === 'doctor' ? 'doctor-layout' : 'app-layout'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الرسائل') }}
        </h2>
    </x-slot>

    <div class="py-12 flex-1 flex flex-col h-full h-[calc(100vh-10rem)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full h-full flex flex-col">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex-1 flex flex-col sm:flex-row border border-slate-200">

                <!-- Sidebar Pane: Conversations List -->
                <div class="w-full sm:w-1/3 border-e border-slate-200 flex flex-col bg-slate-50 overflow-hidden h-full">
                    <div class="p-4 border-b border-slate-200 bg-white">
                        <h3 class="font-bold text-lg text-slate-800">{{ __('المحادثات') }}</h3>
                    </div>

                    <div class="flex-1 overflow-y-auto custom-scrollbar">
                        @forelse($conversations as $conversation)
                            <a href="{{ route('chat.show', $conversation->id) }}" class="block border-b border-slate-100 hover:bg-indigo-50 transition-colors {{ isset($chat) && $chat->id === $conversation->id ? 'bg-indigo-50 border-s-4 border-indigo-600' : 'border-s-4 border-transparent' }}">
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="font-bold text-slate-800">
                                            @if($conversation->patient)
                                                {{ $conversation->patient->name }}
                                            @else
                                                {{ $conversation->provider_chat_id }}
                                            @endif
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            @if($conversation->last_message_at)
                                                {{ $conversation->last_message_at->format('Y/m/d H:i') }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($conversation->platform === 'whatsapp')
                                            <span class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 3.825 0 6.938 3.112 6.938 6.937 0 3.825-3.113 6.938-6.938 6.938z"/></svg>
                                            </span>
                                        @elseif($conversation->platform === 'telegram')
                                            <span class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/></svg>
                                            </span>
                                        @endif
                                        <div class="text-sm text-slate-500 truncate flex-1">
                                            @if($conversation->messages->count() > 0)
                                                {{ $conversation->messages->first()->content }}
                                            @else
                                                {{ __('لا توجد رسائل') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-center text-slate-500 flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                {{ __('لا توجد محادثات') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Main Pane: Chat Room -->
                <div class="flex-1 flex flex-col bg-slate-50 h-full relative">
                    @if(isset($chat))
                        <!-- Chat Header -->
                        <div class="p-4 border-b border-slate-200 bg-white flex items-center justify-between shadow-sm z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                    @if($chat->patient)
                                        {{ mb_substr($chat->patient->name, 0, 1) }}
                                    @else
                                        ?
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800">
                                        @if($chat->patient)
                                            {{ $chat->patient->name }}
                                        @else
                                            {{ $chat->provider_chat_id }}
                                        @endif
                                    </h3>
                                    <div class="text-xs text-slate-500 flex items-center gap-1">
                                        <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                        {{ __('متصل عبر') }} {{ ucfirst($chat->platform) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div class="flex-1 p-4 overflow-y-auto custom-scrollbar flex flex-col gap-4 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50/50" id="chat-messages">
                            @forelse($messages as $msg)
                                @if($msg->sender_type === 'clinic')
                                    <!-- Outgoing Message (Clinic) -->
                                    <div class="flex justify-start">
                                        <div class="max-w-[75%] bg-indigo-600 text-white rounded-2xl rounded-tr-sm px-4 py-2 shadow-sm">
                                            <div class="text-sm">{{ $msg->content }}</div>
                                            <div class="text-[10px] text-indigo-200 text-end mt-1 flex items-center justify-end gap-1">
                                                {{ $msg->created_at->format('H:i') }}
                                                @if($msg->status === 'sent')
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                @elseif($msg->status === 'delivered')
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M5 13l4 4L19 7"></path></svg>
                                                @elseif($msg->status === 'read')
                                                    <svg class="w-3 h-3 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M5 13l4 4L19 7"></path></svg>
                                                @elseif($msg->status === 'failed')
                                                    <svg class="w-3 h-3 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Incoming Message (Patient) -->
                                    <div class="flex justify-end">
                                        <div class="max-w-[75%] bg-white border border-slate-200 text-slate-800 rounded-2xl rounded-tl-sm px-4 py-2 shadow-sm">
                                            <div class="text-sm">{{ $msg->content }}</div>
                                            <div class="text-[10px] text-slate-400 text-end mt-1">
                                                {{ $msg->created_at->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="m-auto text-center text-slate-500 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                                    {{ __('هذه بداية المحادثة مع') }} {{ $chat->patient ? $chat->patient->name : $chat->provider_chat_id }}
                                </div>
                            @endforelse
                        </div>

                        <!-- Chat Input -->
                        <div class="p-4 bg-white border-t border-slate-200">
                            <form method="POST" action="{{ route('chat.store', $chat->id) }}" class="flex gap-2 items-end">
                                @csrf
                                <div class="flex-1 bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                                    <textarea
                                        name="content"
                                        rows="1"
                                        class="w-full bg-transparent border-0 focus:ring-0 resize-none py-3 px-4 max-h-32 text-slate-800"
                                        placeholder="{{ __('اكتب رسالة...') }}"
                                        required
                                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                    ></textarea>
                                </div>
                                <button type="submit" class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition-colors shadow-sm flex-shrink-0">
                                    <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </button>
                            </form>
                        </div>

                        <script>
                            // Scroll to bottom of chat
                            const chatMessages = document.getElementById('chat-messages');
                            if (chatMessages) {
                                chatMessages.scrollTop = chatMessages.scrollHeight;
                            }
                        </script>
                    @else
                        <!-- No Chat Selected State -->
                        <div class="flex-1 flex flex-col items-center justify-center text-slate-400 p-8 text-center bg-slate-50/50">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 mb-6">
                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-700 mb-2">{{ __('مرحباً بك في مركز الرسائل') }}</h3>
                            <p class="max-w-md">{{ __('اختر محادثة من القائمة للبدء في التواصل مع المرضى عبر واتساب وتليجرام.') }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-dynamic-component>
