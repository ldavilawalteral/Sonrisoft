<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // =========================================================
    // MERCADO PAGO — Checkout Preferences
    // =========================================================
    public function createPayment(Request $request)
    {
        $request->validate([
            'plan_name' => 'required|string|in:basico,profesional,premium',
            'price'     => 'required|numeric|min:1',
        ]);

        $planLabels = [
            'basico'       => 'Sonrisoft Plan Básico',
            'profesional'  => 'Sonrisoft Plan Profesional',
            'premium'      => 'Sonrisoft Plan Premium',
        ];

        $payload = [
            'items' => [
                [
                    'title'       => $planLabels[$request->plan_name],
                    'quantity'    => 1,
                    'unit_price'  => (float) $request->price,
                    'currency_id' => 'PEN',
                ],
            ],
            'back_urls' => [
                'success' => route('payment.success'),
                'failure' => route('payment.failure'),
                'pending' => route('payment.pending'),
            ],
            // auto_return eliminado: MP rechaza localhost como back_url.success.
            // Re-agregar en producción cuando las rutas sean URLs públicas reales.
            // 'auto_return' => 'approved',
            'statement_descriptor' => 'SONRISOFT',
            'external_reference'  => 'plan_' . $request->plan_name . '_' . now()->timestamp,
        ];

        // ⚡ env() directo para saltarnos cualquier caché de config
        $response = Http::withToken(env('MERCADOPAGO_ACCESS_TOKEN'))
            ->accept('application/json')
            ->post('https://api.mercadopago.com/checkout/preferences', $payload);

        if ($response->failed()) {
            return back()->withErrors(['mp' => 'Error Mercado Pago (' . $response->status() . '): ' . $response->json('message')])->withInput();
        }

        return redirect()->away($response->json('init_point'));
    }

    // =========================================================
    // MERCADO PAGO — Callbacks de retorno
    // =========================================================
    public function paymentSuccess()
    {
        return redirect()->route('home')
            ->with('success', '¡Pago completado! Bienvenido a Sonrisoft. En breve recibirás tus credenciales de acceso.');
    }

    public function paymentFailure()
    {
        return redirect()->to('/#precios')
            ->with('error', 'El pago no pudo completarse. Por favor, intenta nuevamente o contáctanos por WhatsApp.');
    }

    public function paymentPending()
    {
        return redirect()->to('/#precios')
            ->with('warning', 'Tu pago está siendo procesado. Te notificaremos cuando sea confirmado.');
    }

    // =========================================================
    // PAGOS INTERNOS DE TRATAMIENTOS (existente)
    // =========================================================

    public function store(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:Efectivo,Tarjeta,Transferencia',
        ]);

        if ($validated['amount'] > $treatment->balance) {
            return back()->withErrors(['amount' => 'El monto no puede ser mayor al saldo pendiente.']);
        }

        $treatment->payments()->create($validated);

        if ($treatment->balance == 0) {
            $treatment->update(['status' => 'completed']);
        }

        return back()->with('success', 'Pago registrado correctamente.');
    }
}
