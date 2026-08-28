<x-doctor-layout>
    <x-slot name="header">
        {{ __('تهيئة الوصفات الطبية') }}
    </x-slot>

    <div x-data="prescriptionSetup({{ $medications->toJson() }})" class="max-w-7xl mx-auto pb-12">
        <!-- Top Action Bar -->
        <div class="flex items-center gap-4 mb-4 print:hidden">
            <button @click="isSettingsModalOpen = true" class="bg-teal-600 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-teal-700 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ __('إعدادات الوصفة') }}
            </button>
            <button onclick="printPrescription()" class="bg-indigo-600 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                {{ __('طباعة الوصفة') }}
            </button>
            <button type="button" class="bg-slate-800 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-slate-700 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                {{ __('QR Code') }}
            </button>
        </div>

        <hr class="border-gray-200 my-6 print:hidden">

        <!-- Center Template Area -->
        <div class="flex justify-center w-full">
            <!-- The A4 Canvas -->

<style>
    :root{
        --blue:#22b9df;
        --ink:#244c63;
        --light:#f3f4f5;
        --shadow:0 14px 35px rgba(0,0,0,.16);
    }



    .prescription * { font-family: "Trebuchet MS","Segoe UI",Arial,sans-serif; box-sizing:border-box; color:var(--ink); }

    .prescription{
        position:relative;
        width:210mm;
        min-height:297mm;
        background:#fff;
        overflow:hidden;
        box-shadow:var(--shadow);
    }

    /* Header */
    .header{
        position:relative;
        height:67mm;
        background:var(--blue);
        overflow:hidden;
    }

    /* White curved cutout */
    .header::after{
        content:"";
        position:absolute;
        left:-12%;
        width:124%;
        height:65mm;
        bottom:-47mm;
        background:#fff;
        border-radius:50% 50% 0 0 / 55% 55% 0 0;
    }

    /* Subtle gray arc underneath the white curve */
    .header::before{
        content:"";
        position:absolute;
        left:24%;
        width:52%;
        height:34mm;
        bottom:-25mm;
        background:#d7d7d7;
        border-radius:50%;
        z-index:0;
    }

    .doctor{
        position:absolute;
        top:13mm;
        left:0;
        width:100%;
        text-align:center;
        color:white;
        z-index:2;
        white-space:nowrap;
    }

    .doctor-name{
        font-size:31pt;
        line-height:1;
        font-weight:700;
        letter-spacing:.2px;
    }

    .doctor-name .normal{
        font-weight:300;
    }

    .qualification{
        margin-top:7px;
        font-size:13pt;
        font-weight:400;
        letter-spacing:7px;
    }

    /* Patient information */
    .content{
        position:relative;
        min-height:215mm;
        padding:18mm 17mm 30mm;
    }

    .details{
        position:relative;
        z-index:3;
        font-size:12.5pt;
        letter-spacing:1px;
    }

    .row{
        display:flex;
        align-items:flex-end;
        gap:22px;
        margin-bottom:22px;
    }

    .field{
        display:flex;
        align-items:flex-end;
        gap:12px;
        flex:1;
        min-width:0;
    }

    .field.date{flex:0 0 52mm}
    .field.age{flex:0 0 45mm}
    .field.gender{flex:0 0 55mm}
    .field.weight{flex:0 0 55mm}

    .label{
        white-space:nowrap;
    }

    .line{
        height:23px;
        border-bottom:1.5px solid var(--ink);
        flex:1;
        min-width:20px;
    }

    .diagnosis{
        display:flex;
        align-items:flex-end;
        gap:14px;
        margin-top:4px;
    }

    /* Watermark */
    .watermark{
        position:absolute;
        left:-4mm;
        top:43mm;
        width:122mm;
        height:145mm;
        opacity:.48;
        z-index:1;
    }

    .watermark svg{
        width:100%;
        height:100%;
    }

    /* Signature */
    .signature{
        position:absolute;
        right:17mm;
        bottom:20mm;
        width:53mm;
        text-align:center;
        font-size:12.5pt;
        letter-spacing:1.5px;
        z-index:4;
    }

    .signature-line{
        height:25px;
        border-bottom:1.5px solid var(--ink);
        margin-bottom:8px;
    }

    /* Footer */
    .footer{
        position:absolute;
        bottom:0;
        left:0;
        width:100%;
        height:25mm;
        display:flex;
        align-items:center;
        justify-content:space-around;
        padding:0 18mm;
        background:linear-gradient(to top, #fff 72%, rgba(255,255,255,0));
        font-size:10.5pt;
        letter-spacing:.6px;
        z-index:5;
    }

    .contact{
        display:flex;
        align-items:center;
        gap:9px;
        white-space:nowrap;
    }

    .icon{
        width:18px;
        height:18px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        font-family:Arial,sans-serif;
        font-size:17px;
        font-weight:bold;
    }

    @media(max-width:900px){ .prescription{
            width:100%;
            min-height:100vh;
            box-shadow:none;
        }
    }

    @media(max-width:650px){
        .doctor-name{font-size:25pt}
        .qualification{font-size:10pt;letter-spacing:5px}
        .content{padding-left:8mm;padding-right:8mm}
        .row{gap:12px;flex-wrap:wrap}
        .field,.field.date,.field.age,.field.gender,.field.weight{
            flex:1 1 45%;
        }
        .footer{
            padding:0 7mm;
            font-size:8.5pt;
            gap:10px;
            justify-content:space-between;
        }
        .watermark{left:-15mm}
    }

    @media print{ @page{ size:A4; margin:0; } body{ padding:0; background:#fff; }
        .prescription{
            width:210mm;
            min-height:297mm;
            box-shadow:none;
        }
    }
</style>
<div id="prescription-print-area" class="flex justify-center w-full mx-auto print:break-after-avoid print:block print:absolute print:inset-0 print:m-0 print:p-0 print:border-none print:bg-white text-gray-900">
<main class="prescription">
     <header class="header">
        <div class="doctor">
            <div class="doctor-name">
                <span>{{ __('د') }}.</span> <span class="normal">{{ $settings->doctor_name }}</span>
            </div>
            <div class="qualification">{{ $settings->doctor_specialization }}</div>
        </div>
    </header>

    <section class="content">

        <div class="details">
            <div class="row">
                <div class="field">
                    <span class="label">{{ __('اسم المريض') }}:</span>
                    <span class="line" style="position: relative;">
                        <span style="position: absolute; bottom: 5px; left: 10px;" x-text="patientName || ''"></span>
                    </span>
                </div>
                <div class="field date">
                    <span class="label">{{ __('التاريخ') }}:</span>
                    <span class="line" style="position: relative;">
                         <span style="position: absolute; bottom: 5px; left: 10px;" x-text="bookingDate || ''"></span>
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="field age">
                    <span class="label">{{ __('العمر') }}:</span>
                    <span class="line" style="position: relative;">
                         <span style="position: absolute; bottom: 5px; left: 10px;" x-text="patientAge || ''"></span>
                    </span>
                </div>
                <div class="field date">
                    <span class="label">{{ __('تاريخ الميلاد') }}:</span>
                    <span class="line" style="position: relative;">
                         <span style="position: absolute; bottom: 5px; left: 10px;" x-text="patientDob || ''"></span>
                    </span>
                </div>
            </div>

            <div class="diagnosis">
                <span class="label">{{ __('التشخيص') }}:</span>
                <span class="line" style="position: relative;">
                     <span style="position: absolute; bottom: 5px; left: 10px;" x-text="patientDiagnosis || ''"></span>
                </span>
            </div>
        </div>

        <div class="flex-1 overflow-hidden flex flex-col min-h-0 space-y-2 mt-8" style="font-family: 'Times New Roman', Times, serif;">
            <!-- Empty State -->
            <div x-show="addedMedications.length === 0" class="text-center text-slate-400 print:hidden mt-4 text-sm font-sans shrink-0">
                {{ __('قم بإضافة أدوية من القائمة الجانبية') }}
            </div>

            <!-- Medication List -->
            <template x-for="(med, index) in addedMedications" :key="index">
                <div class="relative group border-b border-blue-50 print:border-transparent pb-2 last:border-0 hover:bg-slate-50 print:hover:bg-transparent -mx-3 px-3 rounded-lg transition-colors shrink-0 z-10">
                    <!-- Delete Button (Hidden on Print) -->
                    <button @click="removeMedication(index)" class="absolute left-2 top-2 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity print:hidden">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>

                    <div class="flex items-start gap-3">
                        <div class="text-base font-bold text-gray-800 print:text-black mt-0.5 w-6 text-right" x-text="(index + 1) + '.'"></div>
                        <div class="flex-1">
                            <div class="text-base font-bold text-gray-900 print:text-black flex items-center gap-2">
                                <span x-text="med.name"></span>
                                <span x-show="med.type" class="text-xs px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full print:border print:border-black print:bg-transparent font-sans" x-text="med.type"></span>
                            </div>
                            <div x-show="med.generic" class="text-xs text-gray-500 print:text-gray-700 mb-1 italic" x-text="med.generic"></div>

                            <!-- Editable Dosage and Usage -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1 mt-1">
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 print:hidden mb-0.5 font-sans">{{ __('الجرعة') }}</label>
                                    <input type="text" x-model="med.dosage" placeholder="{{ __('مثال') }}: {{ __('حبة واحدة') }}" class="w-full bg-transparent border-b border-gray-200 print:border-transparent focus:border-blue-500 focus:outline-none focus:ring-0 text-gray-800 print:text-black text-sm px-0 py-0.5 transition-colors font-medium">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-gray-400 print:hidden mb-0.5 font-sans">{{ __('وقت الاستخدام') }}</label>
                                    <input type="text" x-model="med.usage" placeholder="{{ __('مثال') }}: {{ __('مرتين يومياً بعد الأكل') }}" class="w-full bg-transparent border-b border-gray-200 print:border-transparent focus:border-blue-500 focus:outline-none focus:ring-0 text-gray-800 print:text-black text-sm px-0 py-0.5 transition-colors font-medium">
                                </div>
                                <div class="md:col-span-2 hidden">
                                    <label class="block text-[10px] font-semibold text-gray-400 print:hidden mb-0.5 font-sans">{{ __('دواعي الاستعمال') }}</label>
                                    <input type="text" x-model="med.indications" placeholder="{{ __('مثال') }}: {{ __('مسكن للألم') }}" class="w-full bg-transparent border-b border-gray-200 print:border-transparent focus:border-blue-500 focus:outline-none focus:ring-0 text-gray-800 print:text-black text-sm px-0 py-0.5 transition-colors font-medium">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Faint medical watermark -->
        <div class="watermark" aria-hidden="true">
            <svg viewBox="0 0 500 620" xmlns="http://www.w3.org/2000/svg">
                <g fill="#eef0f1">
                    <!-- staff -->
                    <rect x="245" y="135" width="18" height="390" rx="9"/>
                    <circle cx="254" cy="112" r="34"/>
                    <!-- stylized wings -->
                    <path d="M232 151
                             C190 148 153 124 118 106
                             C83 88 42 91 22 112
                             C8 127 17 155 40 170
                             C67 188 99 184 124 166
                             C109 195 80 214 42 215
                             C76 238 123 229 154 204
                             C142 230 112 249 78 255
                             C117 270 162 252 185 218
                             C196 202 210 183 232 175 Z"/>
                    <path d="M276 151
                             C318 148 355 124 390 106
                             C425 88 466 91 486 112
                             C500 127 491 155 468 170
                             C441 188 409 184 384 166
                             C399 195 428 214 466 215
                             C432 238 385 229 354 204
                             C366 230 396 249 430 255
                             C391 270 346 252 323 218
                             C312 202 298 183 276 175 Z"/>
                    <!-- serpent -->
                    <path d="M254 240
                             C210 273 190 299 207 324
                             C223 348 271 341 281 370
                             C292 402 245 416 220 444
                             C196 471 206 501 247 520"
                          fill="none" stroke="#eef0f1" stroke-width="24"
                          stroke-linecap="round"/>
                    <path d="M260 240
                             C304 273 324 299 307 324
                             C291 348 243 341 233 370
                             C222 402 269 416 294 444
                             C318 471 308 501 267 520"
                          fill="none" stroke="#eef0f1" stroke-width="24"
                          stroke-linecap="round"/>
                    <!-- serpent heads -->
                    <path d="M205 238 C188 226 183 209 195 198 C208 186 226 193 236 207 L245 222 Z"/>
                    <path d="M303 238 C320 226 325 209 313 198 C300 186 282 193 272 207 L263 222 Z"/>
                </g>
            </svg>
        </div>

        <div class="signature">
            <div class="signature-line"></div>
            <div>{{ __('التوقيع') }}</div>
        </div>

    </section>

    <footer class="footer">
        <div class="contact">
            <span class="icon">●</span>
            <span>{{ $settings->clinic_name }}</span>
        </div>
        <div class="contact">
            <span class="icon">☎</span>
            <span dir="ltr">{{ $settings->whatsapp_phone_number_id ?? '---' }}</span>
        </div>
        <div class="contact">
            <img src="{{ asset('images/logo-text.png') }}" class="h-6 object-contain" alt="Atlas Logo">
        </div>
    </footer>

</main>

</div>
        </div>
            <!-- Settings Modal (Hidden by Default) -->
        <div x-show="isSettingsModalOpen" style="display: none;" class="fixed inset-0 z-[80] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="isSettingsModalOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
                <div class="p-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                    <h2 class="text-lg font-bold text-slate-800">{{ __('إعدادات قالب الوصفة وبياناتها') }}</h2>
                    <button @click="isSettingsModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto flex-1 space-y-8">
                    <!-- Settings Form -->
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ __('إعدادات قالب الوصفة') }}
                        </h3>
                        <form action="{{ route('doctor.prescriptions.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('اسم العيادة') }}</label>
                                    <input type="text" name="clinic_name" value="{{ old('clinic_name', $settings->clinic_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('اسم الطبيب') }}</label>
                                    <input type="text" name="doctor_name" value="{{ old('doctor_name', $settings->doctor_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('تخصص الطبيب') }}</label>
                                <input type="text" name="doctor_specialization" value="{{ old('doctor_specialization', $settings->doctor_specialization) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('الشعار الأول') }} ({{ __('اليمين') }})</label>
                                    <input type="file" name="logo_1" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
                                    @if($settings->logo_1_path)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($settings->logo_1_path) }}" alt="Logo 1" class="h-12 object-contain rounded">
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('الشعار الثاني') }} ({{ __('اليسار - اختياري') }})</label>
                                    <input type="file" name="logo_2" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
                                    @if($settings->logo_2_path)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($settings->logo_2_path) }}" alt="Logo 2" class="h-12 object-contain rounded">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-slate-800 transition-colors">
                                {{ __('حفظ الإعدادات') }}
                            </button>
                        </form>
                    </div>

                    <hr class="border-slate-200">

                    <!-- Prescription Data Entry -->
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            {{ __('بيانات الوصفة') }}
                        </h3>
                        <div class="space-y-4">
                            <!-- Patient Selection -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('المريض') }} ({{ __('مواعيد اليوم') }})</label>
                                <select x-model="selectedAppointmentId" @change="updatePatientData" class="w-full bg-slate-50 border border-slate-200 rounded-xl ps-3.5 pe-8 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                    <option value="">-- {{ __('اختر مريض') }} --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" data-patient="{{ $patient->name }}" data-date="{{ today()->format('Y/m/d') }}" data-booking="{{ $patient->id }}" data-dob="{{ $patient->dob ? $patient->dob->format('Y-m-d') : '' }}" data-diagnosis="{{ $patient->medicalRecords->first()->diagnosis ?? '' }}">
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Manual Override for Patient Details -->
                            <div x-show="selectedAppointmentId" x-collapse>
                                <div class="p-3 bg-slate-50 rounded-xl space-y-3 mt-2 border border-slate-100">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('اسم المريض') }}</label>
                                        <input type="text" x-model="patientName" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('رقم الحجز') }}</label>
                                            <input type="text" x-model="bookingNumber" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('التاريخ') }}</label>
                                            <input type="text" x-model="bookingDate" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm" dir="ltr">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medication Selection -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('إضافة دواء') }}</label>
                                <div class="flex gap-2">
                                    <select x-model="selectedMedicationId" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl ps-3.5 pe-8 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                        <option value="">-- {{ __('اختر دواء') }} --</option>
                                        @foreach($medications as $med)
                                            <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-generic="{{ $med->generic_name }}" data-type="{{ $med->medication_type }}">
                                                {{ $med->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button @click="addMedication()" type="button" class="bg-teal-600 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-teal-700 transition-colors flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function printPrescription() {
            // 1. Get the exact HTML of the prescription template
            const printContent = document.getElementById('prescription-print-area').innerHTML;

            // 2. Open a new temporary background window
            const printWindow = window.open('', '_blank', 'width=800,height=900');

            // 3. Write the HTML structure
            printWindow.document.write('<html dir="rtl"><head><title>طباعة الوصفة</title>');

            // 4. Clone all stylesheets from the main system so Tailwind works perfectly in the print window
            const styles = document.querySelectorAll('link[rel="stylesheet"], style');
            styles.forEach(style => {
                printWindow.document.write(style.outerHTML);
            });

            // 5. Inject the prescription content into a clean white body
            printWindow.document.write('</head><body class="bg-white p-8">');
            printWindow.document.write(printContent);
            printWindow.document.write('</body></html>');

            // 6. Close document, wait for styles to load, print, and auto-close the window
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500); // 500ms delay ensures Tailwind CSS is fully applied before the print dialog opens
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('prescriptionSetup', (medicationsData = []) => ({
                isSettingsModalOpen: false,
                selectedAppointmentId: '',
                patientName: '',
                bookingNumber: '',
                bookingDate: '{{ today()->format('Y/m/d') }}',
                patientAge: '',
                patientDob: '',
                patientDiagnosis: '',

                selectedMedicationId: '',
                medications: medicationsData,
                addedMedications: [],

                updatePatientData() {
                    if (this.selectedAppointmentId) {
                        const select = document.querySelector('select[x-model="selectedAppointmentId"]');
                        const option = select.options[select.selectedIndex];
                        this.patientName = option.dataset.patient;
                        this.bookingNumber = option.dataset.booking;
                        this.bookingDate = option.dataset.date;
                        this.patientDiagnosis = option.dataset.diagnosis;

                        const dob = option.dataset.dob;
                        if (dob) {
                            this.patientDob = dob;
                            const birthDate = new Date(dob);
                            const today = new Date();
                            let age = today.getFullYear() - birthDate.getFullYear();
                            const m = today.getMonth() - birthDate.getMonth();
                            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                                age--;
                            }
                            this.patientAge = age;
                        } else {
                            this.patientDob = '';
                            this.patientAge = '';
                        }

                    } else {
                        this.patientName = '';
                        this.bookingNumber = '';
                        this.bookingDate = '{{ today()->format('Y/m/d') }}';
                        this.patientDob = '';
                        this.patientAge = '';
                        this.patientDiagnosis = '';
                    }
                },

                addMedication() {
                    if (!this.selectedMedicationId) return;

                    const select = document.querySelector('select[x-model="selectedMedicationId"]');
                    const option = select.options[select.selectedIndex];

                    const foundMed = this.medications.find(m => m.id == this.selectedMedicationId) || {};

                    this.addedMedications.push({
                        id: this.selectedMedicationId,
                        name: option.dataset.name,
                        generic: option.dataset.generic,
                        type: option.dataset.type,
                        dosage: (foundMed.dosages && foundMed.dosages.length > 0) ? foundMed.dosages[0] : '',
                        usage: (foundMed.usage_times && foundMed.usage_times.length > 0) ? foundMed.usage_times[0] : '',
                        indications: foundMed.indications || ''
                    });

                    // Reset selection
                    this.selectedMedicationId = '';
                },

                removeMedication(index) {
                    this.addedMedications.splice(index, 1);
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>
