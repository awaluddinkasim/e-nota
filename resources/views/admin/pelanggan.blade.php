@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Pelanggan</h3>
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
                                <th>Kode</th>
                                <th>Toko</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <tr>
                                <td>{{ 'KP'.sprintf("%04s", $customer->id) }}</td>
                                <td>{{ $customer->toko->nama }}</td>
                                <td>{{ $customer->nama }}</td>
                                <td>{{ $customer->no_hp }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="document.location.href = '{{ route('admin.customer.arsip-nota', $customer->id) }}'">
                                        Arsip Nota
                                    </button>
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
