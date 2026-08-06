<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SessionTypeController;
use App\Http\Controllers\SurgeryTypeController;
use App\Http\Controllers\SurgeryController;
use App\Http\Controllers\DoctorPatientController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubSecretaryController;

Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::post('/settings/sub-secretary', [SubSecretaryController::class, 'store'])->name('settings.sub-secretary.store');

    Route::post('/settings/session-types', [SessionTypeController::class, 'store'])->name('settings.session-types.store');
    Route::delete('/settings/session-types/{id}', [SessionTypeController::class, 'destroy'])->name('settings.session-types.destroy');

    Route::post('/settings/surgery-types', [SurgeryTypeController::class, 'store'])->name('settings.surgery-types.store');
    Route::delete('/settings/surgery-types/{id}', [SurgeryTypeController::class, 'destroy'])->name('settings.surgery-types.destroy');
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/export-csv', [BillingController::class, 'exportCsv'])->name('billing.export_csv');
    Route::post('/billing/bulk-delete', [BillingController::class, 'bulkDelete'])->name('billing.bulk_delete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/patients/export-csv', [PatientController::class, 'exportCsv'])->name('patients.export_csv');
    Route::post('/patients/bulk-delete', [PatientController::class, 'bulkDelete'])->name('patients.bulk_delete');
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');

    Route::get('/api/global-search', [App\Http\Controllers\GlobalSearchController::class, 'search'])->name('api.global_search');
    Route::resource('patients', PatientController::class);

    Route::get('/appointments/export-csv', [AppointmentController::class, 'exportCsv'])->name('appointments.export_csv');
    Route::post('/appointments/bulk-delete', [AppointmentController::class, 'bulkDelete'])->name('appointments.bulk_delete');
    Route::get('/api/queue/current', [AppointmentController::class, 'currentQueue'])->name('api.queue.current');
    Route::resource('appointments', AppointmentController::class);
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update_status');

    Route::get('/surgeries/export-csv', [SurgeryController::class, 'exportCsv'])->name('surgeries.export_csv');
    Route::post('/surgeries/bulk-delete', [SurgeryController::class, 'bulkDelete'])->name('surgeries.bulk_delete');
    Route::get('/surgeries', [SurgeryController::class, 'index'])->name('surgeries.index');
    Route::post('/surgeries', [SurgeryController::class, 'store'])->name('surgeries.store');
    Route::patch('/surgeries/{surgery}/status', [SurgeryController::class, 'updateStatus'])->name('surgeries.update_status');

    // Doctor EMR routes
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/appointments', [App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/surgeries', [App\Http\Controllers\DoctorSurgeryController::class, 'index'])->name('surgeries.index');
        Route::put('/surgeries/{surgery}', [App\Http\Controllers\DoctorSurgeryController::class, 'update'])->name('surgeries.update');
        Route::get('/patients', [DoctorPatientController::class, 'index'])->name('patients.index');
        Route::get('/patients/{patient}', [DoctorPatientController::class, 'show'])->name('patients.show');
        Route::put('/patients/{patient}', [DoctorPatientController::class, 'update'])->name('patients.update');
        Route::post('/patients/{patient}/records', [DoctorPatientController::class, 'storeRecord'])->name('patients.records.store');
        Route::post('/patients/{patient}/images', [DoctorPatientController::class, 'uploadImage'])->name('patients.images.upload');
        Route::delete('/patients/{patient}/images/{image}', [DoctorPatientController::class, 'deleteImage'])->name('patients.images.destroy');

        Route::get('/billing', [App\Http\Controllers\DoctorBillingController::class, 'index'])->name('billing.index');

        Route::get('/medications', [App\Http\Controllers\MedicationController::class, 'index'])->name('medications.index');
        Route::post('/medications', [App\Http\Controllers\MedicationController::class, 'store'])->name('medications.store');
        Route::put('/medications/{medication}', [App\Http\Controllers\MedicationController::class, 'update'])->name('medications.update');
        Route::delete('/medications/{medication}', [App\Http\Controllers\MedicationController::class, 'destroy'])->name('medications.destroy');

        Route::get('/prescriptions', [App\Http\Controllers\Doctor\PrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::post('/prescriptions/settings', [App\Http\Controllers\Doctor\PrescriptionController::class, 'updateSettings'])->name('prescriptions.settings.update');

        // Settings
        Route::get('/settings', [App\Http\Controllers\Doctor\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Doctor\SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/session-types', [SessionTypeController::class, 'store'])->name('settings.session-types.store');
        Route::delete('/settings/session-types/{id}', [SessionTypeController::class, 'destroy'])->name('settings.session-types.destroy');
        Route::post('/settings/surgery-types', [SurgeryTypeController::class, 'store'])->name('settings.surgery-types.store');
        Route::delete('/settings/surgery-types/{id}', [SurgeryTypeController::class, 'destroy'])->name('settings.surgery-types.destroy');
    });

    // Notifications
    Route::get('/api/notifications/latest', [NotificationController::class, 'latest'])->name('api.notifications.latest');
    Route::get('/api/notifications', [NotificationController::class, 'index'])->name('api.notifications.index');
    Route::post('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('api.notifications.read');
    Route::post('/api/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('api.notifications.read_all');
});

require __DIR__.'/auth.php';
