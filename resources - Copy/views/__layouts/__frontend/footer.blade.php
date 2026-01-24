<footer class="w-100 p-2 pt-4 p-lg-4 mt-5 border-top border-light-subtle">
    <section class="container-lg p-3">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            <div class="col mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('assets/image/brand/logo-brand.png') }}" alt="Logo Brand" style="width: 4rem;">
                    <h4 class="d-inline-block mx-3">olebsai</h4>
                </div>
                <p class="text-body" style="font-size: 14px;">
                    Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi
                    memajukan usaha lokal.
                </p>
                <div class="d-flex align-items-center mt-4">
                    <a href="#" target="_blank" class="d-inline-block mx-3" aria-label="Facebook"
                        rel="noopener noreferrer">
                        <i class="fa-brands fa-facebook" style="font-size: 32px;"></i>
                    </a>
                    <a href="#" target="_blank" class="d-inline-block mx-3" aria-label="Facebook"
                        rel="noopener noreferrer">
                        <i class="fa-brands fa-instagram" style="font-size: 32px;"></i>
                    </a>
                    <a href="#" target="_blank" class="d-inline-block mx-3" aria-label="Facebook"
                        rel="noopener noreferrer">
                        <i class="fa-brands fa-whatsapp" style="font-size: 32px;"></i>
                    </a>
                    <a href="#" target="_blank" class="d-inline-block mx-3" aria-label="Facebook"
                        rel="noopener noreferrer">
                        <i class="fa-brands fa-tiktok" style="font-size: 32px;"></i>
                    </a>
                </div>
            </div>
            <div class="col px-lg-5 mb-4">
                <strong class="d-block fw-semibold" style="font-size: 20px; margin:0;">Menu</strong>
                <div class="mx-0">
                    <a href="{{ url('about-us') }}" class="btn-footer my-1 text-decoration-none">
                        Tentang Kami
                    </a>
                    <a href="{{ url('shop') }}" class="btn-footer my-1 text-decoration-none">
                        Belanja
                    </a>
                    <a href="{{ url('/') }}" class="btn-footer my-1 text-decoration-none">
                        Beranda
                    </a>
                </div>
            </div>
            <div class="col px-lg-5 mb-4">
                <strong class="d-block fw-semibold" style="font-size: 20px; margin:0;">Akun Saya</strong>
                <div class="mx-0">
                    <a href="{{ url('user-setting') }}" class="btn-footer my-1 text-decoration-none">
                       Profile
                    </a>
                    <a href="{{ url('checkout-cart') }}" class="btn-footer my-1 text-decoration-none">
                       Keranjang
                    </a>
                    <a href="{{ url('order-history') }}" class="btn-footer my-1 text-decoration-none">
                        Transaksi
                    </a>
                </div>
            </div>
            <div class="col px-lg-5 mb-4">
                <strong class="d-block fw-semibold" style="font-size: 20px; margin:0;">Hubungi Kami</strong>
                <div class="mx-0">
                    <button type="button" class="btn-footer my-1 text-lg-end">
                        +62 089 273 78
                    </button>
                    <button type="button" class="btn-footer my-1">
                        olebsai@gmail.com
                    </button>
                </div>
            </div>
        </div>
    </section>
</footer>
<section class="w-100 d-flex align-items-center justify-content-center p-2 mt-0 border-top border-light-subtle">
    <span class="fw-semibold" style="font-size: 14px; color:#858585;">
        Copyright@2025 Olebsai. All Rights Reserved.</span>
</section>
