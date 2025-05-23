<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $shippingMethods = ShippingMethod::latest()->get();
        return view('admin.shipping.index', compact('shippingMethods'));
    }

    public function create()
    {
        return view('admin.shipping.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'courier' => 'required|string|max:255',
            'courier_service' => 'required|string|max:255',
            'delivery_estimate' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        ShippingMethod::create($validated);

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Shipping method created successfully.');
    }

    public function edit(ShippingMethod $shipping)
    {
        return view('admin.shipping.edit', ['shippingMethod' => $shipping]);
    }


    public function update(Request $request, ShippingMethod $shipping)
    {
        $validated = $request->validate([
            'courier' => 'required|string|max:255',
            'courier_service' => 'required|string|max:255',
            'delivery_estimate' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $shipping->update($validated);
    return redirect()->route('admin.shipping.index')
        ->with('success', 'Shipping method updated successfully.');
    }

    public function destroy(ShippingMethod $shipping)
    {
        $shipping->delete();
        return redirect()->route('admin.shipping.index')
            ->with('success', 'Shipping method deleted successfully.');
    }
    
}