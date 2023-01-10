@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Edit Gabah</h3>
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
                            <h5>Data Gabah</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('master-data.update', ['id' => $gabah->id, 'jenis' => 'gabah']) }}" method="POST">
                                @method("PUT")
                                @csrf
                                <div class="form-group">
                                    <label for="jenis">Jenis gabah</label>
                                    <input type="text" id="jenis" class="form-control" name="jenis" required value="{{ $gabah->jenis }}" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga / kg</label>
                                    <input type="text" id="harga" class="form-control" name="harga" required value="{{ $gabah->harga }}" autocomplete="off">
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
