<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Toko;
use App\Models\User;
use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;

class TokoController extends Controller
{
    public function dashboard()
    {
        $data = [
            'nota' => Nota::all()->count(),
            'pedagang' => User::all()->count(),
            'pelanggan' => Customer::all()->count(),
        ];

        return view('toko.dashboard', $data);
    }

    public function pedagang()
    {
        $data = [
            'daftarPedagang' => User::where('toko_id', auth()->user()->toko->id)->orderBy('nama')->get(),
        ];

        return view('toko.pedagang', $data);
    }

    public function pedagangStore(Request $request)
    {
        try {

            $pedagang = new User();
            $pedagang->nama = $request->nama;
            $pedagang->username = $request->username;
            $pedagang->password = bcrypt($request->password);
            $pedagang->toko_id = auth()->user()->toko->id;
            $pedagang->save();

            return redirect()->back()->with('success', 'Berhasil menambah pedagang');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return redirect()->back()->with('failed', 'Pedagang dengan username "' . $request->username . '" sudah ada');
            }
        }
    }

    public function pedagangEdit($id)
    {
        $data = [
            'pedagang' => User::find($id),
        ];

        return view('toko.pedagang-edit', $data);
    }

    public function pedagangUpdate(Request $request, $id)
    {
        $pedagang = User::find($id);
        $pedagang->nama = $request->nama;
        $pedagang->username = $request->username;
        if ($request->password) {
            $pedagang->password = bcrypt($request->password);
        }
        $pedagang->update();

        return redirect()->route('pedagang')->with('success', 'Berhasil update pedagang');
    }

    public function pedagangDelete(Request $request)
    {
        $pedagang = User::find($request->id);
        File::delete(public_path('files/pedagang/' . $pedagang->ttd));
        $pedagang->delete();

        return redirect()->route('pedagang')->with('success', 'Berhasil hapus pedagang');
    }

    public function pelanggan()
    {
        $data = [
            'customers' => Customer::where('toko_id', auth()->user()->toko->id)->orderBy('nama')->get(),
        ];

        return view('toko.pelanggan', $data);
    }

    public function nota($id)
    {
        $data = [
            'nama' => Customer::find($id)->nama,
            'daftarNota' => Nota::where('customer_id', $id)->orderBy('nomor', 'DESC')->get(),
        ];

        return view('toko.nota', $data);
    }

    public function notaDetail(Request $request, $id)
    {
        $data = [
            'nota' => Nota::where('customer_id', $id)->where('id', $request->id)->first(),
        ];

        return view('toko.nota-detail', $data);
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
        $nota = Nota::where('toko_id', auth()->user()->toko->id)->distinct()->get(['created_at']);
        $data = [
            'years' => $nota->unique('year')->pluck('year'),
        ];

        return view('toko.laporan', $data);
    }

    public function laporanDownload(Request $request)
    {
        $data = [
            'daftarNota' => Nota::where('toko_id', auth()->user()->toko->id)->whereMonth('created_at', $request->bulan)->whereYear('created_at', $request->tahun)->get()
        ];
        $pdf = Pdf::loadView('pdf.laporan', $data);

        return $pdf->download("Laporan " . $request->bulan . ' ' . $request->tahun . '.pdf');
    }

    public function pengaturan()
    {
        return view('toko.pengaturan');
    }

    public function pengaturanUpdate(Request $request)
    {
        $file = $request->file('kop');

        $toko = Toko::find(auth()->user()->toko->id);
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
        return redirect()->back()->with('success', 'Berhasil update data toko');
    }

    public function profile()
    {
        return view('toko.profile');
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
