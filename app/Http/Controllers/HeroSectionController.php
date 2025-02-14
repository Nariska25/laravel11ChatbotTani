<?php
namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HeroSectionController extends Controller
{
    // Menampilkan daftar Hero Section di Admin
    public function index()
    {
        $heroSections = HeroSection::where('is_active', true)->get();
        return view('admin.hero.index', compact('heroSections'));
    }

    // Menampilkan form untuk membuat Hero Section baru
    public function create()
    {
        return view('admin.hero.create');
    }

    // Menyimpan data Hero Section ke database
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('hero_images', 'public');

        HeroSection::create([
            'image' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Hero Section berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $heroSection = HeroSection::findOrFail($id);
        return view('admin.hero.edit', compact('heroSection'));
    }

    // Update Hero Section
    public function update(Request $request, $id)
    {
        $heroSection = HeroSection::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // Menghapus gambar lama jika ada
            if ($heroSection->image) {
                Storage::delete('public/' . $heroSection->image);
            }
            $heroSection->image = $request->file('image')->store('hero_images', 'public');
        }

        $heroSection->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Hero Section berhasil diperbarui');
    }

    
    public function destroy($id)
    {
        Log::info("Masuk ke method destroy dengan ID: " . $id);
    
        $heroSection = HeroSection::find($id);
    
        if (!$heroSection) {
            Log::error("Data dengan ID " . $id . " tidak ditemukan!");
            return redirect()->route('admin.hero.index')->with('error', 'Data tidak ditemukan!');
        }
    
        Log::info("Data ditemukan: " . json_encode($heroSection));
    
        // Hapus gambar jika ada
        if ($heroSection->image) {
            $imagePath = 'public/' . $heroSection->image;
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
                Log::info("Gambar berhasil dihapus: " . $imagePath);
            } else {
                Log::warning("Gambar tidak ditemukan: " . $imagePath);
            }
        }
    
        $heroSection->delete();
    
        Log::info("Data berhasil dihapus!");
    
        return redirect()->route('admin.hero.index')->with('success', 'Banner berhasil dihapus!');
    }

}
