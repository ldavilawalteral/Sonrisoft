<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Patient;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'tooth_number' => 'required|integer|min:11|max:85',
            'description' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed',
        ]);

        $validated['tenant_id'] = auth()->user()->tenant_id;

        $patient->treatments()->create($validated);

        return back()->with('success', 'Tratamiento agregado correctamente.');
    }

    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'tooth_number' => 'required|integer|min:11|max:85',
            'description' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed',
        ]);

        $treatment->update($validated);

        return back()->with('success', 'Tratamiento actualizado correctamente.');
    }

    public function destroy(Treatment $treatment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $treatment->delete();

        return back()->with('success', 'Tratamiento eliminado correctamente.');
    }
}
