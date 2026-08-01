<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionType;

class SessionTypeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['tenant_id'] = $request->user()->tenant_id;

        SessionType::create($validated);

        return back()->with('success', 'تمت إضافة نوع الجلسة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $sessionType = SessionType::findOrFail($id);

        abort_if($sessionType->tenant_id !== $request->user()->tenant_id, 403);

        $sessionType->delete();

        return back()->with('success', 'تم حذف نوع الجلسة بنجاح');
    }
}
