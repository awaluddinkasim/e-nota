@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Edit Toko</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/edit.svg') }}" alt="" class="w-75">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Toko</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('master-data.update', ['id' => $toko->id, 'jenis' => 'toko']) }}" method="POST">
                                @method("PUT")
                                @csrf
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nama">Nama Toko</label>
                                        <input type="text" id="nama" class="form-control" name="nama"
                                            placeholder="Nama Toko" autocomplete="off" required value="{{ $toko->nama }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="alamat">Alamat Toko</label>
                                        <input type="text" id="alamat" class="form-control" name="alamat"
                                            placeholder="Alamat Toko" autocomplete="off" required value="{{ $toko->alamat }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="kontak">Kontak</label>
                                        <input type="text" id="kontak" class="form-control" name="kontak"
                                            placeholder="Kontak" autocomplete="off" required value="{{ $toko->kontak }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="kop">Kop Nota (Gambar)</label>
                                        <img src="{{ asset('files/toko/' . $toko->kop) }}" alt="" class="w-100 my-2">
                                        <input type="file" id="kop" class="form-control" name="kop"
                                            placeholder="Kop Nota">
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
