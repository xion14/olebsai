@extends('__layouts.__frontend.main')

@section('body')
    <div class="w-100 mt-3">
        <div class="row px-2">
            <div class="col-12 col-md-5 mx-auto border border-1 rounded-3 shadow-sm p-0">
                <div class="w-100 d-flex flex-column align-items-center px-3 py-4 border-bottom border-1">
                    <h5 class="fw-bold">INVOICE</h5>
                    <span class="fw-bold fs-6">#17616281621</span>
                </div>
                <div class="w-100 py-4 px-3">
                    <div class="w-100 d-flex flex-column gap-2">
                        <h6 class="fw-bold">Toko Serba Ada</h6>
                        @foreach (range(1, 3) as $index)
                            <div class="w-100 row mb-2 gap-2">
                                <div class="col">
                                    <span class="d-block fs-6 fw-medium">Fresh Strawberry 500 gr</span>
                                    <span class="d-block fs-6 fw-medium">2x</span>
                                </div>
                                <div class="col text-end p-0">
                                    <span class="fs-6 fw-medium">Rp 48.000</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="w-100 row mb-2 gap-2">
                            <div class="col">
                                <span class="fs-6 fw-medium" style="color: #858585;">Discount</span>
                            </div>
                            <div class="col text-end p-0">
                                <span class="fs-6 fw-medium" style="color: #858585;">-Rp 20.000</span>
                            </div>
                        </div>
                        <div class="w-100 row gap-2">
                            <div class="col">
                                <span class="fs-6 fw-medium">Shipping cost</span>
                            </div>
                            <div class="col text-end p-0">
                                <span class="fs-6 fw-medium">Rp 25.000</span>
                            </div>
                        </div>
                        <div class="w-100 row mt-3 gap-2">
                            <div class="col">
                                <span class="fs-6 fw-bold">Total Payment</span>
                            </div>
                            <div class="col text-end p-0">
                                <span class="fs-6 fw-bold" style="color: #EE0000;">Rp1.200.000</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary w-100 mt-3">Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
