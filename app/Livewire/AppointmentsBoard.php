<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Str;

class AppointmentsBoard extends Component
{
    // ── Nueva Cita: Búsqueda de Paciente ──────────────────────────
    public string $searchPatient  = '';
    public ?int   $patient_id     = null;
    public string $selectedName   = '';
    public bool   $showNewForm    = false;

    // Nueva Cita: Datos paciente nuevo
    public string $new_dni        = '';
    public string $new_nombres    = '';
    public string $new_apellidos  = '';
    public string $new_celular    = '';

    // Nueva Cita: Datos de la cita
    public ?int   $treatment_id   = null;
    public string $scheduled_at   = '';

    // ── Triage ────────────────────────────────────────────────────
    public $editingAppointmentId = null;
    public $bp = '', $temp = '', $pain_level = 0, $has_bleeding = false;
    public $systemic_diseases = '', $medications = '', $alergy = '', $reason = '';

    public $finishingAppointmentId = null;
    public $procedure_done = '', $prescription = '', $next_visit = '';

    // ── Búsqueda reactiva de pacientes ────────────────────────────
    public function getPatientResultsProperty()
    {
        if (strlen($this->searchPatient) < 2) {
            return collect();
        }
        $term = '%' . $this->searchPatient . '%';
        return Patient::where('tenant_id', auth()->user()->tenant_id)
            ->where(function($q) use ($term) {
                $q->where('nombres',   'like', $term)
                  ->orWhere('apellidos','like', $term)
                  ->orWhere('dni',      'like', $term);
            })
            ->limit(8)
            ->get();
    }

    public function selectPatient(int $id): void
    {
        $p = Patient::find($id);
        if (!$p) return;

        $this->patient_id    = $p->id;
        $this->selectedName  = $p->nombres . ' ' . $p->apellidos . ' (DNI: ' . $p->dni . ')';
        $this->searchPatient = '';
        $this->showNewForm   = false;
    }

    public function openNewPatientForm(): void
    {
        $this->patient_id   = null;
        $this->selectedName = '';
        $this->showNewForm  = true;
    }

    public function saveAppointment(): void
    {
        // Validación condicional según si es paciente nuevo o existente
        $rules = [
            'treatment_id' => 'required|exists:treatments,id',
            'scheduled_at' => 'required|date',
        ];

        if ($this->showNewForm && !$this->patient_id) {
            $rules['new_dni']      = 'required|string|max:20';
            $rules['new_nombres']  = 'required|string|max:120';
            $rules['new_apellidos']= 'required|string|max:120';
            $rules['new_celular']  = 'nullable|string|max:20';
        } else {
            $rules['patient_id']   = 'required|integer|exists:patients,id';
        }

        $this->validate($rules);

        // Verificar disponibilidad del horario
        if (Appointment::where('tenant_id', auth()->user()->tenant_id)
                       ->where('scheduled_at', $this->scheduled_at)
                       ->exists()) {
            $this->addError('scheduled_at', 'Ese horario ya está ocupado. Elige otra hora.');
            return;
        }

        // Crear o recuperar paciente si es nuevo
        if ($this->showNewForm && !$this->patient_id) {
            $patient = Patient::firstOrCreate(
                ['dni' => $this->new_dni, 'tenant_id' => auth()->user()->tenant_id],
                [
                    'nombres'   => $this->new_nombres,
                    'apellidos' => $this->new_apellidos,
                    'celular'   => $this->new_celular,
                    'tenant_id' => auth()->user()->tenant_id,
                ]
            );
            $this->patient_id = $patient->id;
        }

        Appointment::create([
            'patient_id'   => $this->patient_id,
            'treatment_id' => $this->treatment_id,
            'tenant_id'    => auth()->user()->tenant_id,
            'status'       => 'scheduled',
            'scheduled_at' => $this->scheduled_at,
            'symptoms'     => 'Agendado desde recepción',
        ]);

        // Reset del formulario
        $this->reset(['searchPatient','patient_id','selectedName','showNewForm',
                      'new_dni','new_nombres','new_apellidos','new_celular',
                      'treatment_id','scheduled_at']);

        $this->dispatch('close-modal', modalId: '#newAppointmentModal');
        $this->dispatch('appointment-saved');
    }

    public function resetAppointmentForm(): void
    {
        $this->reset(['searchPatient','patient_id','selectedName','showNewForm',
                      'new_dni','new_nombres','new_apellidos','new_celular',
                      'treatment_id','scheduled_at']);
        $this->resetErrorBag();
    }

    // ── Render ────────────────────────────────────────────────────
    public function render()
    {
        $user    = auth()->user();
        $isDoctor = Str::startsWith($user->name, 'Dr.') || Str::contains($user->name, 'Doctor');

        $appointments = Appointment::whereDate('scheduled_at', today())
            ->where('tenant_id', $user->tenant_id)
            ->has('patient')
            ->with(['patient', 'treatment'])
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $pendingConfirmations = [];
        if ($isDoctor) {
            $pendingConfirmations = Appointment::where('status', 'pending_doctor_confirmation')
                ->where('tenant_id', $user->tenant_id)
                ->has('patient')
                ->with(['patient', 'treatment'])
                ->get();
        }

        return view('livewire.appointments-board', [
            'appointments'         => $appointments,
            'pendingConfirmations' => $pendingConfirmations,
            'treatments'           => Treatment::all(),
        ]);
    }

    public function openTriage($id)
    {
        $this->reset(['bp', 'temp', 'pain_level', 'has_bleeding', 'systemic_diseases', 'medications', 'reason']);
        $this->editingAppointmentId = $id;
        $app = Appointment::find($id);
        if ($app && $app->patient) {
            $this->alergy = $app->patient->alergias ?? ''; 
        }
    }

    public function saveTriage()
    {
        $this->validate(['reason' => 'required|min:3']);

        $app = Appointment::find($this->editingAppointmentId);
        if ($app) {
            $app->update([
                'vital_signs' => [
                    'blood_pressure' => $this->bp, 'temperature' => $this->temp,
                    'pain_level' => $this->pain_level, 'bleeding' => $this->has_bleeding,
                    'systemic' => $this->systemic_diseases, 'medications' => $this->medications
                ],
                'triage_alergy' => $this->alergy,
                'triage_notes' => $this->reason,
                'status' => 'pending_doctor_confirmation'
            ]);
            $this->dispatch('close-modal', modalId: '#triageModal' . $this->editingAppointmentId);
        }
    }

    public function acceptPatient($id)
    {
        $app = Appointment::find($id);
        if ($app) $app->update(['status' => 'in_process']);
    }

    public function openFinish($id)
    {
        $this->finishingAppointmentId = $id;
        $app = Appointment::find($id);
        if ($app) {
            $this->procedure_done = $app->treatment->name ?? 'Tratamiento'; 
            $this->prescription = ''; $this->next_visit = '';
        }
    }

    public function saveFinish()
    {
        $this->validate(['procedure_done' => 'required']);
        $app = Appointment::find($this->finishingAppointmentId);
        
        if ($app) {
            $clinicalNote = "Procedimiento: " . $this->procedure_done . "\nReceta: " . $this->prescription . "\nPróxima: " . $this->next_visit;
            $app->update(['status' => 'finished', 'notes' => $clinicalNote]);

            // REGISTRAR PAGO (Corregido: Agregamos treatment_id)
            $exists = Payment::where('appointment_id', $app->id)->exists();
            if (!$exists) {
                Payment::create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'patient_id' => $app->patient_id,
                    'appointment_id' => $app->id,
                    'treatment_id' => $app->treatment_id, // <--- ESTO FALTABA
                    'amount' => $app->treatment->price ?? 0,
                    'method' => 'efectivo',
                    'payment_date' => now(),
                    'notes' => 'Pago automático cita #' . $app->id
                ]);
            }
            $this->dispatch('close-modal', modalId: '#finishModal' . $this->finishingAppointmentId);
        }
    }
}