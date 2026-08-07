<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DoctorSettingsUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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

        return view('doctor.settings.index', [
            'user' => $request->user(),
            'sessionTypes' => $sessionTypes,
            'surgeryTypes' => $surgeryTypes,
        ]);
    }

    /**
     * Update the user's settings.
     */
    public function update(DoctorSettingsUpdateRequest $request)
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

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('doctor.settings.index')->with('success', __('تم تحديث الإعدادات بنجاح'));
    }
}
