import re

with open('resources/views/doctor/prescriptions/index.blade.php', 'r') as f:
    content = f.read()

# 1. Scope the CSS and remove the global body rule
content = re.sub(r'\*\{box-sizing:border-box\}', '', content)
content = re.sub(r'body\{\s*margin:0;\s*min-height:100vh;\s*background:#ececec;\s*font-family:"Trebuchet MS","Segoe UI",Arial,sans-serif;\s*color:var\(--ink\);\s*display:flex;\s*justify-content:center;\s*align-items:flex-start;\s*padding:30px;\s*\}', '.prescription * { font-family: "Trebuchet MS","Segoe UI",Arial,sans-serif; box-sizing:border-box; color:var(--ink); }', content)
content = re.sub(r'@media\(max-width:900px\)\{\s*body\{padding:0;background:#fff\}\s*', '@media(max-width:900px){ ', content)
content = re.sub(r'@media print\{\s*@page\{\s*size:A4;\s*margin:0;\s*\}\s*body\{\s*padding:0;\s*background:#fff;\s*\}', '@media print{ @page{ size:A4; margin:0; } body{ padding:0; background:#fff; }', content) # keep print body rule as it's isolated to print window anyway by the JS

# 2. Fix the wrapper div classes
old_div = '<div id="prescription-print-area" class="bg-white shadow-2xl border border-gray-200 max-w-3xl w-full mx-auto flex flex-col relative overflow-hidden aspect-[1/1.414] print:break-after-avoid print:aspect-auto print:w-full print:h-[297mm] print:overflow-hidden print:block print:absolute print:inset-0 print:m-0 print:p-0 print:border-none print:bg-white text-gray-900">'
new_div = '<div id="prescription-print-area" class="flex justify-center w-full mx-auto print:break-after-avoid print:block print:absolute print:inset-0 print:m-0 print:p-0 print:border-none print:bg-white text-gray-900">'
content = content.replace(old_div, new_div)

with open('resources/views/doctor/prescriptions/index.blade.php', 'w') as f:
    f.write(content)

print("Fixed CSS scoping and wrapper div")
