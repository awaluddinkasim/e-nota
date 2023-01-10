@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Arsip Nota</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Daftar pelanggan
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>Nomor Nota</th>
                                <th>Jenis Gabah</th>
                                <th>Pelanggan</th>
                                <th>Total Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftarNota as $nota)
                            <tr>
                                <td>{{ $nota->nomor }}</td>
                                <td>{{ $nota->gabah->jenis }}</td>
                                <td>{{ $nota->customer->nama }}</td>
                                <td>Rp. {{ number_format($nota->total_harga) }}</td>
                                <th>
                                    <button class="btn btn-primary btn-sm" onclick="document.location.href = '{{ route('arsip-nota.detail') }}?id={{ $nota->id }}'">
                                        Detail
                                    </button>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
