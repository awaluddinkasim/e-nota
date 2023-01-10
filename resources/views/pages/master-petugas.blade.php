@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Data Petugas</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/acc.svg') }}" alt="" class="w-75">
                </div>
                <div class="col-md-6">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5>Daftar Petugas</h5>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Tambah
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" id="table1">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daftarPetugas as $petugas)
                                        <tr>
                                            <td>{{ $petugas->username }}</td>
                                            <td>{{ $petugas->nama }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-sm"
                                                onclick="document.location.href = '{{ route('master-data.edit', ['id' => $petugas->id, 'jenis' => 'petugas']) }}'"
                                                >
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <form action="" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $petugas->id }}">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Petugas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form form-vertical" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" id="nama" class="form-control" name="nama"
                                            placeholder="Nama Lengkap" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" id="username" class="form-control" name="username"
                                            placeholder="Username" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Password" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="toko">Toko</label>
                                        <select name="toko" id="toko" class="form-select" required>
                                            <option value="" selected hidden>Pilih</option>
                                            @foreach ($daftarToko as $toko)
                                                <option value="{{ $toko->id }}">{{ $toko->nama }}</option>
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
