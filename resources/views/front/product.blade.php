@extends('front.layouts.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">{{$product->title}}</li>
            </ol>
        </div>
    </div>
</section>
<section class="section-7 pt-3 mb-3">
    <div class="container">
        @include('front.account.common.message')
        <div class="row">
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @if($product->product_images)
                            @foreach($product->product_images as $key => $productImage)
                                <div class="carousel-item {{($key == 0) ? 'active' : ''}}">
                                    <img class="w-100 h-100" id="product-image"
                                        src="{{asset('upload/products/' . $productImage->image)}}" alt="Image">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    @php
                        $getprice = getDiscountedPrice($product->id, $discount, $product->price);
                        $stockHandle = handleStock($product->id, 0, 0);
                    @endphp
                    @if ($getprice['discount_value'] != 0)
                            <div style="display:flex;"></div>
                            <h1>{{$product->title}}</h1>
                            <div class="discount-banner">{{$getprice['discount_value']}}% OFF</div>
                        </div>
                    @else
                        <h1>{{$product->title}}</h1>
                    @endif
                <div class="d-flex mb-3">
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
                    <small class="pt-2 ps-1">({{$product->product_ratings_count}} Reviews)</small>
                </div>
                <p>{{$product->short_description}}</p>


               

                <input type="hidden" name="base_price" class="v_base_price"
                    value="{{ $getprice['discounted_price'] > 0 ? $getprice['discounted_price'] : $getprice['actual_price'] }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">



                @if ($product->size()->exists())
                    <div class="details_size">
                        <h5>Select Size</h5>
                        <div class="col-sm-5">
                            <select class="form-control v_product_size" name="product_size" id="size" required>
                                <option value=null>Select Size</option>
                                @foreach ($product->size as $productSize)
                                    <option id="size-{{ $productSize->id }}" value="{{ $productSize->id }}"
                                        data-name="{{ $productSize->price }}">{{ $productSize->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                @if ($product->color()->exists())
                    <div class="details_extra_item">
                        <h5>Select Colour</h5>
                        <div class="col-sm-5">
                            <select class="form-control v_product_option" name="product_option" id="color" required>
                                <option value=null>Select Colour</option>
                                @foreach ($product->color as $productOption)
                                    <option id="option-{{ $productOption->id }}" value="{{ $productOption->id }}"
                                        data-name="{{ $productOption->price }}">{{ $productOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                <div class="details_quentity">
                    <h5>Select Quantity</h5>
                    <div class="quentity_btn_area d-flex flex-wrap align-items-center">
                        <div class="quentity_btn">
                            <button class="btn btn-secondary v_decrement"><i class="fal fa-minus"></i></button>
                            <input type="text" name="quantity" placeholder="1" value="1" readonly id="v_quantity">
                            <button class="btn btn-secondary v_increment"><i class="fal fa-plus"></i></button>
                        </div>
                        <h3 id="v_total_price">
                            @if ($getprice['discounted_price'] != 0)
                                <span id="discounted-price"
                                    class="h5"><strong>{{$getprice['discounted_price']}}$</strong></span>
                                <span id="actual-price" class="h5"><del>{{$getprice['actual_price']}}$</del></span>
                            @else
                                <span id="discounted-price" class="h5"><strong></strong></span>
                                <span id="actual-price" class="h5"><strong>{{$getprice['actual_price']}}$</strong></span>
                            @endif
                        </h3>
                    </div>
                </div>

                @if ($stockHandle['status'] == true)
                    <a href="javascript:void(0)"
                        onclick="addToCart({{ $product->id }}, {{ $getprice['discount_value'] }}, {{ $getprice['discounted_price'] }}, {{ $getprice['actual_price'] }},'')"
                        class="btn btn-dark" id="addtocart"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                @else
                    <a class="btn btn-danger">{{trans($stockHandle['message'])}}</a>
                @endif
                <a disabled id="outofstockutton" class="btn btn-danger"
                    style="display:none;">{{trans('Out of Stock')}}</a>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="bg-light">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab" aria-controls="description"
                            aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                            type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping &
                            Returns</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                            type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                        aria-labelledby="description-tab">
                        <p>{{$product->description}}</p>
                    </div>
                    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                        <p>{{$product->shipping_returns}}</p>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="col-md-8">
                            <div class="row">
                                <form action="" name="productratingform" id="productratingform" method="Post">
                                    <h3 class="h4 pb-3">Write a Review</h3>
                                    <div class="form-group mb-3">
                                        <label for="rating">Rating</label>
                                        <br>
                                        <div id="rating" class="rating" style="width: 10rem">
                                            <input id="rating-5" type="radio" name="rating" value="5" /><label
                                                for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-4" type="radio" name="rating" value="4" /><label
                                                for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-3" type="radio" name="rating" value="3" /><label
                                                for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-2" type="radio" name="rating" value="2" /><label
                                                for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                            <input id="rating-1" type="radio" name="rating" value="1" /><label
                                                for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                        </div>
                                        <p></p>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">How was your overall experience?</label>
                                        <textarea name="review" id="review" class="form-control" cols="30" rows="10"
                                            placeholder="How was your overall experience?"></textarea>
                                        <p></p>
                                    </div>
                                    <div>
                                        <button class="btn btn-dark">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="overall-rating mb-3">
                                <div class="d-flex">
                                    <h1 class="h3 pe-3">{{$avg_rating}}</h1>
                                    <div class="star-rating mt-2" title="">
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
                                    <div class="pt-2 ps-2">({{$product->product_ratings_count}} Reviews)</div>
                                </div>
                            </div>
                            @if ($product->product_ratings->isNotEmpty())
                                                    @foreach ($product->product_ratings as $rating)
                                                                            @php
                                                                                $ratingper = ($rating->rating * 100) / 5
                                                                            @endphp
                                                                            <div class="rating-group mb-4">
                                                                                <span><strong>{{$rating->username}}</strong></span>
                                                                                <div class="star-rating mt-2" title="">
                                                                                    <div class="back-stars">
                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                        <div class="front-stars" style="width:{{$ratingper}}%">
                                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="my-3">
                                                                                    <p>{{$rating->comment}}</p>
                                                                                </div>
                                                                            </div>
                                                    @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="pt-5 section-8">
    <div class="container">
        <div class="section-title">
            <h2>Related Products</h2>
        </div>
        <div class="col-md-12">
            <div id="related-products" class="carousel">
                @if(!empty($showrelatedproduct))
                            @foreach ($showrelatedproduct as $relatedproduct)
                                        @php
                                            $images_prod = $relatedproduct->product_images()->first();
                                            $inWishlist = $wishlist->contains('product_id', $relatedproduct->id);
                                            $getprice = getDiscountedPrice($relatedproduct->id, $discount, $product->price);
                                            $stockHandle = handleStock($relatedproduct->id, 0, 0);
                                        @endphp
                                        <div class="card product-card">
                                            <div class="product-image position-relative">
                                                <a href="{{route("front.product", $relatedproduct->slug)}}" class="product-img">
                                                    @if(!empty($images_prod))
                                                        <img class="card-img-top" src="{{asset('upload/products/' . $images_prod->image)}}">
                                                    @else
                                                        <img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
                                                    @endif
                                                </a>
                                                @if ($getprice['discount_value'] != 0)
                                                    <div class="discount-badge">{{ $getprice['discount_value'] }}% OFF</div>
                                                @endif
                                                <a onclick="addToWishlist({{$relatedproduct->id}})" class="whishlist" href="javascript:void(0)">
                                                    <i id="addwishlist{{$relatedproduct->id}}" class="far fa-heart"
                                                        style="{{ $inWishlist ? 'display:none;' : '' }}"></i>
                                                </a>
                                                <a onclick="removefromWishlist({{$relatedproduct->id}})" class="whishlist"
                                                    href="javascript:void(0)">
                                                    <i id="removewishlist{{$relatedproduct->id}}" class="redhearticon fas fa-heart"
                                                        style="{{ $inWishlist ? '' : 'display:none;' }}"></i>
                                                </a>
                                            </div>
                                            <hr style="border: none; border-top: 2px solid #000; width: 50%; margin: 20px auto;">
                                            @if ($stockHandle['status'] == true)
                                                <a class="btn btn-dark" href="javascript:void(0)"
                                                    onclick="addToCart({{ $relatedproduct->id }}, {{ $getprice['discount_value'] }}, {{ $getprice['discounted_price'] }}, {{ $getprice['actual_price'] }})">
                                                    <i class="fa fa-shopping-cart"></i> {{trans($stockHandle['message'])}}
                                                </a>
                                            @else
                                                <a class="btn btn-danger">
                                                    {{trans($stockHandle['message'])}}
                                                </a>
                                            @endif
                                            <div class="card-body text-center mt-3">
                                                <a class="h6 link" href="">{{$relatedproduct->title}}</a>
                                                <div class="price mt-2">
                                                    <span class="h5"><strong>{{$relatedproduct->price}}$</strong></span>
                                                    @if($relatedproduct->compare_price > 0)
                                                        <span class="h6 text-underline"><del>{{$relatedproduct->compare_price}}$</del></span>
                                                    @endif
                                                </div>
                                                @php
                                                    $avg_rating_per = 0;
                                                    if ($relatedproduct->product_ratings_count > 0) {
                                                        $avg_rating = number_format(($relatedproduct->product_ratings_sum_rating / $relatedproduct->product_ratings_count), 2);
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
                                                    <small class="pt-2 ps-1">({{$relatedproduct->product_ratings_count}} Reviews)</small>
                                                </div>
                                            </div>
                                        </div>
                            @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
@section('customJs')
    <script>
        $(document).ready(function () {
            $("#productratingform").submit(function (event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route("front.productRating", $product->id) }}',
                    type: 'post',
                    data: $(this).serializeArray(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status == false) {
                            var errors = response.errors;
                            if (errors && errors.name) {
                                $("#name").addClass('is-invalid').siblings("p").addClass('invalid-feedback')
                                    .html(errors.name);
                            } else {
                                $("#name").removeClass('is-invalid').siblings("p").removeClass(
                                    'invalid-feedback').html('');
                            }
                            if (errors && errors.email) {
                                $("#email").addClass('is-invalid').siblings("p").addClass('invalid-feedback')
                                    .html(errors.email);
                            } else {
                                $("#email").removeClass('is-invalid').siblings("p").removeClass(
                                    'invalid-feedback').html('');
                            }
                            if (errors && errors.rating) {
                                $("#rating").addClass('is-invalid').siblings("p").addClass('invalid-feedback')
                                    .html(errors.rating);
                            } else {
                                $("#rating").removeClass('is-invalid').siblings("p").removeClass(
                                    'invalid-feedback').html('');
                            }
                            if (errors && errors.review) {
                                $("#review").addClass('is-invalid').siblings("p").addClass('invalid-feedback')
                                    .html(errors.review);
                            } else {
                                $("#review").removeClass('is-invalid').siblings("p").removeClass(
                                    'invalid-feedback').html('');
                            }
                        } else {
                            window.location.href = "{{route('front.product', $product->slug)}}";
                        }
                    }
                });
            });


            $('#v_quantity').val(1);

            $('.v_product_size').on('change', function () {
                v_updateTotalPrice()
            });

            $('.v_product_option').on('change', function () {
                v_updateTotalPrice()
            });

            // Event handlers for increment and decrement buttons
            $('.v_increment').on('click', function (e) {
                e.preventDefault()

                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                quantity.val(currentQuantity + 1);
                v_updateTotalPrice()
            })

            $('.v_decrement').on('click', function (e) {
                e.preventDefault()

                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                if (currentQuantity > 1) {
                    quantity.val(currentQuantity - 1);
                    v_updateTotalPrice()
                }
            })

            function v_updateTotalPrice() {
                let basePrice = parseFloat($('.v_base_price').val());
                let selectedSizePrice = 0;
                let selectedOptionsPrice = 0;
                let totalPrice;
                let quantity = parseFloat($('#v_quantity').val());

                // Calculate the selected size price
                let selectedSize = $("#size option:selected").data("name");
                if (selectedSize > 0) {
                    selectedSizePrice = selectedSize;

                } else if (selectedSize === undefined) {
                    selectedSizePrice = basePrice;
                }

                // Calculate selected options price
                //let selectedOptions = $('.v_product_option:checked');
                let selectedOptions = $("#color option:selected").data("name");

                if (selectedOptions > 0) {
                    selectedOptionsPrice += selectedOptions;

                } else if (selectedOptions === undefined) {
                    selectedOptionsPrice = 0;
                }
                totalPrice = (basePrice + selectedSizePrice + selectedOptionsPrice) * quantity;
                $('#v_total_price').text("{{ config('settings.site_currency_icon') }}" + totalPrice);
            }

        });




    </script>
@endsection