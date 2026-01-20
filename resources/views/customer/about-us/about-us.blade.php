@extends('__layouts.__frontend.main')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection

@section('body')
    <section class="w-100 mt-3">
        <div class="d-none d-lg-block w-100 rounded-3 position-relative main-content" style="height: 55vh; overflow-y: hidden; overflow-x: hidden;">
            <div class="w-100 h-100 d-flex flex-column gap-1 align-items-center justify-content-center position-absolute top-0 start-0"
                style="z-index: 1;">
                <h1 class="fw-bold text-center text-white">
                    Belanja barang tradisional di Olebsai
                </h1>
                <span class="fs-6 fw-semibold text-center text-white">
                    Rasakan keindahan budaya, beli barang tradisional sekarang
                </span>
            </div>
            <img src="{{ asset('assets/image/aboutus/banner_about_1.jpg') }}" alt="Banner About" class="w-100 h-100 object-fit-cover object-position-center rounded-3">
            <div class="w-100 h-100 position-absolute top-0 start-0 custom-background"></div>
        </div>
        <div class="d-block d-lg-none w-100 rounded-3 position-relative main-content" style="height: 80vh; overflow: hidden;">
            <div class="w-100 h-100 d-flex px-4 flex-column gap-1 align-items-center justify-content-center position-absolute top-0 start-0"
                style="z-index: 1;">
                <h1 class="fw-bold text-left text-white">
                    Belanja barang tradisional di Olebsai
                </h1>
                <span class="fs-6 fw-semibold text-left text-white">
                    Rasakan keindahan budaya, beli barang tradisional sekarang
                </span>
            </div>
            <img src="{{ asset('assets/image/aboutus/banner_about_1.jpg') }}" alt="Banner About"
                class="w-100 h-100 object-fit-cover object-position-center rounded-3">
            <div class="w-100 h-100 position-absolute top-0 start-0 custom-background"></div>
        </div>
        <div class="w-100 d-flex flex-column align-items-lg-center justify-content-lg-center gap-2 py-5 about-content">
            <h6 class="fw-bold text-primary text-left text-lg-center">TENTANG KAMI</h6>
            <h4 class="fw-bold text-left text-lg-center">
                Tingkatkan koleksi Anda dengan barang-barang tradisional unik
            </h4>
            <span class="fs-6 fw-reguler text-left text-lg-center">
                Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi memajukan
                usaha lokal.
            </span>
        </div>
        <div class="w-full d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-5 py-5 mission-content">
            <div class="w-100 d-flex flex-column gap-2">
                <h6 class="fw-bold text-primary text-left">MISI KAMI</h6>
                <h4 class="fw-bold text-left">
                    Kami ingin membentuk dan memajukan usaha lokal di Indonesia
                </h4>
                <span class="fs-6 fw-reguler text-left">
                    Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke, dengan misi
                    memajukan
                    usaha lokal.
                </span>
            </div>
            <div class="w-100 rounded-3" style="height: 32vh; overflow: hidden;">
                <img src="{{ asset('assets/image/aboutus/content_about.jpg') }}"
                    class="w-100 h-100 object-fit-cover object-position-center" alt="">
            </div>
        </div>
        <div class="w-100 d-flex flex-column align-items-lg-center justify-content-lg-center gap-2 py-5">
            <h6 class="fw-bold text-primary text-left">DAMPAK & BISNIS KAMI</h6>
            <div class="w-full row row-cols-md-2 row-cols-lg-3 pt-3 impact-content">
                @foreach (range(1, 3) as $index)
                    <div class="col mb-3">
                        <div class="card-product shadow-sm">
                            <div class="image-product">
                                <img src="{{ asset('assets/image/aboutus/content_about.jpg') }}"
                                    class="w-100 h-100 object-fit-cover object-position-center" alt="">
                            </div>
                            <div class="content-product">
                                <a href="#">
                                    <span class="title-product">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    </span>
                                </a>
                                <p class="desc">
                                    Olebsai adalah platform untuk menjual produk UMKM dari Indonesia, khususnya Merauke,
                                    dengan
                                    misi
                                    memajukan
                                    usaha lokal.
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        const apiKey = $('meta[name="api-key"]').attr("content");
        
        $.ajax({
            url: 'api/about-us',
            type: 'GET',
            processData: false,
            contentType: false,
            headers: {
                "X-API-Key": apiKey 
            },
            success: function(response) {
                const mainContent = $('.main-content');
                const aboutContent = $('.about-content');
                const missionContent = $('.mission-content');
                const impactContent = $('.impact-content');
                
                const imageSite = (value) => {
                    return '{{ asset('uploads/aboutus') }}' + '/' + value;
                } 

                if (response.success) {
                    const dataset = response.data;
                    const mainData = dataset.find(data => data.key === 'main');
                    const aboutData = dataset.find(data => data.key === 'about');
                    const missionData = dataset.find(data => data.key === 'mission');
                    const impactData = dataset.filter(data => data.key === 'impact');

                    mainContent.find('h1').text(mainData.title);
                    mainContent.find('span').text(mainData.subtitle);
                    mainContent.find('img').attr('src', imageSite(mainData.image));

                    aboutContent.find('h4').text(aboutData.title);
                    aboutContent.find('span').text(aboutData.subtitle);

                    missionContent.find('h4').text(missionData.title);
                    missionContent.find('span').text(missionData.subtitle);
                    missionContent.find('img').attr('src', imageSite(missionData.image));

                    impactContent.html('');
                    impactData.forEach(data => {
                        impactContent.append(`
                            <div class="col mb-3">
                                <div class="card-product shadow-sm">
                                    <div class="image-product">
                                        <img src="${imageSite(data.image)}"
                                            class="w-100 h-100 object-fit-cover object-position-center" alt="">
                                    </div>
                                    <div class="content-product">
                                        <a href="#">
                                            <span class="title-product">
                                                ${data.title}
                                            </span>
                                        </a>
                                        <p class="desc">
                                            ${data.subtitle}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                    
                }
            }
        });
    </script>
@endsection
