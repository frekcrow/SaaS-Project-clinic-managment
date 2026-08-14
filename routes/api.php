<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TenantSubscriptionController;
use App\Http\Middleware\VerifyApiSecret;

Route::post('/tenant/update-subscription', [TenantSubscriptionController::class, 'update'])
    ->middleware(VerifyApiSecret::class);
