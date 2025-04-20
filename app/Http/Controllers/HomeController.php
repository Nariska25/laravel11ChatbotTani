<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
        
public function index()
{
    $featuredProducts = Products::where('recommendation', true)
                                ->with('category') // Eager load the kategori relationship
                                ->get();

    return view('home', compact('featuredProducts'));
}

}


