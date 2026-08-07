<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\SessionType;
use App\Models\SurgeryType;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(Request $request)
    {
        $tenantId = $request->user()->tenant_id;

        $sessionTypes = SessionType::where('tenant_id', $tenantId)->get();
        $surgeryTypes = SurgeryType::where('tenant_id', $tenantId)->get();

        $subSecretary = null;
        if ($request->user()->role === 'Secretary' && $request->user()->is_main_account) {
            $subSecretary = \App\Models\User::where('tenant_id', $tenantId)
                ->where('role', 'Secretary')
                ->where('is_main_account', false)
                ->first();
        }

        return view('settings.index', [
            'user' => $request->user(),
            'sessionTypes' => $sessionTypes,
            'surgeryTypes' => $surgeryTypes,
            'subSecretary' => $subSecretary,
        ]);
    }

    /**
     * Update the user's settings.
     */
    public function update(SettingsUpdateRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        $validated['has_sessions_system'] = $request->has('has_sessions_system');

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_path'] = $path;
        }

        $user->update($validated);

        return redirect()->route('settings.index')->with('success', __('تم تحديث الإعدادات بنجاح'));
    }

    /**
     * Reset the user's system usage timer.
     */
    public function resetUsage(Request $request)
    {
        $user = $request->user();
        $user->created_at = now();
        $user->save();

        return back()->with('success', __('تم إعادة ضبط العداد بنجاح'));
    }
}
