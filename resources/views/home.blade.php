@extends('layout.app')

@push('styles')
    <style>
        .slick-prev:before,
        .slick-next:before {
            color: #d1b00b;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        {{-- Menampilkan pesan error dari middleware (misal: akses ditolak) --}}
        @if(session('error'))
            <div class="alert alert-important alert-danger alert-dismissible mb-4" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Icon Error / Peringatan -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9v4m0 4v.01"></path>
                            <path d="M5.07 19h13.86a2 2 0 0 0 1.75 -2.93l-6.93 -12c-.9 -1.53 -3.1 -1.53 -4 0l-6.93 12a2 2 0 0 0 1.75 2.93z"></path>
                        </svg>
                    </div>
                    <div>{{ session('error') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        {{-- Menampilkan pesan sukses (jika ada) --}}
        @if(session('success'))
            <div class="alert alert-important alert-success alert-dismissible mb-4" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ session('success') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        {{-- CAROUSEL --}}
        <div id="carousel-sample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#carousel-sample" data-bs-slide-to="4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" alt="" src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt="" src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt="" src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt="" src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt="" src="https://img.magnific.com/free-vector/hand-drawn-literature-twitter-header_23-2149721049.jpg?semt=ais_hybrid&w=740&q=80" />
                </div>
            </div>
            <a class="carousel-control-prev" data-bs-target="#carousel-sample" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" data-bs-target="#carousel-sample" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>

        {{-- PAKET LANGGANAN --}}
    <div class="mt-4">
            <div class="d-flex  align-items-center gap-2">
                <span class="badge bg-yellow text-yellow-fg p-2">
                    <i class="fa-solid fa-crown fs-3"></i>
                </span>

                <h2 class="mt-3 text-dark">Paket Langganan</h2>
            </div>

            <div class="row g-4">
                @foreach ($subscriptionPackages as $subscriptionPackage)
                <div class="col-md-4">
                    <div class="card h-100" style="background: linear-gradient(135deg, #ffffff 0%, {{ $subscriptionPackage->color }} 100%);">
                        <div class="card-body row">
                            <div class="col-4"></div>
                            <div class="col-6 text-center text-dark">
                                <h2 style="font-weight: bold;">{{ strtoupper($subscriptionPackage->name) }}</h2>
                                <p class="text-secondary" style="font-weight: bold; margin: 0; !important">PACKAGE</p>
                                <div>
                                    Rp <span
                                        style="font-size: 2rem;
                                             font-weight: bold;
                                             "
                                        class="text-warning">
                                        {{ number_format($subscriptionPackage->price, 0, ',', '.') }}
                                    </span>

                                    <br>
                                    <span
                                        style="font-weight: bold;
                                                margin: 0;
                                                !important"
                                        class="text-secondary">
                                        @if(filled(trim($subscriptionPackage->description ?? '')))
                                            {{ $subscriptionPackage->description }}
                                        @else
                                            PAKET LENGKAP
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- BUKU BARU DIRILIS --}}
        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-4 ps-3">
                <h2 class="mt-3 text-dark" style="font-weight: bold;">Buku Baru Di Rilis</h2>
            </div>
            <div id="wrapper-slider">
                <div class="px-2">
                    <div class="card h-100">
                        <div class="card-body p-2 d-flex align-items-center justify-content-center" style="height: 220px;">
                            <img class="mw-100 mh-100" style="object-fit: contain;" alt="Game Of Thrones" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVkb5C7mRPryCEJ7oJJItAGt4xd2xo6ZvmixTGhJ7iBQ&s">
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge"><i class="fa-solid fa-mobile me-1"></i>PDF</span>
                                <span class="badge">3+</span>
                            </div>
                            <h5>
                                <span style="font-size: 0.8rem;" class="text-secondary">George R. R. Martin</span><br>
                                <span style="font-size: 1rem;">Game Of Thrones</span>
                            </h5>
                            <h4 style="font-size: 1.2rem; font-weight: bold;" class="mb-0">Rp 200.000</h4>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="card h-100">
                        <div class="card-body p-2 d-flex align-items-center justify-content-center" style="height: 220px;">
                            <img class="mw-100 mh-100" style="object-fit: contain;" alt="Star Wars" src="https://m.media-amazon.com/images/I/9142aVsnMUL._AC_UF1000,1000_QL80_.jpg">
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge"><i class="fa-solid fa-mobile me-1"></i>PDF</span>
                                <span class="badge">3+</span>
                            </div>
                            <h5>
                                <span style="font-size: 0.8rem;" class="text-secondary">George Lucas</span><br>
                                <span style="font-size: 1rem;">Star Wars - The Empire Strikes Back</span>
                            </h5>
                            <h4 style="font-size: 1.2rem; font-weight: bold;" class="mb-0">Rp 110.000</h4>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="card h-100">
                        <div class="card-body p-2 d-flex align-items-center justify-content-center" style="height: 220px;">
                            <img class="mw-100 mh-100" style="object-fit: contain;" alt="It" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_6Nypmn9hqhUqO3QBDD0z3UA_LFqXj4JwQ3oeAbRrA9vu7uEW4OVA_xk&s=10">
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge"><i class="fa-solid fa-mobile me-1"></i>PDF</span>
                                <span class="badge">3+</span>
                            </div>
                            <h5>
                                <span style="font-size: 0.8rem;" class="text-secondary">Stephen King</span><br>
                                <span style="font-size: 1rem;">It</span>
                            </h5>
                            <h4 style="font-size: 1.2rem; font-weight: bold;" class="mb-0">Rp 70.000</h4>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="card h-100">
                        <div class="card-body p-2 d-flex align-items-center justify-content-center" style="height: 220px;">
                            <img class="mw-100 mh-100" style="object-fit: contain;" alt="Harry Potter" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd4on5R00o4KcRu9BqMPQwtZEdFAGdYMx3KGjrakuxsg&s=10">
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge"><i class="fa-solid fa-mobile me-1"></i>PDF</span>
                                <span class="badge">3+</span>
                            </div>
                            <h5>
                                <span style="font-size: 0.8rem;" class="text-secondary">Faza Meonk</span><br>
                                <span style="font-size: 1rem;">Harry Potter And The Philosopher's Stone</span>
                            </h5>
                            <h4 style="font-size: 1.2rem; font-weight: bold;" class="mb-0">Rp 90.000</h4>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="card h-100">
                        <div class="card-body p-2 d-flex align-items-center justify-content-center" style="height: 220px;">
                            <img class="mw-100 mh-100" style="object-fit: contain;" alt="Si Juki" src="https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/719011174_Si_Juki_Seri_Jalan_Jalan_Petualangan_di_Thailand.jpg">
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge"><i class="fa-solid fa-mobile me-1"></i>PDF</span>
                                <span class="badge">3+</span>
                            </div>
                            <h5>
                                <span style="font-size: 0.8rem;" class="text-secondary">Faza Meonk</span><br>
                                <span style="font-size: 1rem;">Si Juki: Seri Jalan-jalan Petualangan di Thailand</span>
                            </h5>
                            <h4 style="font-size: 1.2rem; font-weight: bold;" class="mb-0">Rp 60.000</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BUKU GRATIS --}}
        <div class="mt-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <h2 class="mt-3 text-dark" style="font-weight: bold">Buku Gratis</h2>
            </div>

            <div class="row g-3">
                {{-- Item Buku Gratis 1 --}}
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://cdn.gramedia.com/uploads/items/9786237219637.jpg" class="w-100 h-100 object-cover" alt="Card side image" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Mohammad Hatta
                                        <br><span class="text-dark">Mohammad Hatta</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp 50.000</span>
                                            <span class="text-dark">Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item Buku Gratis 2 --}}
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://cdn.gramedia.com/uploads/items/9786237219637.jpg" class="w-100 h-100 object-cover" alt="Card side image" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Mohammad Hatta
                                        <br><span class="text-dark">Mohammad Hatta</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp 50.000</span>
                                            <span class="text-dark">Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Item Buku Gratis 3 --}}
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="row row-0 flex-fill">
                            <div class="col-md-4">
                                <a href="#">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7zIEw6UwumgahLPHg-ObEAGNaskP26xXfATGG-q5XoQ&s=10" class="w-100 h-100 object-cover" alt="Card side image" />
                                </a>
                            </div>
                            <div class="col">
                                <div class="card-body h-full d-flex flex-column">
                                    <h3 class="card-title">
                                        <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                    </h3>
                                    <div class="text-secondary">
                                        Leila S
                                        <br><span class="text-dark">Laut Bercerita</span>
                                    </div>
                                    <div class="d-flex align-items-center pt-4 mt-auto">
                                        <h3>
                                            <span class="text-decoration-line-through text-secondary">Rp 50.000</span>
                                            <span class="text-dark">Rp 0</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#wrapper-slider').slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>
@endpush
