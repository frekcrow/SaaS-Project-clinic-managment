<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/patients/export', [PatientController::class, 'export'])->name('patients.export');
    Route::resource('patients', PatientController::class);

    Route::get('/patients/{patient}/medical-records', [MedicalRecordController::class, 'index'])->name('medical_records.index');
    Route::get('/patients/{patient}/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical_records.create');
    Route::post('/patients/{patient}/medical-records', [MedicalRecordController::class, 'store'])->name('medical_records.store');

    Route::get('/medical-records/{medical_record}/export-pdf', [MedicalRecordController::class, 'exportPdf'])->name('medical_records.exportPdf');
    Route::get('/medical-records/{medical_record}', [MedicalRecordController::class, 'show'])->name('medical_records.show');
    Route::put('/medical-records/{medical_record}', [MedicalRecordController::class, 'update'])->name('medical_records.update');
});

require __DIR__.'/auth.php';
