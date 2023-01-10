@extends('layout')

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldDocument"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Nota</h6>
                                <h6 class="font-extrabold mb-0">{{ number_format($nota) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon blue mb-2">
                                    <i class="iconly-boldUser"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Petugas</h6>
                                <h6 class="font-extrabold mb-0">{{ number_format($petugas) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon green mb-2">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Pelanggan</h6>
                                <h6 class="font-extrabold mb-0">{{ number_format($pelanggan) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 d-flex align-items-center">
                                <div class="py-5">
                                    <h1 class="display-5 fw-bold">{{ config('app.name') }}</h1>
                                    <p class="fs-4">Pendataan dan pembuatan bukti transaksi dengan efisiensi waktu
                                        yang digunakan serta dapat mengurangi terjadinya kehilangan data pencatatan hasil
                                        transaksi.</p>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/receipt.svg') }}" alt="" class="w-75">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
