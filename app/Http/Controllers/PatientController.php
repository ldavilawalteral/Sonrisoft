<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $patient->load('appointments.treatment');
        return view('patients.show', compact('patient'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => [
                'required',
                'digits:8',
                Rule::unique('patients')->where(function ($query) {
            return $query->where('tenant_id', auth()->user()->tenant_id);
        }),
            ],
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'alergias' => 'nullable|string',
        ]);

        // tenant_id is automatically added by the BelongsToTenant trait
        Patient::create($request->all());

        return redirect()->route('patients.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'dni' => [
                'required',
                'digits:8',
                Rule::unique('patients')->ignore($patient->id)->where(function ($query) {
            return $query->where('tenant_id', auth()->user()->tenant_id);
        }),
            ],
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'alergias' => 'nullable|string',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')
            ->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Patient $patient)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Paciente eliminado correctamente.');
    }

    public function pendingTreatments(Patient $patient)
    {
        // Check if patient belongs to tenant (handled by implicit binding + global scope usually, 
        // but if global scope isn't on Patient yet (it IS, confirmed in previous steps), this is safe.)

        $treatments = $patient->treatments()
            ->where('status', 'pending')
            ->get(['id', 'description', 'tooth_number', 'cost']); // Select only needed fields

        return response()->json($treatments);
    }
}
