<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

// ─────────────────────────────────────────────────────────────
//  MERCADO PAGO — Rutas públicas (sin auth)
// ─────────────────────────────────────────────────────────────
Route::post('/checkout/create', [PaymentController::class, 'createPayment'])
    ->name('payment.create');

// Callbacks de retorno desde la pasarela de Mercado Pago
Route::get('/checkout/success', [PaymentController::class, 'paymentSuccess'])
    ->name('payment.success');
Route::get('/checkout/failure', [PaymentController::class, 'paymentFailure'])
    ->name('payment.failure');
Route::get('/checkout/pending', [PaymentController::class, 'paymentPending'])
    ->name('payment.pending');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('patients', PatientController::class);
    Route::get('patients/{patient}/treatments/pending', [App\Http\Controllers\PatientController::class , 'pendingTreatments'])->name('patients.treatments.pending');

    // Ruta principal de Tratamientos (CRUD Livewire)
    Route::get('/tratamientos', function () {
            return view('treatments.index');
        }
        )->name('treatments.index');

        Route::resource('products', ProductController::class)->middleware('can:admin-only');

        // Treatments routes
        Route::post('patients/{patient}/treatments', [App\Http\Controllers\TreatmentController::class , 'store'])->name('treatments.store');
        Route::put('treatments/{treatment}', [App\Http\Controllers\TreatmentController::class , 'update'])->name('treatments.update');
        Route::delete('treatments/{treatment}', [App\Http\Controllers\TreatmentController::class , 'destroy'])->name('treatments.destroy');

        // Payments routes
        // Payments routes
        Route::post('treatments/{treatment}/payments', [App\Http\Controllers\PaymentController::class , 'store'])->name('treatments.payments.store');

        // Staff routes
        Route::resource('staff', App\Http\Controllers\StaffController::class)->only(['index', 'store', 'destroy'])->middleware('can:admin-only');

        // Appointments routes
        Route::get('appointments/today', [App\Http\Controllers\AppointmentController::class , 'index'])->name('appointments.index');

        // Flow/Trigger Routes
        Route::post('appointments/{id}/check-in', [App\Http\Controllers\AppointmentController::class , 'checkIn'])->name('appointments.check-in');
        Route::post('appointments/{id}/triage', [App\Http\Controllers\AppointmentController::class , 'sendToTriage'])->name('appointments.send-triage');
        Route::post('appointments/{id}/store-triage', [App\Http\Controllers\AppointmentController::class , 'updateTriage'])->name('appointments.store-triage');
        Route::post('appointments/{id}/start', [App\Http\Controllers\AppointmentController::class , 'startAttention'])->name('appointments.start');
        Route::post('appointments/{id}/finish', [App\Http\Controllers\AppointmentController::class , 'finishAppointment'])->name('appointments.finish');

        // Ruta para GUARDAR la cita nueva
        Route::post('/appointments', [App\Http\Controllers\AppointmentController::class , 'store'])->name('appointments.store');    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class , 'index'])->name('home');


use Illuminate\Support\Facades\Artisan;

Route::get('/instalar-datos', function () {
    try {
        Artisan::call('db:seed', ['--force' => true]);
        return "¡Datos base (Seeders) instalados correctamente! Ya puedes ir al Login.";
    } catch (\Exception $e) {
        return "Hubo un error instalando los datos: " . $e->getMessage();
    }
});

