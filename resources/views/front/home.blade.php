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
            <h2>{{trans("Featured Products")}}</h2>
        </div>
        <div class="row pb-3">
            @if($featured_products->isNotEmpty())
                    @foreach($featured_products as $f_product)
                            @php
                                $images_prod = $f_product->product_images()->first();
                                $inWishlist = $wishlist->contains('product_id', $f_product->id);
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative" style="border-bottom: 1px solid #ddd;">
                                        <a href="{{route('front.product', $f_product->slug)}}" class="product-img">
                                            @if(!empty($images_prod))
                                                <img class="card-img-top" src="{{asset('upload/products/' . $images_prod->image)}}">
                                            @else
                                                <img class="card-img-top" src="{{asset('admin-assets/img/default-150x150.png')}}">
                                            @endif
                                        </a>

                                        <!-- Horizontal line with custom styles -->

                                        <a onclick="addToWishlist({{$f_product->id}})" class="whishlist" href="javascript:void(0)">
                                            <i id="addwishlist{{$f_product->id}}" class="far fa-heart"
                                                style="{{ $inWishlist ? 'display:none;' : '' }}"></i>
                                        </a>
                                        <a onclick="removefromWishlist({{$f_product->id}})" class="whishlist" href="javascript:void(0)">
                                            <i id="removewishlist{{$f_product->id}}" class="redhearticon fas fa-heart"
                                                style="{{ $inWishlist ? '' : 'display:none;' }}"></i>
                                        </a>

                                        <!-- Discount Badge -->
                                        @if($f_product->compare_price > 0)
                                            <div class="discount-badge position-absolute top-0 start-0 bg-danger text-white px-2 py-1">
                                                {{ round((($f_product->compare_price - $f_product->price) / $f_product->compare_price) * 100) }}%
                                                OFF
                                            </div>
                                        @endif

                                        <!-- Out of Stock Overlay -->
                                        @if ($f_product->qty <= 0)
                                            <div
                                                class="out-of-stock-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 text-white">
                                                {{ trans("Out of Stock") }}
                                            </div>
                                        @endif
                                    </div>
                                    <hr style="border: none; border-top: 2px solid #000; width: 50%; margin: 20px auto;">

                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link"
                                            href="{{route('front.product', $f_product->slug)}}">{{trans($f_product->title)}}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>{{$f_product->price}}$</strong></span>
                                            @if($f_product->compare_price > 0)
                                                <span class="h6 text-underline"><del>{{$f_product->compare_price}}$</del></span>
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

                                        <!-- Add to Cart Button -->
                                        <div class="product-action mt-3">
                                            @if ($f_product->qty > 0)
                                                <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$f_product->id}})">
                                                    <i class="fa fa-shopping-cart"></i> {{trans('Add To Cart')}}
                                                </a>
                                            @else
                                                <a class="btn btn-dark" href="javascript:void(0)">
                                                    <i class="fa fa-shopping-cart"></i> {{trans('Out of Stock')}}
                                                </a>
                                            @endif
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
                        @endphp
                        <div class="col-md-3">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href='{{route("front.product", $late_prod->slug)}}' class="product-img">
                                        @if(!empty($images_prod))
                                            <img class="card-img-top" src="{{asset('upload/products/' . $images_prod->image)}}">
                                        @else
                                            <img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
                                        @endif
                                    </a>
                                    <a onclick="addToWishlist({{$late_prod->id}})" class="whishlist" href="javascript:void(0)">
                                        <i id="addwishlist{{ $late_prod->id }}" class="far fa-heart"
                                            style="{{ $inWishlist ? 'display:none;' : '' }}"></i>
                                    </a>
                                    <a onclick="removefromWishlist({{$late_prod->id}})" class="whishlist" href="javascript:void(0)">
                                        <i id="removewishlist{{$late_prod->id}}" class="redhearticon fas fa-heart"
                                            style="{{ $inWishlist ? '' : 'display:none;'}}"></i>

                                    </a>

                                    <div class="product-action">
                                        @if ($late_prod->qty > 0)
                                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$late_prod->id}})">
                                                <i class="fa fa-shopping-cart"></i> {{trans("Add To Cart")}}
                                            </a>
                                        @else
                                            <a class="btn btn-dark" href="javascript:void(0)">
                                                <i class="fa fa-shopping-cart"></i> {{trans("Out of Stock")}}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{trans($late_prod->title)}}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{$late_prod->price}}$</strong></span>
                                        @if($late_prod->compare_price > 0)
                                            <span class="h6 text-underline"><del>{{$late_prod->compare_price}}$</del></span>
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