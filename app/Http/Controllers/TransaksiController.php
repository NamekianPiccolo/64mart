<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    public function index()
    {

        $role = auth()->user()->role;
        $data_transaksi = Transaksi::all();
        $data_produk = Produk::all();
        $view = ($role === 'admin' || $role === 'kasir') ? 'transaksi.index' : 'blocked';

        return view($view, [
            'title' => 'Transactions',
            'data_transaksi' => $data_transaksi,
            'data_produk' => $data_produk,
            'role' => $role,
        ]);
    }

    public function create()
    {
        $products = Produk::all();
        $kodeTransaksi = 'TRN' . Carbon::now()->format('YmdHis');
        return view('transaksi.create', compact('products', 'kodeTransaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required',
            'id_user' => 'required',
            'id_produk' => 'required',
            'kuantitas' => 'required',
            'metode_pembayaran' => 'required',
        ]);

        $kodeTransaksi = 'TRN' . Carbon::now()->format('YmdHis');

        $produk = Produk::find($request->id_produk);

        if ($produk) {
            $produk->stok -= $request->kuantitas;
            $produk->save();

            Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'id_user' => $request->id_user,
                'id_produk' => $request->id_produk,
                'total_harga' => $request->total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
        } else {
            return redirect()->route('admin.transaksi.index')->with('error', 'Produk tidak ditemukan atau stok tidak mencukupi.');
        }
    }


    public function edit($id)
    {
        $transaction = Transaksi::findOrFail($id);
        $products = Produk::all();
        return view('transaksi.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_transaksi' => 'required',
            'tanggal_transaksi' => 'required',
            'id_user' => 'required',
            'id_produk' => 'required',
            'kuantitas' => 'required',
            'total_harga' => 'required',
            'metode_pembayaran' => 'required',
        ]);

        $transaction = Transaksi::findOrFail($id);
        $transaction->update($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function calculateTotalHarga(Request $request)
    {
        $id_produk = $request->id_produk;
        $kuantitas = $request->kuantitas;

        // Lakukan perhitungan total harga di sini
        $selectedProduct = Produk::find($id_produk);
        $hargaProduk = $selectedProduct->harga;
        $totalHarga = $hargaProduk * $kuantitas;

        return response()->json(['total_harga' => $totalHarga]);
    }
}
