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
     * Update the user's profile settings.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'clinic_name' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk(config('filesystems.default'))->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', config('filesystems.default'));
            $validated['avatar_path'] = $path;
        }

        unset($validated['avatar']);

        $updateData = [
            'name' => array_key_exists('name', $validated) ? $validated['name'] : $user->name,
            'email' => array_key_exists('email', $validated) ? $validated['email'] : $user->email,
            'clinic_name' => array_key_exists('clinic_name', $validated) ? $validated['clinic_name'] : $user->clinic_name,
            'bio' => array_key_exists('bio', $validated) ? $validated['bio'] : $user->bio,
        ];

        if (isset($validated['avatar_path'])) {
            $updateData['avatar_path'] = $validated['avatar_path'];
        }

        if ($user->email !== $updateData['email']) {
            $user->email_verified_at = null;
        }

        $user->update($updateData);

        if (array_key_exists('clinic_name', $validated)) {
            if ($user->tenant) {
                $user->tenant->update(['name' => $validated['clinic_name']]);
            }
        }

        return redirect()->back()->with('success', __('تم تحديث الملف الشخصي بنجاح'));
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
                Storage::disk(config('filesystems.default'))->delete($user->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', config('filesystems.default'));
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
