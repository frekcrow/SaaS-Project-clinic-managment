<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Tenant;
use App\Services\LicenseService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $clinicCodeRules = ['required', 'string', 'max:255'];
        if ($request->role === 'Doctor') {
            $clinicCodeRules[] = 'unique:users,clinic_code';
        } elseif ($request->role === 'Secretary') {
            $clinicCodeRules[] = 'exists:users,clinic_code';
        }

        $request->validate([
            'role' => ['required', 'string', 'in:Doctor,Secretary'],
            'clinic_code' => $clinicCodeRules,
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'gender' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {
            $tenantId = null;

            if ($request->role === 'Doctor') {
                if (User::where('clinic_code', $request->clinic_code)->exists()) {
                    throw ValidationException::withMessages([
                        'clinic_code' => __('This clinic code is already taken.'),
                    ]);
                }

                $tenant = Tenant::create([
                    'name' => $request->clinic_code,
                    'subscription_plan' => null,
                    'subscription_expires_at' => null,
                    'domain' => Str::slug($request->clinic_code) . '-' . Str::random(5),
                    'is_active' => false,
                ]);
                $tenantId = $tenant->id;
            } elseif ($request->role === 'Secretary') {
                $doctor = User::where('clinic_code', $request->clinic_code)
                              ->where('role', 'Doctor')
                              ->first();

                if (!$doctor) {
                    throw ValidationException::withMessages([
                        'clinic_code' => __('Invalid clinic code. No doctor found with this code.'),
                    ]);
                }

                $tenantId = $doctor->tenant_id;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
                'tenant_id' => $tenantId,
                'role' => $request->role,
                'clinic_code' => $request->clinic_code,
            ]);

            return $user;
        });

        if ($user->role === 'Doctor') {
            try {
                $botApiUrl = config('services.bot.api_url');
                if ($botApiUrl) {
                    Http::post($botApiUrl, [
                        'tenant_id' => $user->tenant_id,
                        'clinic_name' => $user->clinic_code,
                        'doctor_name' => $user->name,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to notify Python API of new registration: ' . $e->getMessage());
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
