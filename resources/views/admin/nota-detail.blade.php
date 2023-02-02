@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Detail Nota</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <button class="btn btn-primary btn-block mb-4" onclick="document.location.href='{{ route('admin.customer.arsip-nota.download', $nota->id) }}'">
                                Download Nota
                            </button>

                            <table class="w-100">
                                <tr>
                                    <td>Nomor nota</td>
                                    <td>:</td>
                                    <td>{{ $nota->nomor }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis gabah</td>
                                    <td>:</td>
                                    <td>{{ $nota->gabah->jenis }}</td>
                                </tr>
                                <tr>
                                    <td>Total jumlah</td>
                                    <td>:</td>
                                    <td>{{ number_format($nota->items->sum('jumlah')) }}</td>
                                </tr>
                                <tr>
                                    <td>Total berat</td>
                                    <td>:</td>
                                    <td>{{ number_format($nota->items->sum('berat')) }} kg</td>
                                </tr>
                                <tr>
                                    <td>Total harga</td>
                                    <td>:</td>
                                    <td>Rp. {{ number_format($nota->total_harga) }}</td>
                                </tr>
                                <tr>
                                    <td>Catatan</td>
                                    <td>:</td>
                                    <td>{{ $nota->catatan ? $nota->catatan : '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>{{ Carbon\Carbon::parse($nota->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                            </table>

                            <h5 class="mt-3">Pelanggan</h5>
                            <table class="w-100">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $nota->customer->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $nota->customer->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>No. HP</td>
                                    <td>:</td>
                                    <td>{{ $nota->customer->no_hp }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Daftar gabah</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jumlah</th>
                                        <th>Berat (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nota->items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->berat }}</td>
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
