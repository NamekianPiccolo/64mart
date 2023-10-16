<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = auth()->user()->role;
        $data_kategori = Kategori::all();
        $data_produk = Produk::all();
        $view = ($role === 'admin' || $role === 'kasir') ? 'katalog_produk.produk.index' : 'blocked';

        return view($view, [
            'title' => 'Products',
            'data_kategori' => $data_kategori,
            'data_produk' => $data_produk,
            'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|numeric',
        ]);

        $latestProduk = Produk::orderBy('kode_produk', 'desc')->first();

        if ($latestProduk) {
            $latestProdukNumber = (int)substr($latestProduk->kode_produk, 3);
            $nextProdukNumber = $latestProdukNumber + 1;
            $kodeProduk = 'PRD' . str_pad($nextProdukNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $kodeProduk = 'PRD001';
        }

        Produk::create([
            'kode_produk' => $kodeProduk,
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
        ]);

        return redirect()->route($role . '.produk.index')->with('success', 'Successfully added a new product.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = auth()->user()->role;
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id', // pastikan ada kategori dengan id yang valid
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|numeric',
        ]);

        $produk = Produk::find($id);

        if (!$produk) {
            return redirect()->route($role . '.produk.index')->with('error', 'Product not found.');
        }

        $produk->nama_produk = $request->nama_produk;
        $produk->id_kategori = $request->id_kategori;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->stok = $request->stok;
        $produk->save();

        return redirect()->route($role . '.produk.index')->with('success', 'Successfully updated a product.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = auth()->user()->role;
        $produk = Produk::find($id);

        if (!$produk) {
            return redirect()->route($role . '.produk.index')->with('error', 'Product not found.');
        }

        $produk->delete();

        return redirect()->route($role . '.produk.index')->with('success', 'Successfully deleted a product.');
    }
}
