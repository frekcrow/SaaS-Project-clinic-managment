<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use App\Services\NotificationSyncService;
use Illuminate\Http\Request;

class SystemNotificationController extends Controller
{
    protected $syncService;

    public function __construct(NotificationSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function index()
    {
        $this->syncService->sync();

        $notifications = SystemNotification::orderBy('created_at', 'desc')->get();

        return view('tenant.notifications.index', compact('notifications'));
    }
}
