<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        // Get users from the same tenant, excluding the current user if desired, or all.
        // The Global Scope on User (via BelongsToTenant if applied, but User doesn't have it by default yet, check User model)
        // Wait, User model DOES NOT have BelongsToTenant trait used in the file I viewed earlier?
        // Let me double check User model. 
        // In the previous step I viewed User model and it DID NOT have 'use BelongsToTenant'.
        // However, the prompt says "users que pertenecen a mi misma clínica (tenant_id)".
        // If User doesn't have the trait, I must manually filter.

        $staff = User::where('tenant_id', auth()->user()->tenant_id)
            ->get();

        return view('staff.index', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users', // Unique across the whole system
            ],
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'tenant_id' => auth()->user()->tenant_id,
            'role' => 'assistant',
        ]);

        return back()->with('success', 'Personal agregado correctamente.');
    }

    public function destroy(User $staff)
    {
        // Ensure we can only delete staff from our own tenant
        if ($staff->tenant_id !== auth()->user()->tenant_id) {
            abort(403);
        }

        $staff->delete();
        return back()->with('success', 'Personal eliminado correctamente.');
    }
}
