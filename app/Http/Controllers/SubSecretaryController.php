<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\User;

class SubSecretaryController extends Controller
{
    /**
     * Show the form for creating a new sub-secretary account.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        // Security Constraint: Only the "Main Secretary" can create/update a sub-account.
        if ($user->role !== 'Secretary' || !$user->is_main_account) {
            abort(403, 'Unauthorized action.');
        }

        // Find existing sub-secretary for this clinic/tenant
        $subSecretary = User::where('tenant_id', $user->tenant_id)
            ->where('role', 'Secretary')
            ->where('is_main_account', false)
            ->first();

        return view('settings.sub_secretary.create', compact('subSecretary'));
    }

    /**
     * Store or update the sub-secretary account.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Security Constraint: Only the "Main Secretary" can create/update a sub-account.
        if ($user->role !== 'Secretary' || !$user->is_main_account) {
            abort(403, 'Unauthorized action.');
        }

        // Find existing sub-secretary for this clinic/tenant
        $subSecretary = User::where('tenant_id', $user->tenant_id)
            ->where('role', 'Secretary')
            ->where('is_main_account', false)
            ->first();

        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email' . ($subSecretary ? ',' . $subSecretary->id : '')],
            'password' => $subSecretary ? ['nullable', Rules\Password::defaults()] : ['required', Rules\Password::defaults()],
        ];

        $validated = $request->validate($rules);

        if ($subSecretary) {
            $updateData = ['email' => $validated['email']];
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }
            $subSecretary->update($updateData);
            $message = 'تم تحديث حساب السكرتير الفرعي بنجاح.';
        } else {
            User::create([
                'name' => 'Sub Secretary', // Default name, can be changed if needed
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'tenant_id' => $user->tenant_id,
                'role' => 'Secretary',
                'clinic_code' => $user->clinic_code,
                'is_main_account' => false,
            ]);
            $message = 'تم إنشاء حساب السكرتير الفرعي بنجاح.';
        }

        return redirect()->route('settings.index')->with('success', $message);
    }
}
