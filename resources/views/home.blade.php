@extends('layout.app')
@push('styles')
    <style>
        .slick-prev:before,
        .slick-next:before {
            color:
                #333;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">

        @if (Session::get('succes'))
            <div class="alert alert-important alert-success alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('succes') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        @if (Session::get('error'))
            <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 1215 5110 -10"></path>
                        </svg>
                    </div>
                    <div>{{ Session::get('error') }}</div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>

            </div>
        @endif

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
                    <img class="d-block w-100" alt=""
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStA1zREfwdFdKIgkJoGooLrFpQtrplGr88GtVKNwXeYQ&s=10" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcScz-swY9wyHGkhVgC0JDpwn2xcoyI2QgblzZXxhLReVg&s=10" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8VTbS_vNejy5RwktrzUeO9Yfosp8n7QKGriAe21Duaw&s=10" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://www.google.com/imgres?q=book%20festival%20banner&imgurl=https%3A%2F%2Fc8.alamy.com%2Fcomp%2F3A128FB%2Fbook-festival-colorful-banner-poster-design-template-vector-hand-drawn-sketch-illustration-flying-books-clouds-leaves-learning-and-education-creat-3A128FB.jpg&imgrefurl=https%3A%2F%2Fwww.alamy.com%2Fbook-festival-colorful-banner-poster-design-template-vector-hand-drawn-sketch-illustration-flying-books-clouds-leaves-learning-and-education-creat-image654659247.html&docid=6gqkDU0LSkRISM&tbnid=wnwLdcw_dbZxgM&vet=12ahUKEwix8vCKs8qWAxX5m-EIHQN7C08QnPAOegUIkQEQAA..i&w=1300&h=740&hcb=2&ved=2ahUKEwix8vCKs8qWAxX5m-EIHQN7C08QnPAOegUIkQEQAA" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" alt=""
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuKuNJhtjq9au_YH3VUeQOLX7U2s7kqB-uQl6GpzVacg&s" />
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

        <div class="mt-4">
            <div class="d-flex align-items-center">
                <span class="badge bg-yellow text-yellow-fg p-2"><i class="fa-solid fa-crown fs-3"></i></span>
                <h2 class="ms-3 text-dark"style="font-weight: bold;">Paket Langganan</h2>
            </div>
            <div class="row g-4 mt-2">
                @forelse ($subscriptionPackages as $package)
                    <div class="col-md-4">

                        <a href="{{ route('package.detail', $package->id) }}"
                            class="text-decoration-none text-reset d-block h-100">

                            <div class="card h-100"
                                style="background: linear-gradient(135deg, #ffffff 0%, {{ $package->color ?? '#d9f99d' }} 100%);">
                                <div class="card-body row">
                                    <div class="col-4"></div>
                                    <div class="col-6 text-center text-dark">
                                        <h2 style="font-weight: bold;">{{ strtoupper($package->name) }}</h2>
                                        <p class="text-secondary" style="font-weight: bold; margin: 0; !important">PACKAGE
                                        </p>
                                        <div>
                                            Rp <span style="font-size: 2rem; font-weight: bold;" class="text-warning">
                                                {{ number_format($package->price, 0, ',', '.') }}
                                            </span>

                                            <br>

                                            <span style="font-weight: bold; margin: 0 !important;" class="text-secondary">
                                                {{ $package->description }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada paket langganan.</div>
                    </div>
                @endforelse
            </div>


            <div class="mt-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <h2 class="mt-3 text-dark" style="font-weight: bold;">Buku Ini Baru Dirilis</h2>
                </div>

                <div id="wrapper-slider">
                    @forelse($latestBooks as $book)
                        <div class="px-2">
                            <div class="card">
                                <div class="card-body ">
                                    <img src="{{ asset($book->cover) }}" alt=""
                                        class="d-block mx-auto w-75 h-50">
                                    <div class="d-flex gap-2 mt-3">
                                        <span class="badge bg-secondary text-white"><i
                                                class="fa-solid fa-mobile-screen"></i>
                                            PDF</span>
                                        <span class="badge bg-primary text-white">3+</span>
                                    </div>
                                    <div>
                                        <h3><span style="font-size: 0.8rem"
                                                class="text-secondary">{{ $book->writer }}</span>
                                        </h3>
                                        <br><a href="{{ route('books.show', $book->id) }}" style="font-size: 1rem">
                                                  {{ $book->title }}</a>
                                        <h4 style="font-size: 1.2rem; font-weight: bold;">Rp
                                            {{ number_format($book->price, 0, ',', '.') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Tidak ada Buku terbaru yang tersedia</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <h2 class="mt-3 text-dark" style="font-weight: bold">Buku Gratis</h2>
                </div>
                <div class="row">
                    @forelse($freeBooks as $book)
                        <div class="col-4">
                            <div class="card d-flex flex-column">
                                <div class="row row-0 flex-fill">
                                    <div class="col-md-3">
                                        <a href="#">
                                            <img src="{{ asset($book->cover) }}" class="w-100 h-100 object-cover"
                                                alt="Card side image" />
                                        </a>
                                    </div>
                                    <div class="col">
                                        <div class="card-body h-full d-flex flex-column">
                                            <h3 class="card-title">
                                                <div class="badge"><i class="fa-solid fa-mobile"></i>PDF</div>
                                            </h3>
                                            <div class="text-secondary">
                                                Penulis
                                                <br><span class="text-dark">{{ $book->writer }}</span>
                                            </div>
                                            <div class="d-flex align-items-center pt-4 mt-auto">
                                                <h3><span class="text-decoration-line-through text-secondary">Rp
                                                        50.000</span> <span class="text-dark">Rp 0</span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Tidak ada Buku gratis yang tersedia</p>
                    @endforelse
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
                        responsive: [{
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
