import re

with open('resources/views/doctor/prescriptions/index.blade.php', 'r') as f:
    content = f.read()

# We want to replace everything inside `<div id="prescription-print-area"...>` with the new HTML.

start_tag = '<div id="prescription-print-area"'
end_tag = '</div>\n        </div>\n            <!-- Settings Modal'

start_idx = content.find(start_tag)
# Find the end of the opening div tag
open_end_idx = content.find('>', start_idx) + 1

end_idx = content.find(end_tag)

if start_idx != -1 and end_idx != -1:
    print("Found sections to replace.")

    new_css = """
<style>
    :root{
        --blue:#22b9df;
        --ink:#244c63;
        --light:#f3f4f5;
        --shadow:0 14px 35px rgba(0,0,0,.16);
    }

    *{box-sizing:border-box}

    body{
        margin:0;
        min-height:100vh;
        background:#ececec;
        font-family:"Trebuchet MS","Segoe UI",Arial,sans-serif;
        color:var(--ink);
        display:flex;
        justify-content:center;
        align-items:flex-start;
        padding:30px;
    }

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

    @media(max-width:900px){
        body{padding:0;background:#fff}
        .prescription{
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

    @media print{
        @page{
            size:A4;
            margin:0;
        }
        body{
            padding:0;
            background:#fff;
        }
        .prescription{
            width:210mm;
            min-height:297mm;
            box-shadow:none;
        }
    }
</style>
"""

    new_html = """<main class="prescription">
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
"""

    new_content = content[:start_idx] + new_css + content[start_idx:open_end_idx] + "\n" + new_html + "\n" + content[end_idx:]
    with open('resources/views/doctor/prescriptions/index.blade.php', 'w') as f:
        f.write(new_content)
    print("Done")
else:
    print("Failed to find start_idx or end_idx")
