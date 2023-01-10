<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Toko;
use App\Models\User;
use App\Models\Admin;
use App\Models\Gabah;
use App\Models\Setting;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class PagesController extends Controller
{
    public function dashboard()
    {
        $data = [
            'nota' => Nota::all()->count(),
            'petugas' => User::all()->count(),
            'pelanggan' => Customer::all()->count(),
        ];

        return view('pages.dashboard', $data);
    }

    public function masterData($jenis)
    {
        switch ($jenis) {
            case 'gabah':
                $data = [
                    'daftarGabah' => Gabah::orderBy('jenis')->get(),
                ];

                return view('pages.master-gabah', $data);

            case 'toko':
                $data = [
                    'daftarToko' => Toko::orderBy('nama')->get(),
                ];

                return view('pages.master-toko', $data);

            case 'petugas':
                $data = [
                    'daftarToko' => Toko::orderBy('nama')->get(),
                    'daftarPetugas' => User::orderBy('nama')->get(),
                ];

                return view('pages.master-petugas', $data);

            default:
                return redirect()->route('dashboard');
        }
    }

    public function masterDataEdit($jenis, $id)
    {
        switch ($jenis) {
            case 'gabah':
                $data = [
                    'gabah' => Gabah::find($id),
                ];

                return view('pages.master-gabah-edit', $data);

            case 'toko':
                $data = [
                    'toko' => Toko::find($id),
                ];

                return view('pages.master-toko-edit', $data);

            case 'petugas':
                $data = [
                    'petugas' => User::find($id),
                ];

                return view('pages.master-petugas-edit', $data);

            default:
                return redirect()->route('dashboard');
        }
    }

    public function masterDataUpdate(Request $request, $jenis, $id)
    {
        switch ($jenis) {
            case 'gabah':
                $gabah = Gabah::find($id);
                $gabah->jenis = $request->jenis;
                $gabah->harga = $request->harga;
                $gabah->update();

                return redirect()->route('master-data', 'gabah');

            case 'toko':
                $file = $request->file('kop');


                $gabah = Toko::find($id);
                $gabah->nama = $request->nama;
                $gabah->alamat = $request->alamat;
                $gabah->kontak = $request->kontak;
                if ($file) {
                    $filename = time() . "." . $file->extension();

                    $gabah->kop = $filename;

                    File::delete(public_path('files/toko/'.$gabah->kop));
                    $file->move(public_path('files/toko'), $filename);
                }

                $gabah->save();

                return redirect()->route('master-data', 'toko');

            case 'petugas':
                $petugas = User::find($id);
                $petugas->nama = $request->nama;
                $petugas->username = $request->username;
                if ($request->password) {
                    $petugas->password = bcrypt($request->password);
                }
                $petugas->update();

                return redirect()->route('master-data', 'petugas');

            default:
                return redirect()->route('dashboard');
        }
    }

    public function masterDataStore(Request $request, $jenis)
    {
        switch ($jenis) {
            case 'gabah':
                $gabah = new Gabah();
                $gabah->jenis = $request->jenis;
                $gabah->harga = $request->harga;
                $gabah->save();

                return redirect()->back()->with('success', 'Berhasil tambah jenis gabah');

            case 'toko':
                $file = $request->file('kop');
                $filename = time() . "." . $file->extension();

                $gabah = new Toko();
                $gabah->kode = strtoupper(Str::random(3));
                $gabah->nama = $request->nama;
                $gabah->alamat = $request->alamat;
                $gabah->kontak = $request->kontak;
                $gabah->kop = $filename;

                $file->move(public_path('files/toko'), $filename);

                $gabah->save();

                return redirect()->back()->with('success', 'Berhasil tambah toko');

            case 'petugas':
                $petugas = new User();
                $petugas->nama = $request->nama;
                $petugas->username = $request->username;
                $petugas->password = bcrypt($request->password);
                $petugas->toko_id = $request->toko;
                $petugas->save();

                return redirect()->back()->with('success', 'Berhasil tambah petugas');

            default:
                return redirect()->route('dashboard');
        }
    }

    public function masterDataDelete(Request $request, $jenis)
    {
        switch ($jenis) {
            case 'gabah':
                $gabah = Gabah::find($request->id);
                $gabah->delete();

                return redirect()->back()->with('success', 'Berhasil hapus jenis gabah');

            case 'toko':
                $toko = Toko::find($request->id);
                File::delete(public_path('files/toko/'.$toko->kop));
                $toko->delete();

                return redirect()->back()->with('success', 'Berhasil hapus toko');

            case 'petugas':
                $petugas = User::find($request->id);
                File::delete(public_path('files/petugas/'.$petugas->ttd));
                $petugas->delete();

                return redirect()->back()->with('success', 'Berhasil hapus petugas');

            default:
                return redirect()->route('dashboard');
        }
    }

    public function pelanggan()
    {
        $data = [
            'customers' => Customer::orderBy('nama')->get(),
        ];

        return view('pages.pelanggan', $data);
    }

    public function pengaturan()
    {
        $data = [
            'namaToko' => Setting::where('name', 'nama-toko')->first(),
            'alamatToko' => Setting::where('name', 'alamat-toko')->first(),
            'contact' => Setting::where('name', 'contact')->first(),
        ];

        return view('pages.pengaturan', $data);
    }

    public function pengaturanUpdate(Request $request)
    {
        foreach ($request->keys() as $key) {
            if ($key != "_token") {
                $pengaturan = Setting::where('name', $key)->first();
                if ($pengaturan) {
                    $pengaturan->value = $request->$key;
                    $pengaturan->update();
                } else {
                    $pengaturan = new Setting();
                    $pengaturan->name = $key;
                    $pengaturan->value = $request->$key;
                    $pengaturan->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Berhasil update pengaturan');
    }

    public function nota()
    {
        $data = [
            'daftarNota' => Nota::orderBy('nomor', 'DESC')->get(),
        ];

        return view('pages.nota', $data);
    }

    public function notaDetail(Request $request)
    {
        $data = [
            'nota' => Nota::find($request->id),
        ];

        return view('pages.nota-detail', $data);
    }

    public function notaDownload($id)
    {
        $nota = Nota::find($id);
        $nomor = str_replace('/', '-', $nota->nomor);

        $path = public_path('files/nota/' . $nomor . '/nota.pdf');

        return response()->download($path, $nomor);
    }

    public function laporan()
    {
        $nota = Nota::distinct()->get(['created_at']);
        $data = [
            'years' => $nota->unique('year')->pluck('year'),
        ];

        return view('pages.laporan', $data);
    }

    public function laporanDownload(Request $request)
    {
        $data = [
            'daftarNota' => Nota::whereMonth('created_at', $request->bulan)->whereYear('created_at', $request->tahun)->get()
        ];
        $pdf = Pdf::loadView('pdf.laporan', $data);

        return $pdf->download("Laporan " . $request->bulan . ' ' . $request->tahun . '.pdf');
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function profileUpdate(Request $request)
    {
        $admin = Admin::find(auth()->user()->id);
        $admin->nama = $request->nama;
        $admin->username = $request->username;
        if ($request->password) {
            $admin->password = bcrypt($request->password);
        }
        $admin->update();

        return redirect()->back();
    }
}
