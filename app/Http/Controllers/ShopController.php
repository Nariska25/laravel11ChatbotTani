<?php
namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
{
    $query = Products::query();

    // Filter by category
    if ($request->has('kategori') && $request->kategori != 'all') {
        $query->where('category_id', $request->kategori);
    }

    // Search by keyword
    if ($request->has('search')) {
        $query->where('products_name', 'like', '%' . $request->search . '%');
    }

    $products = $query->paginate(12);
    $categories = Categories::all();

    return view('shop', compact('products', 'categories'));
}
}