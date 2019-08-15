@extends('layouts.home')

@section('content')
    <section class="p-0 overflow-hidden">
        <div class="owl-carousel" ya-carousel="autoplay: true;height: true">

            <div class="owl-carousel-item">
                <img src="img/carousel-1.jpg" ya-style="opacity: .28" alt="">
                <div class="owl-caption">
                    <div class="owl-caption-container">
                        <h1 class="owl-title">The Witcher 3: Wild Hunt</h1>
                        <p class="owl-text">The world is in chaos. The air is thick with tension and the smoke of burnt villages. The fearsome Empire of Nilfgaard has struck again, ravaging the hapless.</p>
                        <a class="btn btn-primary btn-lg btn-rounded" href="game-post.html" role="button">View Game</a>
                        <a class="btn btn-outline-light btn-lg btn-rounded ml-2" href="https://www.youtube.com/watch?v=c0i88t0Kacs" ya-lightbox role="button">Watch Trailer</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- end .owl-carousel -->
    </section>
{{--    <section class="py-5 py-md-6">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-11 col-md-8 text-center mx-auto mb-4">--}}
{{--                    <i class="ya ya-ranking icon"></i>--}}
{{--                    <h2 class="font-weight-bold font-size-lg">Recent Games at Gameforest</h2>--}}
{{--                    <p class="lead">Two assure edward whence the was. Who worthy yet ten boy denote wonder. Weeks views her sight old tears sorry.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="card card-sm">--}}
{{--                        <a class="card-img card-img-lg" href="game-post.html">--}}
{{--                            <img class="card-img-top" src="https://img.youtube.com/vi/HYrcX8QIIAs/maxresdefault.jpg" alt="God of War">--}}
{{--                        </a>--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">--}}
{{--                                <i class="ya ya-check-circle text-success" data-toggle="tooltip" data-placement="bottom" data-title="Available"></i>--}}
{{--                                <a href="game-post.html">God of War</a>--}}
{{--                            </h5>--}}
{{--                            <p class="card-tex font-size-md mb-0">His vengeance against the Gods of Olympus years behind him, Kratos now lives as a man in the realm of Norse Gods and mon...</p>--}}
{{--                        </div>--}}
{{--                        <div class="card-footer">--}}
{{--                            <span><i class="ya ya-calendar"></i> April 23, 2018</span>--}}
{{--                            <div class="ml-auto">--}}
{{--                                <a href="#"><i class="ya ya-comment"></i> 675</a>--}}
{{--                                <a class="ml-1" href="#"><i class="ya ya-heart-o"></i> 49</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- end .card -->--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="card card-sm">--}}
{{--                        <a class="card-img card-img-lg" href="game-post.html">--}}
{{--                            <span class="badge badge-danger">new</span>--}}
{{--                            <img class="card-img-top" src="https://img.youtube.com/vi/reAPorQHxNQ/maxresdefault.jpg" alt="Marvel's Spider-Man">--}}
{{--                        </a>--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">--}}
{{--                                <i class="ya ya-check-circle text-success" data-toggle="tooltip" data-placement="bottom" data-title="Available"></i>--}}
{{--                                <a href="game-post.html">Marvel's Spider-Man</a>--}}
{{--                            </h5>--}}
{{--                            <p class="card-tex font-size-md mb-0">This isn’t the Spider-Man you’ve met or ever seen before. After eight years behind the mask, Peter Parker is more experi...</p>--}}
{{--                        </div>--}}
{{--                        <div class="card-footer">--}}
{{--                            <span><i class="ya ya-calendar"></i> September 12, 2018</span>--}}
{{--                            <div class="ml-auto">--}}
{{--                                <a href="#"><i class="ya ya-comment"></i> 103</a>--}}
{{--                                <a class="ml-1" href="#"><i class="ya ya-heart-o"></i> 581</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- end .card -->--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="card card-sm">--}}
{{--                        <a class="card-img card-img-lg" href="game-post.html">--}}
{{--                            <img class="card-img-top" src="https://img.youtube.com/vi/MVTHYMkDvIs/maxresdefault.jpg" alt="Forza Horizon 4">--}}
{{--                        </a>--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">--}}
{{--                                <i class="ya ya-check-circle text-success" data-toggle="tooltip" data-placement="bottom" data-title="Available"></i>--}}
{{--                                <a href="game-post.html">Forza Horizon 4</a>--}}
{{--                            </h5>--}}
{{--                            <p class="card-tex font-size-md mb-0">In Forza Horizon 4, you’re in charge of the Horizon Seasons. Customize everything, hire and fire your friends, and explo...</p>--}}
{{--                        </div>--}}
{{--                        <div class="card-footer">--}}
{{--                            <span><i class="ya ya-calendar"></i> October 05, 2018</span>--}}
{{--                            <div class="ml-auto">--}}
{{--                                <a href="#"><i class="ya ya-comment"></i> 89</a>--}}
{{--                                <a class="ml-1" href="#"><i class="ya ya-heart-o"></i> 44</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- end .card -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="text-center">--}}
{{--                <a class="btn btn-secondary btn-lg mt-3" href="games.html" role="button">Browse Games</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section>--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-xl-10 px-0 mx-auto">--}}
{{--                    <div class="d-flex align-items-center position-relative overflow-hidden py-5 py-md-7 px-3 px-xl-0" data-parallax="scroll" data-image-src="https://img.youtube.com/vi/uPhovNvisWI/maxresdefault.jpg" style="min-height: 500px">--}}
{{--                        <div class="overlay" ya-style="background-color: #292b2f"></div>--}}
{{--                        <div class="container">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-8 order-2 order-md-1 text-center text-sm-left">--}}
{{--                                    <h2 class="display-5 font-weight-bold text-white">Castlevania Review</h2>--}}
{{--                                    <p class="text-light">Konami's famed vampire hunting series made its debut on the PlayStation with Castlevania: Lament of Innocence. It tells the story of the Belmont family's first encounter...</p>--}}
{{--                                    <div class="d-flex d-sm-block flex-column mt-3 pt-3">--}}
{{--                                        <a class="btn btn-primary btn-shadow btn-rounded btn-lg mb-2 mb-sm-0" href="review-post.html" role="button">Read Review</a>--}}
{{--                                        <a class="btn btn-outline-light btn-rounded btn-lg ml-sm-2" href="#" role="button">Write Review <i class="ya ya-pen"></i></a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4 order-1 order-md-2 d-flex align-items-md-center justify-content-center justify-content-md-end text-center mb-4 mb-md-0">--}}
{{--                                    <div>--}}
{{--                                        <p class="font-weight-semibold text-white d-none d-md-inline-block">Gameforest</p>--}}
{{--                                        <a class="easypiechart" href="review-post.html" data-percent="89" data-scale-color="#e3e3e3" data-bar-color="#5eb404"><span class="easypiechart-text">89%</span></a>--}}
{{--                                    </div>--}}
{{--                                    <div class="ml-3 d-none d-md-inline-block">--}}
{{--                                        <p class="font-weight-semibold text-white">MetaCritic</p>--}}
{{--                                        <a class="review-score" href="review-post.html">9.1</a>--}}
{{--                                    </div>--}}
{{--                                    <div class="ml-3 d-none d-md-inline-block">--}}
{{--                                        <p class="font-weight-semibold text-white">Users</p>--}}
{{--                                        <a class="review-score" href="review-post.html">9.4</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="py-md-6">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-11 col-md-8 text-center mx-auto mb-4">--}}
{{--                    <i class="ya ya-time-alarm icon"></i>--}}
{{--                    <h2 class="font-weight-bold font-size-lg">Recent News at Gameforest</h2>--}}
{{--                    <p class="lead">May indulgence difficulty ham can put especially. Bringing remember for supplied her why was confined. Middleton principle did she procuring.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="card card-sm">--}}
{{--                        <a class="card-img" href="blog-post.html">--}}
{{--                            <img src="https://img.youtube.com/vi/PfQ8cOyuE1A/maxresdefault.jpg" alt="">--}}
{{--                        </a>--}}
{{--                        <div class="card-body">--}}
{{--                            <h6 class="card-title"><a href="blog-post.html">Battle royale games explained what could be the next big hit</a></h6>--}}
{{--                            <div class="card-meta">--}}
{{--                                <span class="card-meta-item"><i class="ya ya-calendar"></i> September 10, 2018</span>--}}
{{--                                <a class="card-meta-item" href="blog-post.html"><i class="ya ya-comment"></i> 20 comments</a>--}}
{{--                            </div>--}}
{{--                            <p class="card-text">Debating me breeding be answered an he. Spoil event was words her off cause any. Tears woman which no is ...</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- end .card-post -->--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="card card-sm">--}}
{{--                        <a class="card-img" href="blog-post-carousel.html">--}}
{{--                            <img src="https://img.youtube.com/vi/gJ56BJ-Ba9E/maxresdefault.jpg" alt="">--}}
{{--                        </a>--}}
{{--                        <div class="card-body">--}}
{{--                            <h6 class="card-title"><a href="blog-post-carousel.html">BioWare's Anthem Shows An Exciting New Direction For The Studio</a></h6>--}}
{{--                            <div class="card-meta">--}}
{{--                                <span class="card-meta-item"><i class="ya ya-calendar"></i> September 05, 2018</span>--}}
{{--                                <a class="card-meta-item" href="blog-post-carousel.html"><i class="ya ya-comment"></i> 12 comments</a>--}}
{{--                            </div>--}}
{{--                            <p class="card-text">Promotion an ourselves up otherwise my. High what each snug rich far yet easy. In companions inhabiting m...</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- end .card-post -->--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="card card-sm">--}}
{{--                        <a class="card-img" href="blog-post-video.html">--}}
{{--                            <img src="https://img.youtube.com/vi/SG4hoev5uaI/maxresdefault.jpg" alt="">--}}
{{--                        </a>--}}
{{--                        <div class="card-body">--}}
{{--                            <h6 class="card-title"><a href="blog-post-video.html">New Red Dead Redemption 2 Character Art Appears As Massive Billboards</a></h6>--}}
{{--                            <div class="card-meta">--}}
{{--                                <span class="card-meta-item"><i class="ya ya-calendar"></i> September 10, 2018</span>--}}
{{--                                <a class="card-meta-item" href="blog-post-video.html"><i class="ya ya-comment"></i> 49 comments</a>--}}
{{--                            </div>--}}
{{--                            <p class="card-text">Ever man are put down his very. And marry may table him avoid. Hard sell it were into it upon. He forbade...</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- end .card-post -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="text-center mt-2 mb-3">--}}
{{--                <a class="btn btn-secondary btn-lg" href="blog.html" role="button">Read More</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="bg-image py-0 py-lg-3 py-xl-6" ya-style="background-color: #2e2f2f">--}}
{{--        <img class="background" src="https://img.youtube.com/vi/IZyJlfEVoQg/maxresdefault.jpg" alt="">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-xl-8 mx-auto">--}}
{{--                    <div ya-embed="https://www.youtube.com/watch?v=gOE2BVRCUkM" ya-title="God of War: Gameplay Trailer 2018" ya-length="15:05">--}}
{{--                        <img src="https://img.youtube.com/vi/IZyJlfEVoQg/maxresdefault.jpg" alt="">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="bg-primary py-0">--}}
{{--        <div class="container">--}}
{{--            <div class="promo">--}}
{{--                <h2 class="promo-title h4">Build your professional gaming website with Gameforest</h2>--}}
{{--                <a class="btn btn-outline-light mt-4 mt-lg-0 ml-md-4" href="https://themeforest.net/item/gameforest-responsive-gaming-html-theme/5007730" target="_blank" role="button">Purchase Now <i class="ya ya-shopping-cart"></i></a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
@endsection
