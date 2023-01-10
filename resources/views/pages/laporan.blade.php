@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Laporan</h3>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-center">
                            <form action="{{ route('laporan.download') }}" method="post" class="w-100">
                                @csrf
                                <div class="mb-3">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select class="form-select" id="bulan" name="bulan" required>
                                        @for ($bulan = 1; $bulan <= 12; $bulan++)
                                            <option value="{{ $bulan }}">{{ $bulan }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select class="form-select" id="tahun" name="tahun" required>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix">
                                    <button type="submit" class="btn btn-primary float-end">Download</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 d-none d-md-block">
                            <img src="{{ asset('assets/images/laporan.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
