<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Gabah;
use App\Models\Nota;
use App\Models\NotaItem;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ApiController extends Controller
{
    public function signature(Request $request)
    {
        $file = $request->file('ttd');
        $filename = uniqid() . "." . $file->extension();

        $file->move(public_path('files/petugas'), $filename);

        $user = User::find($request->user()->id);
        $user->ttd = $filename;
        $user->update();

        return response()->json([
            'message' => 'Berhasil'
        ], 200);
    }

    public function customers(Request $request)
    {
        $customers = Customer::orderBy('nama')->where('toko_id', $request->user()->toko_id)->get();

        return response()->json([
            'message' => 'Berhasil',
            'customers' => $customers,
        ], 200);
    }

    public function customerTambah(Request $request)
    {
        $customer = new Customer();
        $customer->toko_id = $request->user()->toko_id;
        $customer->kode = strtoupper(uniqid());
        $customer->nama = $request->nama;
        $customer->no_hp = $request->no_hp;
        $customer->alamat = $request->alamat;
        $customer->save();

        return response()->json([
            'message' => 'Berhasil'
        ], 200);
    }

    public function gabah()
    {
        $gabah = Gabah::orderBy('jenis')->get();

        return response()->json([
            'message' => 'Berhasil',
            'jenisGabah' => $gabah,
        ], 200);
    }

    public function getNota(Request $request)
    {
        $nota = Nota::where('toko_id', $request->user()->toko_id)->orderBy('created_at', 'DESC')->get();

        return response()->json([
            'message' => 'Berhasil',
            'nota' => $nota,
        ], 200);
    }

    public function buatNota(Request $request)
    {
        $nomorNota = getNomorNota($request->user()->toko_id);
        $dir = public_path('files/nota/' . str_replace('/', '-', $nomorNota));

        $file = $request->file('ttd');
        $filename = 'ttd-' . uniqid() . "." . $file->extension();

        $file->move($dir, $filename);

        $nota = new Nota();
        $nota->nomor = $nomorNota;
        $nota->toko_id = $request->user()->toko_id;
        $nota->customer_id = $request->customer['id'];
        $nota->gabah_id = $request->jenis_gabah['id'];
        $nota->catatan = $request->catatan;
        $nota->ttd = $filename;
        $nota->save();

        foreach ($request->daftar_gabah as $gabah) {
            $item = new NotaItem();
            $item->nota_id = $nota->id;
            $item->jumlah = $gabah['jumlah'];
            $item->berat = $gabah['berat'];
            $item->harga = $gabah['harga'];
            $item->save();
        }

        Pdf::loadView('pdf.nota', [
            'petugas' => $request->user(),
            'nota' => $nota,
        ])->save($dir . '/nota.pdf');

        return response()->json([
            'message' => 'Berhasil',
            'nomor' => $nota->nomor
        ], 200);
    }

    public function updateNota(Request $request)
    {
        $nota = Nota::find($request->id);
        $nota->catatan = $request->catatan;
        $nota->update();

        $dir = public_path('files/nota/' . str_replace('/', '-', $nota->nomor));

        Pdf::loadView('pdf.nota', [
            'namaToko' => Setting::where('name', 'nama-toko')->first(),
            'alamatToko' => Setting::where('name', 'alamat-toko')->first(),
            'contact' => Setting::where('name', 'contact')->first(),
            'petugas' => $request->user(),
            'nota' => $nota,
        ])->save($dir . '/nota.pdf');

        return response()->json([
            'message' => 'Berhasil'
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $petugas = User::find($request->user()->id);
        $petugas->nama = $request->nama;
        $petugas->username = $request->username;
        if ($request->password) {
            $petugas->password = bcrypt($request->password);
        }
        $petugas->update();

        return response()->json([
            'message' => 'Berhasil',
            'user' => $petugas
        ], 200);
    }
}
