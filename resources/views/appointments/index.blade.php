@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fa-regular fa-calendar-check me-2 text-primary"></i> Control de Citas - {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </h1>
                <p class="text-muted small mb-0">Gestione el flujo de pacientes del día en tiempo real.</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
                <i class="fa-solid fa-plus me-1"></i> Nueva Cita
            </button>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- El modal de Nueva Cita ahora lo renderiza el componente Livewire (appointments-board)
         con buscador de pacientes en tiempo real. El botón de arriba sigue apuntando a #newAppointmentModal. --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Componente Livewire del Tablero --}}
    @livewire('appointments-board')

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('close-modal', (event) => {
            // Busca el modal por el ID que enviamos y lo cierra
            const modalId = event.modalId;
            const modalElem = document.getElementById(modalId);
            if (modalElem) {
                const modalInstance = bootstrap.Modal.getInstance(modalElem) || new bootstrap.Modal(modalElem);
                modalInstance.hide();

                // Limpieza forzada del fondo oscuro (backdrop) si se queda pegado
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';
            }
        });
    });
</script>
@endsection