@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Pengaturan</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Pengaturan Toko</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="POST">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nama Toko</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="nama-toko" class="form-control" name="nama-toko" value="{{ $namaToko ? $namaToko->value : '' }}" required autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Alamat Toko</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="alamat-toko" class="form-control" name="alamat-toko" value="{{ $alamatToko ? $alamatToko->value : '' }}" required autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label>No. Telp</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="contact" class="form-control" name="contact" value="{{ $contact ? $contact->value : '' }}" required autocomplete="off">
                                            </div>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
                                                <button type="reset"
                                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/settings.svg') }}" alt="" class="w-75">
                </div>
            </div>
        </section>
    </div>
@endsection
