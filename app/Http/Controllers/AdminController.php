<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Toko;
use App\Models\Admin;
use App\Models\Gabah;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'nota' => Nota::all()->count(),
            'toko' => Toko::all()->count(),
            'pelanggan' => Customer::all()->count(),
        ];

        return view('admin.dashboard', $data);
    }

    public function masterData($jenis)
    {
        switch ($jenis) {
            case 'gabah':
                $data = [
                    'daftarGabah' => Gabah::orderBy('jenis')->get(),
                ];

                return view('admin.master-gabah', $data);

            case 'toko':
                $data = [
                    'daftarToko' => Toko::all(),
                    'daftarAdmin' => Admin::whereNot('role', 'super-admin')->doesntHave('toko')->orderBy('nama')->get(),
                ];

                return view('admin.master-toko', $data);

            case 'admin':
                $data = [
                    'daftarAdmin' => Admin::whereNot('role', 'super-admin')->orderBy('nama')->get(),
                ];

                return view('admin.master-admin', $data);

            default:
                return redirect()->route('admin.dashboard');
        }
    }

    public function masterDataEdit($jenis, $id)
    {
        switch ($jenis) {
            case 'gabah':
                $data = [
                    'gabah' => Gabah::find($id),
                ];

                return view('admin.master-gabah-edit', $data);

            case 'toko':
                $data = [
                    'toko' => Toko::find($id),
                ];

                return view('admin.master-toko-edit', $data);

            case 'admin':
                $admin = Admin::find($id);
                if ($admin && $admin->role == "super-admin") {
                    return redirect()->route('admin.master-data', 'admin')->with('failed', 'Admin tidak valid');
                }
                $data = [
                    'admin' => $admin,
                ];

                return view('admin.master-admin-edit', $data);

            default:
                return redirect()->route('admin.dashboard');
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

                return redirect()->route('admin.master-data', 'gabah')->with('success', 'Berhasil update data gabah');

            case 'toko':
                $file = $request->file('kop');

                $toko = Toko::find($id);
                $toko->nama = $request->nama;
                $toko->alamat = $request->alamat;
                $toko->kontak = $request->kontak;
                if ($file) {
                    $filename = time() . "." . $file->extension();

                    $toko->kop = $filename;

                    File::delete(public_path('files/toko/' . $toko->kop));
                    $file->move(public_path('files/toko'), $filename);
                }

                $toko->update();

                return redirect()->route('admin.master-data', 'toko')->with('success', 'Berhasil update data toko');

            case 'admin':
                $admin = Admin::find($id);
                if ($admin && $admin->role == "super-admin") {
                    return redirect()->route('admin.master-data', 'admin')->with('failed', 'Admin tidak valid');
                }

                $admin = Admin::find($id);
                $admin->nama = $request->nama;
                $admin->username = $request->username;
                if ($request->password) {
                    $admin->password = bcrypt($request->password);
                }
                $admin->update();

                return redirect()->route('admin.master-data', 'admin')->with('success', 'Berhasil update data admin');

            default:
                return redirect()->route('admin.dashboard');
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

                $toko = new Toko();
                $toko->nama = $request->nama;
                $toko->alamat = $request->alamat;
                $toko->kontak = $request->kontak;
                $toko->kop = $filename;
                $toko->admin = $request->admin;

                $file->move(public_path('files/toko'), $filename);

                $toko->save();

                return redirect()->back()->with('success', 'Berhasil tambah toko');

            case 'admin':
                try {
                    $admin = new Admin();
                    $admin->nama = $request->nama;
                    $admin->username = $request->username;
                    $admin->password = bcrypt($request->password);
                    $admin->role = "admin-toko";
                    $admin->save();

                    return redirect()->back()->with('success', 'Berhasil tambah admin');
                } catch (QueryException $e) {
                    $errorCode = $e->errorInfo[1];
                    if ($errorCode == 1062) {
                        return redirect()->back()->with('failed', 'Akun dengan username "' . $request->username . '" sudah ada');
                    }
                }

            default:
                return redirect()->route('admin.dashboard');
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
                File::delete(public_path('files/toko/' . $toko->kop));
                foreach ($toko->pedagang as $pedagang) {
                    File::delete(public_path('files/pedagang/' . $pedagang->ttd));
                }
                $toko->delete();

                return redirect()->back()->with('success', 'Berhasil hapus toko');

            case 'admin':
                $admin = Admin::find($request->id);
                if ($admin->toko) {
                    File::delete(public_path('files/toko/' . $admin->toko->kop));
                    foreach ($admin->toko->pedagang as $pedagang) {
                        File::delete(public_path('files/pedagang/' . $pedagang->ttd));
                    }
                }
                $admin->delete();

                return redirect()->back()->with('success', 'Berhasil hapus admin');

            default:
                return redirect()->route('admin.dashboard');
        }
    }

    public function pelanggan()
    {
        $data = [
            'customers' => Customer::orderBy('nama')->get(),
        ];

        return view('admin.pelanggan', $data);
    }

    public function nota($id)
    {
        $data = [
            'nama' => Customer::find($id)->nama,
            'daftarNota' => Nota::where('customer_id', $id)->orderBy('nomor', 'DESC')->get(),
        ];

        return view('admin.nota', $data);
    }

    public function notaDetail(Request $request, $id)
    {
        $data = [
            'nota' => Nota::where('customer_id', $id)->where('id', $request->id)->first(),
        ];

        return view('admin.nota-detail', $data);
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
            'daftarToko' => Toko::orderBy('nama')->get(),
            'years' => $nota->unique('year')->pluck('year'),
        ];

        return view('admin.laporan', $data);
    }

    public function laporanDownload(Request $request)
    {
        $data = [
            'daftarNota' => Nota::where('toko_id', $request->toko)->whereMonth('created_at', $request->bulan)->whereYear('created_at', $request->tahun)->get()
        ];
        $pdf = Pdf::loadView('pdf.laporan', $data);

        return $pdf->download("Laporan " . $request->bulan . ' ' . $request->tahun . '.pdf');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profileUpdate(Request $request)
    {
        try {
            $admin = Admin::find(auth()->user()->id);
            $admin->nama = $request->nama;
            $admin->username = $request->username;
            if ($request->password) {
                $admin->password = bcrypt($request->password);
            }
            $admin->update();

            return redirect()->back()->with('success', 'Berhasil update profil');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return redirect()->back()->with('failed', 'Akun dengan username "' . $request->username . '" sudah ada');
            }
        }
    }
}
