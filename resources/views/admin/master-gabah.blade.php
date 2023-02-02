@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Data Gabah</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/gabah.svg') }}" alt="" class="w-75">
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5>Daftar Jenis Gabah</h5>
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
                                        <th>Jenis</th>
                                        <th>Harga / kg</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daftarGabah as $gabah)
                                        <tr>
                                            <td>{{ $gabah->jenis }}</td>
                                            <td>Rp. {{ number_format($gabah->harga) }}</td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-primary btn-sm"
                                                    onclick="document.location.href = '{{ route('admin.master-data.edit', ['id' => $gabah->id, 'jenis' => 'gabah']) }}'"
                                                    >
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <form action="" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $gabah->id }}">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Jenis Gabah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form form-horizontal" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Jenis gabah</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="jenis" class="form-control" name="jenis"
                                        autocomplete="off" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Harga per kilo</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="harga" class="form-control" name="harga"
                                        autocomplete="off" required>
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
