<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Tratamientos</h5>
            <div>
                <button type="button" wire:click="importDefaults" wire:confirm="¿Desea importar los tratamientos base del sistema? Esto no duplicará los que tengan el mismo nombre." class="btn btn-outline-secondary btn-sm me-2">
                    <i class="bi bi-download"></i> Importar Base
                </button>
                <button type="button" wire:click="create" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#treatmentModal">
                    <i class="bi bi-plus-lg"></i> Nuevo Tratamiento
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <input wire:model.live.debounce.300ms="search" type="text" class="form-control" placeholder="Buscar por nombre o descripción...">
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Duración (min)</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($treatments as $treatment)
                            <tr>
                                <td>{{ $treatment->name }}</td>
                                <td>{{ Str::limit($treatment->description, 50) }}</td>
                                <td>${{ number_format($treatment->price, 2) }}</td>
                                <td>{{ $treatment->duration }} min</td>
                                <td>
                                    <span class="badge {{ $treatment->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $treatment->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button wire:click="toggleStatus({{ $treatment->id }})" class="btn btn-sm btn-outline-secondary me-1" title="{{ $treatment->is_active ? 'Desactivar' : 'Activar' }}">
                                        <i class="bi {{ $treatment->is_active ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                    </button>
                                    <button wire:click="edit({{ $treatment->id }})" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#treatmentModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">No se encontraron tratamientos.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $treatments->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="treatmentModal" tabindex="-1" aria-labelledby="treatmentModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="treatmentModalLabel">
                        {{ $treatmentId ? 'Editar Tratamiento' : 'Nuevo Tratamiento' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="{{ $treatmentId ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input wire:model="name" type="text" class="form-control" id="name">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea wire:model="description" class="form-control" id="description" rows="3"></textarea>
                            @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input wire:model="price" type="number" step="0.01" class="form-control" id="price">
                                </div>
                                @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label">Duración (minutos)</label>
                                <input wire:model="duration" type="number" class="form-control" id="duration">
                                @error('duration') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input wire:model="is_active" type="checkbox" class="form-check-input" id="is_active">
                            <label class="form-check-label" for="is_active">Activo</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('close-modal', () => {
            const modalEl = document.getElementById('treatmentModal');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                } else {
                    // Fallback using click if instance not found specific to livewire updates
                    const closeBtn = modalEl.querySelector('.btn-close');
                    if (closeBtn) closeBtn.click();
                }
            }
        });

        $wire.on('swal', (event) => {
            const data = event[0] || event;
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    @endscript
</div>
