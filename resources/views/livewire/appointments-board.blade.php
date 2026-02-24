<div>
    {{-- =====================================================================
         MODAL: NUEVA CITA — Buscador de pacientes en tiempo real (Livewire 3)
    ===================================================================== --}}
    <div class="modal fade" id="newAppointmentModal" tabindex="-1" wire:ignore.self data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-calendar-plus me-2"></i>Nueva Cita
                    </h5>
                    <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            wire:click="resetAppointmentForm"></button>
                </div>

                <div class="modal-body">

                    {{-- ── PASO 1: BUSCADOR ─────────────────────────────── --}}
                    <label class="form-label fw-bold mb-1">
                        <i class="fa-solid fa-magnifying-glass me-1 text-primary"></i>
                        Buscar Paciente existente (nombre, apellido o DNI)
                    </label>

                    <input type="text"
                           wire:model.live.debounce.300ms="searchPatient"
                           class="form-control @error('patient_id') is-invalid @enderror"
                           placeholder="Ej: Juan Pérez  ó  12345678…"
                           autocomplete="off">
                    @error('patient_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    {{-- ── RESULTADOS DE BÚSQUEDA ───────────────────────── --}}
                    @if(strlen($searchPatient) >= 2)
                        <div class="border rounded mt-1 shadow-sm" style="max-height:220px;overflow-y:auto;">
                            @forelse($this->patientResults as $p)
                                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom"
                                     style="background:#fff;" onmouseover="this.style.background='#f0f7ff'" onmouseout="this.style.background='#fff'">
                                    <div>
                                        <span class="fw-semibold">{{ $p->nombres }} {{ $p->apellidos }}</span>
                                        <small class="text-muted ms-2">DNI: {{ $p->dni }}</small>
                                        @if($p->celular)
                                            <small class="text-muted ms-2">
                                                <i class="fa-solid fa-phone fa-xs"></i> {{ $p->celular }}
                                            </small>
                                        @endif
                                    </div>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary flex-shrink-0"
                                            wire:click="selectPatient({{ $p->id }})">
                                        <i class="fa-solid fa-check me-1"></i>Seleccionar
                                    </button>
                                </div>
                            @empty
                                <div class="px-3 py-3 text-center">
                                    <p class="text-muted mb-2 small">
                                        No se encontró <strong>"{{ $searchPatient }}"</strong> en el sistema.
                                    </p>
                                    <button type="button"
                                            class="btn btn-success btn-sm"
                                            wire:click="openNewPatientForm">
                                        <i class="fa-solid fa-user-plus me-1"></i>+ Registrar Nuevo Paciente
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    @endif

                    {{-- ── PACIENTE SELECCIONADO (badge) ────────────────── --}}
                    @if($patient_id && !$showNewForm)
                        <div class="alert alert-success py-2 d-flex align-items-center justify-content-between mt-3 mb-0">
                            <span>
                                <i class="fa-solid fa-circle-check me-2"></i>
                                <strong>Paciente:</strong> {{ $selectedName }}
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                    wire:click="$set('patient_id', null)">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    @endif

                    {{-- ── FORMULARIO: NUEVO PACIENTE ───────────────────── --}}
                    @if($showNewForm && !$patient_id)
                        <div class="card border-success mt-3">
                            <div class="card-header bg-success bg-opacity-10 text-success fw-bold py-2 small">
                                <i class="fa-solid fa-user-plus me-2"></i>Datos del Nuevo Paciente
                            </div>
                            <div class="card-body pb-2 pt-3">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">DNI *</label>
                                        <input type="text" wire:model="new_dni"
                                               class="form-control form-control-sm @error('new_dni') is-invalid @enderror"
                                               placeholder="12345678">
                                        @error('new_dni')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Nombres *</label>
                                        <input type="text" wire:model="new_nombres"
                                               class="form-control form-control-sm @error('new_nombres') is-invalid @enderror">
                                        @error('new_nombres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Apellidos *</label>
                                        <input type="text" wire:model="new_apellidos"
                                               class="form-control form-control-sm @error('new_apellidos') is-invalid @enderror">
                                        @error('new_apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Celular</label>
                                        <input type="text" wire:model="new_celular"
                                               class="form-control form-control-sm"
                                               placeholder="999 999 999">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <hr class="my-3">

                    {{-- ── DATOS DE LA CITA ─────────────────────────────── --}}
                    <h6 class="text-muted fw-bold mb-3">
                        <i class="fa-solid fa-tooth me-2"></i>Datos de la Cita
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Servicio / Tratamiento *</label>
                            <select wire:model="treatment_id"
                                    class="form-select form-select-sm @error('treatment_id') is-invalid @enderror">
                                <option value="">Seleccione un servicio…</option>
                                @foreach($treatments as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }} — S/ {{ $t->price }}</option>
                                @endforeach
                            </select>
                            @error('treatment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Fecha y Hora *</label>
                            <input type="datetime-local"
                                   wire:model="scheduled_at"
                                   class="form-control form-control-sm @error('scheduled_at') is-invalid @enderror">
                            @error('scheduled_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>{{-- /modal-body --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal"
                            wire:click="resetAppointmentForm">Cancelar</button>
                    <button type="button"
                            class="btn btn-primary btn-sm"
                            wire:click="saveAppointment"
                            wire:loading.attr="disabled"
                            wire:target="saveAppointment">
                        <span wire:loading wire:target="saveAppointment"
                              class="spinner-border spinner-border-sm me-1"></span>
                        <i class="fa-solid fa-check me-1"></i>Agendar Cita
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- =====================================================================
         KANBAN BOARD
    ===================================================================== --}}
    <div wire:poll.5s>
        <div class="row g-3">

            {{-- SALA DE ESPERA --}}
            <div class="col-12 col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="background-color:#f8f9fa;">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <h5 class="card-title mb-0 d-flex align-items-center text-secondary">
                            <i class="fa-regular fa-calendar me-2"></i> Sala de Espera
                        </h5>
                    </div>
                    <div class="card-body p-2" style="max-height:70vh;overflow-y:auto;">
                        @forelse($appointments->where('status', 'scheduled') as $app)
                            <div class="card mb-2 border-start border-4 border-secondary shadow-sm">
                                <div class="card-body p-2">
                                    <h6 class="fw-bold mb-1">
                                        {{ $app->patient?->nombres ?? 'Desconocido' }}
                                        {{ $app->patient?->apellidos }}
                                    </h6>
                                    <small class="text-info fw-bold">
                                        <i class="fa-solid fa-tooth"></i> {{ $app->treatment->name }}
                                    </small>
                                    <button class="btn btn-primary btn-sm w-100 mt-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#triageModal{{ $app->id }}"
                                            wire:click="openTriage({{ $app->id }})">
                                        <i class="fa-solid fa-clipboard-list"></i> Anamnesis
                                    </button>
                                </div>
                            </div>

                            {{-- Triage Modal --}}
                            <div class="modal fade" id="triageModal{{ $app->id }}"
                                 tabindex="-1" wire:ignore.self data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Anamnesis</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <form wire:submit.prevent="saveTriage">
                                            <div class="modal-body text-start">
                                                <div class="alert alert-danger py-2 mb-3">
                                                    <label class="small fw-bold text-danger">⚠️ ALERGIAS</label>
                                                    <input type="text" wire:model="alergy"
                                                           class="form-control form-control-sm border-danger fw-bold text-danger">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small fw-bold">Queja Principal</label>
                                                    <input type="text" wire:model="reason"
                                                           class="form-control form-control-sm" required>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label class="small fw-bold">Dolor (0-10)</label>
                                                        <select wire:model="pain_level" class="form-select form-select-sm">
                                                            <option value="0">0 - Nada</option>
                                                            <option value="5">5 - Moderado</option>
                                                            <option value="10">10 - Intenso</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 pt-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                   wire:model="has_bleeding" id="b{{$app->id}}">
                                                            <label class="form-check-label small text-danger fw-bold"
                                                                   for="b{{$app->id}}">Sangrado</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer py-1">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted mt-5 py-4 small">Sin citas hoy</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- CONFIRMACIÓN DR --}}
            <div class="col-12 col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm bg-light">
                    <div class="card-header bg-warning text-dark py-3 border-0">
                        <h5 class="card-title mb-0">
                            <i class="fa-solid fa-user-doctor me-2"></i> Confirmación
                        </h5>
                    </div>
                    <div class="card-body p-2">
                        @forelse($appointments->where('status', 'pending_doctor_confirmation') as $app)
                            <div class="card mb-2 border-start border-4 border-warning shadow-sm">
                                <div class="card-body p-2">
                                    <h6 class="fw-bold mb-1">{{ $app->patient?->nombres ?? 'Desconocido' }}</h6>
                                    <span class="badge bg-warning text-dark">Esperando Dr...</span>
                                    <div class="mt-2 small text-muted">Queja: {{ $app->triage_notes }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted mt-5 py-4 small">Vacío</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- EN SILLÓN --}}
            <div class="col-12 col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm" style="background-color:#e0f7fa;">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0 text-info">
                            <i class="fa-solid fa-chair me-2"></i> En Sillón
                        </h5>
                    </div>
                    <div class="card-body p-2">
                        @forelse($appointments->where('status', 'in_process') as $app)
                            <div class="card mb-2 border-start border-4 border-success shadow-sm">
                                <div class="card-body p-2">
                                    <h6 class="fw-bold mb-1">{{ $app->patient?->nombres ?? 'Desconocido' }}</h6>
                                    <div class="bg-white p-2 rounded border mb-2 small">
                                        <strong>Tx:</strong> {{ $app->treatment->name }}
                                        @if(($app->vital_signs['pain_level'] ?? 0) > 0)
                                            <span class="badge bg-danger">Dolor</span>
                                        @endif
                                    </div>
                                    <button class="btn btn-success btn-sm w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#finishModal{{ $app->id }}"
                                            wire:click="openFinish({{ $app->id }})">
                                        <i class="fa-solid fa-file-prescription"></i> Finalizar
                                    </button>
                                </div>
                            </div>

                            {{-- Finish Modal --}}
                            <div class="modal fade" id="finishModal{{ $app->id }}"
                                 tabindex="-1" wire:ignore.self data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Cierre Clínico</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <form wire:submit.prevent="saveFinish">
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label class="fw-bold small">Procedimiento</label>
                                                    <input type="text" wire:model="procedure_done"
                                                           class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fw-bold small">Receta</label>
                                                    <textarea wire:model="prescription"
                                                              class="form-control" rows="3"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fw-bold small">Próxima Cita</label>
                                                    <input type="text" wire:model="next_visit"
                                                           class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success w-100">
                                                    Guardar y Cobrar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted mt-5 py-4 small">Libre</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ATENDIDOS --}}
            <div class="col-12 col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm bg-light">
                    <div class="card-header bg-dark text-white fw-bold text-center py-3">Atendidos</div>
                    <div class="card-body p-2">
                        @foreach($appointments->where('status', 'finished') as $app)
                            <div class="card mb-2 shadow-sm opacity-75">
                                <div class="card-body p-2">
                                    <h6 class="fw-bold mb-0 text-decoration-line-through text-muted">
                                        {{ $app->patient?->nombres ?? 'Desconocido' }}
                                    </h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>{{-- /row --}}

        <div id="pending-confirmations-data"
             data-pending='@json($pendingConfirmations)'
             style="display:none;"></div>
    </div>{{-- /wire:poll --}}

    {{-- SweetAlert2 cargado una sola vez por Livewire --}}
    @assets
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endassets

    @script
    <script>
        document.addEventListener('livewire:initialized', () => {

            Livewire.on('close-modal', (event) => {
                const modalEl = document.querySelector(event.modalId);
                if (modalEl) {
                    const instance = bootstrap.Modal.getInstance(modalEl);
                    if (instance) instance.hide();
                    else {
                        const btn = modalEl.querySelector('[data-bs-dismiss="modal"]');
                        if (btn) btn.click();
                    }
                }
                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style = '';
                }, 300);
            });

            Livewire.on('appointment-saved', () => {
                const toast = document.createElement('div');
                toast.className = 'position-fixed top-0 end-0 m-3 alert alert-success shadow-lg d-flex align-items-center gap-2';
                toast.style.zIndex = 9999;
                toast.textContent = '✓ ¡Cita agendada! El paciente aparecerá en Sala de Espera.';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3500);
            });

            Livewire.hook('morph.updated', () => checkAlerts());
            setTimeout(() => checkAlerts(), 500);

            function checkAlerts() {
                const dataDiv = document.getElementById('pending-confirmations-data');
                if (!dataDiv) return;
                let pending = [];
                try { pending = JSON.parse(dataDiv.getAttribute('data-pending')); } catch(e) {}
                if (pending && pending.length > 0) {
                    const app = pending[0];
                    if (typeof Swal !== 'undefined' && !Swal.isVisible()) {
                        const nombre = app.patient?.nombres ?? 'Paciente';
                        const queja  = app.triage_notes ?? '';
                        Swal.fire({
                            title: '¡Paciente Listo!',
                            text: nombre + ' — Queja: ' + queja,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'INGRESAR',
                            confirmButtonColor: '#198754'
                        }).then((res) => {
                            if (res.isConfirmed) $wire.acceptPatient(app.id);
                        });
                    }
                }
            }
        });
    </script>
    @endscript
</div>