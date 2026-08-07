<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurgeryType;

class SurgeryTypeController extends Controller
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

        SurgeryType::create($validated);

        return back()->with('success', __('تمت إضافة نوع العملية بنجاح'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $surgeryType = SurgeryType::findOrFail($id);

        abort_if($surgeryType->tenant_id !== $request->user()->tenant_id, 403);

        $surgeryType->delete();

        return back()->with('success', __('تم حذف نوع العملية بنجاح'));
    }
}
