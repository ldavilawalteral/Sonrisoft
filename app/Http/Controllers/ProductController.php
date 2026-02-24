<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UnitType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // BelongsToTenant trait automatically filters these
        $products = Product::with('unitType')->latest()->paginate(10);
        $unitTypes = UnitType::all(); // Should also be scoped by tenant

        return view('products.index', compact('products', 'unitTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_type_id' => 'required|exists:unit_types,id',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // tenant_id injected by Trait
        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'unit_type_id' => 'required|exists:unit_types,id',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
