@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Historia Clínica Digital</h1>
        <div>
            <a href="{{ route('appointments.index') }}" class="btn btn-primary">
                <i class="bi bi-calendar-plus"></i> Nueva Cita
            </a>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Datos del Paciente</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-circle bg-light d-inline-flex justify-content-center align-items-center rounded-circle" style="width: 80px; height: 80px;">
                            <span class="h1 text-primary m-0">{{ substr($patient->nombres, 0, 1) }}</span>
                        </div>
                    </div>
                    <hr>
                    <p><strong>DNI:</strong> {{ $patient->dni }}</p>
                    <p><strong>Nombre Completo:</strong> {{ $patient->nombres }} {{ $patient->apellidos }}</p>
                    <p><strong>Celular:</strong> {{ $patient->celular ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $patient->email ?? '-' }}</p>
                    <p><strong>Dirección:</strong> {{ $patient->direccion ?? '-' }}</p>
                    
                    <div class="alert alert-warning mt-3">
                        <strong><i class="bi bi-exclamation-triangle"></i> Alergias:</strong><br>
                        {{ $patient->alergias ?? 'Ninguna registrada' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-primary">Historial de Tratamientos y Citas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tratamiento Realizado</th>
                                    <th>Estado</th>
                                    <th>Notas / Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Aquí usamos la relación correcta 'appointments' que arreglamos en el modelo --}}
                                @forelse($patient->appointments as $appointment)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $appointment->scheduled_at->format('d/m/Y') }}</span><br>
                                            <small class="text-muted">{{ $appointment->scheduled_at->format('H:i A') }}</small>
                                        </td>
                                        
                                        <td>
                                            @if($appointment->treatment)
                                                <span class="text-primary fw-bold">{{ $appointment->treatment->name }}</span>
                                                <br>
                                                <small class="text-muted">S/. {{ number_format($appointment->treatment->price, 2) }}</small>
                                            @else
                                                <span class="text-muted">Consulta General</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            @if($appointment->status == 'finished')
                                                <span class="badge bg-success">Finalizado</span>
                                            @elseif($appointment->status == 'scheduled')
                                                <span class="badge bg-primary">Programado</span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="badge bg-danger">Cancelado</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            <small>{{ $appointment->notes ?? $appointment->triage_notes ?? '-' }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-folder2-open h3"></i>
                                                <p>Este paciente aún no tiene historial clínico.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection