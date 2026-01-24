@extends('__layouts.__frontend.main')

@section('body')
    <div class="w-100 mt-3">
        <div class="row px-2">
            <div class="col-12 col-md-8 mx-auto border border-1 rounded-3 shadow-sm p-0">
                <div class="w-100 d-flex flex-column align-items-center px-3 py-4 border-bottom border-1">
                    <h5 class="fw-bold">Waiting Confirmation</h5>
                    <span class="fw-medium fs-6 text-center">PLease wait the admin to confirm your order.</span>
                </div>
                <div class="w-100 py-4 px-3">
                    <div class="w-100 row gap-2 gap-md-4">
                        <div class="col-12 col-md">
                            <span class="fw-bold fs-6">Order Date: 03/12/2024</span>
                        </div>
                        <div class="d-none d-md-block col-12 col-md text-md-end p-md-0">
                            <a href="#" class="cancel-order">Cancel order</a>
                        </div>
                        <div class="d-md-none col-12 col-md text-md-end p-md-0">
                            <button type="button" class="btn btn-danger">Cancel order</button>
                        </div>
                    </div>
                    <div class="w-100 d-none d-lg-flex flex-column gap-1 mt-4">
                        <span class="fw-bold fs-6">Charles Leclerc</span>
                        <span class="fw-medium fs-6">+62212715271512</span>
                        <span class="fw-medium fs-6">Jalan Merak Sari, Nomor 45</span>
                    </div>
                    <div
                        class="w-100 d-lg-none d-flex flex-column gap-1 mt-4 border border-1 border-primary px-3 py-2 rounded-2">
                        <span class="fw-bold fs-6">Charles Leclerc</span>
                        <span class="fw-medium fs-6">+62212715271512</span>
                        <span class="fw-medium fs-6">Jalan Merak Sari, Nomor 45</span>
                    </div>
                    <div class="w-100 d-flex flex-column gap-2 mt-5">
                        <h6 class="fw-bold">Toko Serba Ada</h6>
                        @foreach (range(1, 3) as $index)
                            <div class="w-100 row mb-2">
                                <div class="col col-md-4">
                                    <span class="d-block fs-6 fw-medium">Fresh Strawberry 500 gr</span>
                                    <span class="d-block d-md-none fs-6 fw-medium">2x</span>
                                </div>
                                <div class="col-3 text-end d-none d-md-block">
                                    <span class="fs-6 fw-medium">Rp 24.000</span>
                                </div>
                                <div class="col-2 text-end d-none d-md-block">
                                    <span class="fs-6 fw-medium">2</span>
                                </div>
                                <div class="col col-md-3 text-end p-0">
                                    <span class="fs-6 fw-medium">Rp 48.000</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="w-100 row">
                            <div class="col">
                                <span class="fs-6 fw-medium" style="color: #858585;">Discount</span>
                            </div>
                            <div class="col text-end p-0">
                                <span class="fs-6 fw-medium" style="color: #858585;">-Rp 20.000</span>
                            </div>
                        </div>
                        <div class="w-100 row mt-3">
                            <div class="col">
                                <span class="fs-6 fw-bold">Total Pesanan</span>
                            </div>
                            <div class="col text-end p-0">
                                <span class="fs-6 fw-bold" style="color: #EE0000;">Rp 52.000</span>
                            </div>
                        </div>
                        <span style="font-size: 14px; font-weight: 400; font-style: italic;">*belum termasuk ongkos
                            kirim</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
