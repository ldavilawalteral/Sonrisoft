<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments for today.
     */
    public function index()
    {
    // Recuperamos los tratamientos para el Modal de "Nueva Cita"
    $treatments = \App\Models\Treatment::all();
    
    // Retornamos la vista pasando esa variable
    return view('appointments.index', compact('treatments'));
    }
    /**
     * Agile Appointment Creation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'treatment_id' => 'required|exists:treatments,id',
            'scheduled_at' => 'required|date',
        ]);

        // 1. Check Availability
        $exists = Appointment::where('scheduled_at', $request->scheduled_at)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['scheduled_at' => 'Horario ocupado. Por favor elija otra hora.']);
        }

        // 2. Find or Create Patient
        // Split name into Nombres y Apellidos roughly for legacy model support
        $parts = explode(' ', $request->name, 2);
        $nombres = $parts[0];
        $apellidos = $parts[1] ?? '';

        $patient = \App\Models\Patient::firstOrCreate(
        ['dni' => $request->dni],
        [
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'celular' => $request->phone,
            'tenant_id' => 1, // Default
        ]
        );

        // If patient existed but name/phone is updated, we might want to update it, 
        // but for safety in "firstOrCreate" logic we usually just use existing. 
        // For agile, if we want to force update name:
        // $patient->update(['name' => $request->name, 'phone' => $request->phone]);

        // 3. Create Appointment
        Appointment::create([
            'patient_id' => $patient->id,
            'treatment_id' => $request->treatment_id,
            'tenant_id' => auth()->user()->tenant_id,
            'status' => 'scheduled',
            'scheduled_at' => $request->scheduled_at,
            'symptoms' => 'Agendado desde recepción',
        ]);

        return redirect()->back()->with('success', 'Cita agendada correctamente.');
    }

    /**
     * Mark appointment as Waiting (Patient arrived).
     */
    public function checkIn($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status === 'scheduled') {
            $appointment->update(['status' => 'waiting']);
        }

        return redirect()->back()->with('success', 'Paciente registrado en recepción (Waiting).');
    }

    /**
     * Send patient to Triage (Nurse station).
     */
    public function sendToTriage($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status === 'waiting') {
            $appointment->update(['status' => 'triage']);
        }

        return redirect()->back()->with('success', 'Paciente enviado a Triaje.');
    }

    /**
     * Store vital signs and mark ready for Doctor.
     */
    /**
     * Store vital signs and mark ready for Doctor.
     */
    public function updateTriage(Request $request, $id)
    {
        $request->validate([
            'vital_signs' => 'required|array',
            'triage_alergy' => 'nullable|string',
            'triage_pain_level' => 'nullable|integer|min:0|max:10',
            'triage_notes' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($id);

        if ($appointment->status === 'triage') {
            $appointment->update([
                'vital_signs' => $request->vital_signs,
                'triage_alergy' => $request->triage_alergy,
                'triage_pain_level' => $request->triage_pain_level,
                'triage_notes' => $request->triage_notes,
                'status' => 'doctor' // Listo para el odontólogo
            ]);
        }

        return redirect()->back()->with('success', 'Triaje completado. Paciente listo para el médico.');
    }

    /**
     * Start medical attention (Patient enters office).
     */
    public function startAttention($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->status === 'doctor') {
            $appointment->update(['status' => 'in_process']);
        }

        return redirect()->back()->with('success', 'Atención iniciada.');
    }

    /**
     * Finish the appointment.
     */
    public function finishAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Optional: Save final notes here if passed in request
        if ($request->has('notes')) {
            $appointment->update(['notes' => $request->notes]);
        }

        $appointment->update(['status' => 'finished']);

        return redirect()->back()->with('success', 'Cita finalizada correctamente.');
    }
}
