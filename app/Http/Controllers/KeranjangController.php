<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DetailTransaksi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    public function tambahKeKeranjang(Request $request)
    {
        $id_produk = $request->id_produk;
        $kuantitas = $request->kuantitas;

        $produk = Produk::find($id_produk);

        if (!$produk) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($kuantitas <= 0) {
            return response()->json(['message' => 'Quantity must be greater than 0'], 400);
        }

        // Pastikan stok mencukupi
        if ($produk->stok < $kuantitas) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $keranjang = Session::get('keranjang') ?? [];

        if (array_key_exists($id_produk, $keranjang)) {
            $keranjang[$id_produk]['kuantitas'] += $kuantitas;
        } else {
            $keranjang[$id_produk] = [
                'produk' => $produk,
                'kuantitas' => $kuantitas,
            ];
        }

        Session::put('keranjang', $keranjang);

        return response()->json(['message' => 'Item added to cart']);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'total_harga' => 'required|numeric',
            'pay' => 'required|numeric',
            'cashback' => 'required|numeric',
            'id_produk' => 'required|array',
            'id_produk.*' => 'exists:produk,id',
            'id_user' => 'required|integer',
            'kuantitas' => 'required|array',
        ]);


        $kodeTransaksi = 'TRN' . Carbon::now()->format('YmdHis');

        $transaksi = new Transaksi;
        $transaksi->kode_transaksi = $kodeTransaksi;
        $transaksi->tanggal_transaksi = $request->tanggal_transaksi;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->id_user = $request->id_user;
        $transaksi->metode_pembayaran = 'tunai';

        $transaksi->save();

        foreach ($request->id_produk as $key => $id_produk) {
            $produk = Produk::find($id_produk);
            if ($produk) {
                $produk->stok -= $request->kuantitas[$key];
                $produk->save();
                $detailTransaksi = new DetailTransaksi;
                $detailTransaksi->kode_transaksi = $kodeTransaksi;
                $detailTransaksi->id_produk = $id_produk;
                $detailTransaksi->harga_produk = $request->harga_jual[$key];
                $detailTransaksi->kuantitas = $request->kuantitas[$key];
                $detailTransaksi->subtotal = $request->subtotal[$key];
                $detailTransaksi->save();
            } else {
                return redirect()->route('admin.transaksi.index')->with('error', 'gagal.');
            }
        }
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }
}
