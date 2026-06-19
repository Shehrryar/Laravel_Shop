@extends('front.layouts.app')
@section('content')
<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>{{trans("Searched Products")}}</h2>
        </div>
        <div class="row pb-3">
            @if(!empty($featured_products))
                    @foreach($featured_products as $f_product)
                            @php
                                $images_prod = $f_product->product_images()->first();
                                $inWishlist = $wishlist->contains('product_id', $f_product->id);
                                $getprice = getDiscountedPrice($f_product->id, $discount, $f_product->price);
                                $stockHandle = handleStock($f_product->id,0,0);

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
                                   
                                
                                    @if ($stockHandle['status'] == true)
                                    <a class="btn btn-dark" href="javascript:void(0)"
                                        onclick="addToCart({{ $f_product->id }}, {{ $getprice['discount_value'] }}, {{ $getprice['discounted_price'] }}, {{ $getprice['actual_price'] }})">
                                        <i class="fa fa-shopping-cart"></i> {{trans($stockHandle['message'])}}
                                    </a>
                                    @else
                                    <a class="btn btn-danger">
                                     {{trans($stockHandle['message'])}}
                                    </a>
                                    @endif


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
            @else
                <div class="col-md-12 text-center py-5">
                    <h3 style="color: #ff6b6b; font-weight: bold; font-size: 24px; text-transform: uppercase;">
                        The Searched Product is Not Found!
                    </h3>
                    <p style="color: #555; font-size: 16px;">
                        Please try another keyword or browse our categories for more products.
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3"
                        style="background-color: #007bff; border: none; padding: 10px 20px;">
                        Go to Homepage
                    </a>
                </div>
            @endif
            <div class="col-md-12 pt-5">
                @if (!empty($keyword))
                    {{$featured_products->withQueryString()}}
                @endif
            </div>
        </div>
    </div>
</section>
</main>
@endsection