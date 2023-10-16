<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return view('kategori.index', [
        //     'title' => 'Categories',
        //     'data_kategori' => $data_kategori,
        //     'role' => $role
        // ]);

        $role = auth()->user()->role;
        $data_kategori = Kategori::all();
        $view = ($role === 'admin' || $role === 'kasir') ? 'katalog_produk.kategori.index' : 'blocked';

        return view($view, [
            'title' => 'Categories',
            'data_kategori' => $data_kategori,
            'role' => $role
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('kategori.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route($role . '.kategori.index')->with('success', 'Successfully added a category.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Kategori $kategori)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $kategori = Kategori::find($id);

    //     if (!$kategori) {
    //         return redirect()->route('kategori.index')->with('error', 'Category not found.');
    //     }

    //     return view('kategori.edit', compact('kategori'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return redirect()->route($role . '.kategori.index')->with('error', 'Category not found.');
        }

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route($role . '.kategori.index')->with('success', 'Successfully updated a category.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = auth()->user()->role;
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return redirect()->route($role . '.kategori.index')->with('error', 'Category not found.');
        }

        $kategori->delete();

        return redirect()->route($role . '.kategori.index')->with('success', 'Successfully deleted a category.');
    }
}
