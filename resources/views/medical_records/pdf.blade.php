<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Medical Record - {{ $medical_record->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        h1, h2, h3 { text-align: center; }
        .content { margin: 20px; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h1>الملف الطبي للمريض: {{ $medical_record->patient->name }}</h1>

    <div class="content">
        <div class="section">
            <span class="label">تاريخ الزيارة:</span> {{ $medical_record->created_at->format('Y-m-d H:i') }}
        </div>

        <div class="section">
            <span class="label">الطبيب المعالج:</span> {{ $medical_record->doctor->name }}
        </div>

        <div class="section">
            <h3 class="label">التشخيص</h3>
            <p>{{ $medical_record->diagnosis }}</p>
        </div>

        <div class="section">
            <h3 class="label">الوصفة الطبية</h3>
            <p>{{ $medical_record->prescription ?: 'لا توجد وصفة طبية' }}</p>
        </div>

        <div class="section">
            <h3 class="label">التحاليل المطلوبة</h3>
            <p>{{ $medical_record->lab_tests_required ?: 'لا توجد تحاليل مطلوبة' }}</p>
        </div>
    </div>
</body>
</html>
