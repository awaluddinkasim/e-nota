@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Data Toko</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5>Daftar Toko</h5>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Tambah
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if (Session::has("success"))
                    <div class="alert alert-light-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif
                    @if (Session::has("failed"))
                    <div class="alert alert-light-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Toko</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th>Jumlah Pedagang</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftarToko as $toko)
                                <tr>
                                    <td>{{ 'T'.sprintf("%02s", $toko->id) }}</td>
                                    <td>{{ $toko->nama }}</td>
                                    <td>{{ $toko->alamat }}</td>
                                    <td>{{ $toko->kontak }}</td>
                                    <td>{{ $toko->pedagang->count() }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm"
                                            onclick="document.location.href = '{{ route('admin.master-data.edit', ['id' => $toko->id, 'jenis' => 'toko']) }}'">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $toko->id }}">
                                            <button class="btn btn-danger btn-sm" type="submit">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Toko</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form form-vertical" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nama">Nama Toko</label>
                                        <input type="text" id="nama" class="form-control" name="nama"
                                            placeholder="Nama Toko" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat Toko</label>
                                        <input type="text" id="alamat" class="form-control" name="alamat"
                                            placeholder="Alamat Toko" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="kontak">Kontak</label>
                                        <input type="text" id="kontak" class="form-control" name="kontak"
                                            placeholder="Kontak" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="kop">Kop Nota (Gambar)</label>
                                        <input type="file" id="kop" class="form-control" name="kop" accept=".jpg, .jpeg, .png"
                                            placeholder="Kop Nota" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="admin">Admin</label>
                                        <select name="admin" id="admin" class="form-select" required>
                                            <option value="" selected hidden>Pilih</option>
                                            @foreach ($daftarAdmin as $admin)
                                                <option value="{{ $admin->id }}">{{ $admin->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
