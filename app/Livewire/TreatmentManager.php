<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Treatment;

class TreatmentManager extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $description, $price, $duration;
    public $is_active = true;
    public $treatmentId;

    // Reset pagination when search changes
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        $treatments = Treatment::where('tenant_id', $user->tenant_id)
            ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.treatment-manager', [
            'treatments' => $treatments
        ]);
    }

    public function create()
    {
        $this->resetInput();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        try {
            Log::info('Attempting to create treatment', [
                'tenant_id' => Auth::user()->tenant_id,
                'data' => [
                    'name' => $this->name,
                    'price' => $this->price
                ]
            ]);

            Treatment::create([
                'tenant_id' => Auth::user()->tenant_id,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'duration' => $this->duration,
                'is_active' => $this->is_active,
            ]);

            $this->dispatch('close-modal');
            $this->dispatch('swal', [
                'title' => 'Éxito',
                'text' => 'Tratamiento creado correctamente.',
                'icon' => 'success'
            ]);

            $this->resetInput();

        }
        catch (\Exception $e) {
            Log::error('Error creating treatment: ' . $e->getMessage());
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => 'No se pudo crear: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function edit($id)
    {
        $treatment = Treatment::where('tenant_id', Auth::user()->tenant_id)->findOrFail($id);

        $this->treatmentId = $treatment->id;
        $this->name = $treatment->name;
        $this->description = $treatment->description;
        $this->price = $treatment->price;
        $this->duration = $treatment->duration;
        $this->is_active = (bool)$treatment->is_active;

        $this->dispatch('open-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        try {
            $treatment = Treatment::where('tenant_id', Auth::user()->tenant_id)->findOrFail($this->treatmentId);

            $treatment->update([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'duration' => $this->duration,
                'is_active' => $this->is_active,
            ]);

            $this->dispatch('close-modal');
            $this->dispatch('swal', [
                'title' => 'Actualizado',
                'text' => 'Tratamiento actualizado correctamente.',
                'icon' => 'success'
            ]);

            $this->resetInput();
        }
        catch (\Exception $e) {
            Log::error('Error updating treatment: ' . $e->getMessage());
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => 'No se pudo actualizar: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function toggleStatus($id)
    {
        $treatment = Treatment::where('tenant_id', Auth::user()->tenant_id)->findOrFail($id);
        $treatment->is_active = !$treatment->is_active;
        $treatment->save();

        $status = $treatment->is_active ? 'activado' : 'desactivado';

        $this->dispatch('swal', [
            'title' => 'Estado Cambiado',
            'text' => "El tratamiento ha sido $status.",
            'icon' => 'info'
        ]);
    }

    public function importDefaults()
    {
        $count = 0;
        // Find treatments that have no tenant_id (System Defaults)
        $defaults = Treatment::whereNull('tenant_id')->get();

        foreach ($defaults as $def) {
            // Check if we already have a treatment with this name
            $exists = Treatment::where('tenant_id', Auth::user()->tenant_id)
                ->where('name', $def->name)
                ->exists();

            if (!$exists) {
                Treatment::create([
                    'tenant_id' => Auth::user()->tenant_id,
                    'name' => $def->name,
                    'description' => $def->description ?? 'Importado del sistema',
                    'price' => $def->price,
                    'duration' => $def->duration ?? 30,
                    'is_active' => true,
                ]);
                $count++;
            }
        }

        $this->dispatch('swal', [
            'title' => 'Importación Completada',
            'text' => "Se han importado $count tratamientos del sistema.",
            'icon' => 'success'
        ]);

        $this->render(); // Refresh list
    }

    private function resetInput()
    {
        $this->name = null;
        $this->description = null;
        $this->price = null;
        $this->duration = null;
        $this->is_active = true;
        $this->treatmentId = null;
        $this->resetErrorBag();
    }
}
