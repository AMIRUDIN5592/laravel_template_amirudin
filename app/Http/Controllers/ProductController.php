<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::cursorPaginate(2);

        return view('product.index', compact('products'));
    }

    public function create(): View
    {
        return view('product.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);

        return view('product.edit', compact('product'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}
