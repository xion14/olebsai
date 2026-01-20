<section class="py-2" style="background-color: #86ccf3;">
    <div class="container-lg d-flex justify-content-between align-items-center" style="font-size: 14px;">
        <small class="d-none d-lg-block" id="information-bar"></small>
        <div class="d-flex gap-1">
            <button type="submit" onclick="window.location.href='{{ url('/shop') }}'" class="btn p-0 border-0 mx-3 fw-semibold">Belanja</button>
            <button type="button" onclick="window.location.href='{{ url('/about-us') }}'" class="btn p-0 border-0 mx-3 fw-semibold">Tentang Kami</button>
        </div>
    </div>
</section>
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container-lg py-1">
        <button onclick="window.location.href='{{ url('/') }}'"
            class="d-flex flex-row align-items-center border-0 bg-transparent mr-md-5">
            <img src="{{ asset('assets/image/brand/logo-brand.png') }}" alt="Logo" width="50" height="auto">
            <span class="ms-2 fw-bold">Olebsai</span>
        </button>
        <button type="button" class="btn btn-primary text-white text-nowrap" onclick="window.location.href='{{ url('/about-us') }}'">
            <span class="d-inline-block mx-1">Tentang Kami</span>
        </button>
    </div>
</nav>
