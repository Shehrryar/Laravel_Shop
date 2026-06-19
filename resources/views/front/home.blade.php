@extends('front.layouts.app')
@section('content')
   




<section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-1-m.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-1.jpg')}}" />
                        <img src="{{asset('front-assets/images/carousel-1.jpg')}}" alt="" />
                    </picture>
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">{{trans("Kids Fashion")}}</h1>
                            <p class="mx-md-5 px-5">
                                {{trans("Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam")}}
                            </p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">{{trans("Shop Now")}}</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <picture>
                        <source media="(max-width: 799px)" srcset="images/carousel-2-m.jpg" />
                        <source media="(min-width: 800px)" srcset="images/carousel-2.jpg" />
                        <img src="{{asset('front-assets/images/carousel-2.jpg')}}" alt="" />
                    </picture>
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">{{trans("Womens Fashion")}}</h1>
                            <p class="mx-md-5 px-5">
                                {{trans("Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam")}}
                            </p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">{{trans("Shop Now")}}</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <picture>
                        <source media="(max-width: 799px)" srcset="images/carousel-3-m.jpg" />
                        <source media="(min-width: 800px)" srcset="images/carousel-3.jpg" />
                        <img src="{{asset('front-assets/images/carousel-2.jpg')}}" alt="" />
                    </picture>
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Clothes</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>









    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">{{ trans('Quality Product') }}</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">{{ trans('Free Shipping') }}</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">{{ trans('14-Day Return') }}</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">{{ trans('24/7 Support') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-3">
        <div class="container">
            <div class="section-title">
                <h2>{{trans("Categories")}}</h2>
            </div>
            <div class="row pb-3">
                @if(getcategories()->isNotEmpty())
                    @foreach(getcategories() as $category)
                        <div class="col-lg-3">
                            <div class="cat-card">
                                <div class="left">
                                    <img src='{{asset("upload/category/" . $category->image)}}' alt="" class="img-fluid">
                                </div>
                                <div class="right">
                                    <div class="cat-data">
                                        <h2>{{trans($category->name)}}</h2>
                                        <!-- <p>100 Products</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>{{trans("Recommended Products")}}</h2>
            </div>
            <div class="row pb-3">
                @if($recommended_products->isNotEmpty())
                        @foreach($recommended_products as $d_product)
                                @php
                                    $images_prod = $d_product->product_images()->first();
                                    $inWishlist = $wishlist->contains('product_id', $d_product->id);
                                    $getprice = getDiscountedPrice($d_product->id, $discount, $d_product->price);
                                    $stockHandle = handleStock($d_product->id, 0, 0);
                                @endphp
                                <div class="col-md-3">
                                    <div class="card product-card">
                                        <div class="product-image position-relative" style="border-bottom: 1px solid #ddd;">
                                            <a href="{{route('front.product', $d_product->slug)}}" class="product-img">
                                                @if(!empty($images_prod))
                                                    <img style="height: 250px; width: 250px;" class="card-img-top"
                                                        src="{{asset('upload/products/' . $images_prod->image)}}">
                                                @else
                                                    <img class="card-img-top" src="{{asset('admin-assets/img/default-150x150.png')}}">
                                                @endif
                                            </a>
                                            @if ($getprice['discount_value'] != 0)
                                                <div class="discount-badge">{{ $getprice['discount_value'] }}% OFF</div>
                                            @endif
                                            <!-- Horizontal line with custom styles -->
                                            <a onclick="addToWishlist({{$d_product->id}})" class="whishlist" href="javascript:void(0)">
                                                <i id="addwishlist{{$d_product->id}}" class="far fa-heart"
                                                    style="{{ $inWishlist ? 'display:none;' : '' }}"></i>
                                            </a>
                                            <a onclick="removefromWishlist({{$d_product->id}})" class="whishlist" href="javascript:void(0)">
                                                <i id="removewishlist{{$d_product->id}}" class="redhearticon fas fa-heart"
                                                    style="{{ $inWishlist ? '' : 'display:none;' }}"></i>
                                            </a>
                                        </div>
                                        <hr style="border: none; border-top: 2px solid #000; width: 50%; margin: 20px auto;">
                                        <!-- this is section for handling out of stock products -->



                                        <div class="card-body text-center">
                                            <a class="h6 link"
                                                href="{{route('front.product', $d_product->slug)}}">{{trans($d_product->title)}}</a>
                                            <div class="price mt-2">
                                                @if ($getprice['discounted_price'] != 0)
                                                    <span class="h5"><strong>{{$getprice['discounted_price']}}$</strong></span>
                                                    <span class="h5"><del>{{$getprice['actual_price']}}$</del></span>
                                                @else
                                                    <span class="h5"><strong>{{$getprice['actual_price']}}$</strong></span>
                                                @endif
                                            </div>
                                            <!-- Product Rating -->
                                            @php
                                                $avg_rating_per = 0;
                                                if ($d_product->product_ratings_count > 0) {
                                                    $avg_rating = number_format(($d_product->product_ratings_sum_rating /
                                                        $d_product->product_ratings_count), 2);
                                                    $avg_rating_per = ($avg_rating * 100) / 5;
                                                }
                                            @endphp
                                            <div style="display: flex; justify-content: center;">
                                                <div class="star-rating product mt-2" title="">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <div class="front-stars" style="width: {{$avg_rating_per}}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small class="pt-2 ps-1">({{$d_product->product_ratings_count}} Reviews)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                @endif
                <div class="col-md-12 pt-5">
                    {{$recommended_products->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </section>
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>{{trans("Featured Products")}}</h2>
            </div>
            <div class="row pb-3">
                @if($featured_products->isNotEmpty())
                        @foreach($featured_products as $f_product)
                                @php
                                    $images_prod = $f_product->product_images()->first();
                                    $inWishlist = $wishlist->contains('product_id', $f_product->id);
                                    $getprice = getDiscountedPrice($f_product->id, $discount, $f_product->price);
                                    $stockHandle = handleStock($f_product->id, 0, 0);
                                @endphp
                                <div class="col-md-3">
                                    <div class="card product-card">
                                        <div class="product-image position-relative" style="border-bottom: 1px solid #ddd;">
                                            <a href="{{route('front.product', $f_product->slug)}}" class="product-img">
                                                @if(!empty($images_prod))
                                                    <img style="height: 250px; width: 250px;" class="card-img-top"
                                                        src="{{asset('upload/products/' . $images_prod->image)}}">
                                                @else
                                                    <img class="card-img-top" src="{{asset('admin-assets/img/default-150x150.png')}}">
                                                @endif
                                            </a>
                                            @if ($getprice['discount_value'] != 0)
                                                <div class="discount-badge">{{ $getprice['discount_value'] }}% OFF</div>
                                            @endif
                                            <!-- Horizontal line with custom styles -->
                                            <a onclick="addToWishlist({{$f_product->id}})" class="whishlist" href="javascript:void(0)">
                                                <i id="addwishlist{{$f_product->id}}" class="far fa-heart"
                                                    style="{{ $inWishlist ? 'display:none;' : '' }}"></i>
                                            </a>
                                            <a onclick="removefromWishlist({{$f_product->id}})" class="whishlist" href="javascript:void(0)">
                                                <i id="removewishlist{{$f_product->id}}" class="redhearticon fas fa-heart"
                                                    style="{{ $inWishlist ? '' : 'display:none;' }}"></i>
                                            </a>
                                        </div>
                                        <hr style="border: none; border-top: 2px solid #000; width: 50%; margin: 20px auto;">
                                        <!-- this is section for handling out of stock products -->




                                        <div class="card-body text-center">
                                            <a class="h6 link"
                                                href="{{route('front.product', $f_product->slug)}}">{{trans($f_product->title)}}</a>
                                            <div class="price mt-2">
                                                @if ($getprice['discounted_price'] != 0)
                                                    <span class="h5"><strong>{{$getprice['discounted_price']}}$</strong></span>
                                                    <span class="h5"><del>{{$getprice['actual_price']}}$</del></span>
                                                @else
                                                    <span class="h5"><strong>{{$getprice['actual_price']}}$</strong></span>
                                                @endif
                                            </div>
                                            <!-- Product Rating -->
                                            @php
                                                $avg_rating_per = 0;
                                                if ($f_product->product_ratings_count > 0) {
                                                    $avg_rating = number_format(($f_product->product_ratings_sum_rating /
                                                        $f_product->product_ratings_count), 2);
                                                    $avg_rating_per = ($avg_rating * 100) / 5;
                                                }
                                            @endphp
                                            <div style="display: flex; justify-content: center;">
                                                <div class="star-rating product mt-2" title="">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <div class="front-stars" style="width: {{$avg_rating_per}}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small class="pt-2 ps-1">({{$f_product->product_ratings_count}} Reviews)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                @endif
                <div class="col-md-12 pt-5">
                    {{$featured_products->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </section>
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>{{trans("Latest Produsts")}}</h2>
            </div>
            <div class="row pb-3">
                @foreach($latest_product as $late_prod)
                            @php
                                $images_prod = $late_prod->product_images()->first();
                                $inWishlist = $wishlist->contains('product_id', $late_prod->id);
                                $getprice = getDiscountedPrice($late_prod->id, $discount, $late_prod->price);
                                $stockHandle = handleStock($late_prod->id, 0, 0);
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href='{{route("front.product", $late_prod->slug)}}' class="product-img">
                                            @if(!empty($images_prod))
                                                <img style="height: 250px; width: 250px;" class="card-img-top"
                                                    src="{{asset('upload/products/' . $images_prod->image)}}">
                                            @else
                                                <img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
                                            @endif
                                        </a>
                                        @if ($getprice['discount_value'] != 0)
                                            <div class="discount-badge">{{ $getprice['discount_value'] }}% OFF</div>
                                        @endif
                                        <a onclick="addToWishlist({{$late_prod->id}})" class="whishlist" href="javascript:void(0)">
                                            <i id="addwishlist{{ $late_prod->id }}" class="far fa-heart"
                                                style="{{ $inWishlist ? 'display:none;' : '' }}"></i>
                                        </a>
                                        <a onclick="removefromWishlist({{$late_prod->id}})" class="whishlist" href="javascript:void(0)">
                                            <i id="removewishlist{{$late_prod->id}}" class="redhearticon fas fa-heart"
                                                style="{{ $inWishlist ? '' : 'display:none;'}}"></i>
                                        </a>
                                    </div>
                                    <hr style="border: none; border-top: 2px solid #000; width: 50%; margin: 20px auto;">
                                    @if ($getprice['discount_value'] != 0)
                                        <div class="discount-badge">{{ $getprice['discount_value'] }}% OFF</div>
                                    @endif
                                    <!-- this is section for handling out of stock products -->
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="product.php">{{trans($late_prod->title)}}</a>
                                        <div class="price mt-2">
                                            @if ($getprice['discounted_price'] != 0)
                                                <span class="h5"><strong>{{$getprice['discounted_price']}}$</strong></span>
                                                <span class="h5"><del>{{$getprice['actual_price']}}$</del></span>
                                            @else
                                                <span class="h5"><strong>{{$getprice['actual_price']}}$</strong></span>
                                            @endif
                                        </div>
                                        <!-- this portion for the product rating -->
                                        @php
                                            $avg_rating_per = 0;
                                            if ($late_prod->product_ratings_count > 0) {
                                                $avg_rating = number_format(($late_prod->product_ratings_sum_rating /
                                                    $late_prod->product_ratings_count), 2);
                                                $avg_rating_per = ($avg_rating * 100) / 5;
                                            }
                                        @endphp
                                        <div style="display: flex; justify-content: center;">
                                            <div class="star-rating product mt-2" title="">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <div class="front-stars" style="width: {{$avg_rating_per}}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="pt-2 ps-1">({{$late_prod->product_ratings_count}} Reviews)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                @endforeach
                <div class="col-md-12 pt-5">
                    {{$latest_product->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </section>
    </main>
@endsection