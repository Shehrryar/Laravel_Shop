@extends('front.layouts.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
	<div class="container">
		<div class="light-font">
			<ol class="breadcrumb primary-color mb-0">
				<li class="breadcrumb-item"><a class="white-text" href="#">{{trans("Home")}}</a></li>
				<li class="breadcrumb-item active">{{trans("Shop")}}</li>
			</ol>
		</div>
	</div>
</section>

<section class="section-6 pt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-3 sidebar">
				<div class="sub-title">
					<h2>{{trans("Categories")}}</h3>
				</div>

				<div class="card">
					<div class="card-body">
						<div class="accordion accordion-flush" id="accordionExample">
							@if($categories->isNotEmpty())
								@foreach ($categories as $key => $cat)
									<div class="accordion-item">
										@if($cat->sub_category->isNotEmpty())
											<h2 class="accordion-header" id="headingOne-{{ $key }}">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
													data-bs-target="#collapseOne-{{ $key }}" aria-expanded="false"
													aria-controls="collapseOne-{{ $key }}">
													{{trans($cat->name)}}
												</button>
											</h2>
										@else
											<a href='{{route("front.shop", $cat->slug)}}'
												class="nav-item nav-link {{($categroy_selected == $cat->id) ? 'text-primary' : ''}}">{{trans($cat->name)}}</a>
										@endif

										@if($cat->sub_category->isNotEmpty())
											<div id="collapseOne-{{ $key }}"
												class="accordion-collapse collapse {{($categroy_selected == $cat->id) ? 'show' : ''}}"
												aria-labelledby="headingOne-{{ $key }}" data-bs-parent="#accordionExample">
												<div class="accordion-body">
													<div class="accordion accordion-flush" id="accordionSubExample-{{ $key }}">
														@foreach($cat->sub_category as $subcatKey => $subcat)
															<div class="accordion-item">
																@if($subcat->sub_sub_category->isNotEmpty())
																	<h2 class="accordion-header"
																		id="headingTwo-{{ $key }}-{{ $subcatKey }}">
																		<button style="padding-left: 24px;"
																			class="accordion-button collapsed" type="button"
																			data-bs-toggle="collapse"
																			data-bs-target="#collapseTwo-{{ $key }}-{{ $subcatKey }}"
																			aria-expanded="false"
																			aria-controls="collapseTwo-{{ $key }}-{{ $subcatKey }}">
																			{{trans($subcat->name)}}
																		</button>
																	</h2>

																	<div id="collapseTwo-{{ $key }}-{{ $subcatKey }}"
																		class="push_right accordion-collapse collapse {{($subcategroy_selected == $subcat->id) ? 'show' : ''}}"
																		aria-labelledby="headingTwo-{{ $key }}-{{ $subcatKey }}"
																		data-bs-parent="#accordionSubExample-{{ $key }}">
																		<div class="accordion-body">
																			<div class="navbar-nav">
																				@foreach($subcat->sub_sub_category as $subsubcat)
																					<a style="padding-left: 66px;"
																						href='{{route("front.shop", [$cat->slug, $subcat->slug, $subsubcat->slug])}}'
																						class="adjust_side nav-item nav-link {{($subsubcategroy_selected == $subsubcat->id) ? 'text-primary' : ''}}">{{trans($subsubcat->name)}}</a>
																				@endforeach
																			</div>
																		</div>
																	</div>
																@else
																	<a href='{{route("front.shop", [$cat->slug, $subcat->slug])}}'
																		class="nav-item nav-link {{($subcategroy_selected == $subcat->id) ? 'text-primary' : ''}}">{{trans($subcat->name)}}</a>
																@endif
															</div>
														@endforeach
													</div>
												</div>
											</div>
										@endif
									</div>
								@endforeach
							@endif
						</div>


					</div>
				</div>

				<div class="sub-title mt-5">
					<h2>{{trans("Brand")}}</h3>
				</div>
				<div class="card">
					<div class="card-body">
						@if($brands->isNotEmpty())
							@foreach($brands as $bard)
								<div class="form-check mb-2">
									<input class="form-check-input brand-label" name="brand[]" type="checkbox"
										value="{{$bard->id}}" id="brand-{{$bard->id}}" {{(in_array($bard->id, $brandsArray)) ? 'checked' : ''}}>
									<label class="form-check-label" for="brand-{{$bard->id}}">
										{{trans($bard->name)}}
									</label>
								</div>
							@endforeach
						@endif  
			</div>
				</div>

				<div class="sub-title mt-5">
					<h2>{{trans("Price")}}</h3>
				</div>

				<div class="card">
					<div class="card-body">
						<input type="text" class="js-range-slider" name="my_range" value="" />
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row pb-3">
					<div class="col-12 pb-1">
						<div class="d-flex align-items-center justify-content-end mb-4">
							<div class="ml-2">

								<select id="sort" name="sort" class="form-control">
									<option value="pricehigh" {{($sort == 'pricehigh') ? 'selected' : ''}}>Price High
									</option>
									<option value="latest" {{($sort == 'latest') ? 'selected' : ''}}>Latest</option>
									<option value="pricelow" {{($sort == 'pricelow') ? 'selected' : ''}}>Price Low
									</option>

								</select>

							</div>
						</div>
					</div>
					@if($products->isNotEmpty())
									@foreach($products as $prod)
													@php
														$images_prod = $prod->product_images()->first();
														$inWishlist = $wishlist->contains('product_id', $prod->id);
													@endphp
													<div class="col-md-4">
														<div class="card product-card">
															<div class="product-image position-relative">
																<a href="{{route("front.product", $prod->slug)}}" class="product-img">
																	@if(!empty($images_prod))
																		<img class="card-img-top" src="{{asset('upload/products/' . $images_prod->image)}}">
																	@else
																		<img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
																	@endif
																</a>
																<div class="discount-badge">20% OFF</div>

																<a onclick="addToWishlist({{$prod->id}})" class="whishlist" href="javascript:void(0)">
																	<i id="addwishlist{{$prod->id}}" class="far fa-heart"
																		style="{{ $inWishlist ? 'display:none;' : '' }}"></i>
																</a>
																<a onclick="removefromWishlist({{$prod->id}})" class="whishlist"
																	href="javascript:void(0)">
																	<i id="removewishlist{{$prod->id}}" class="redhearticon fas fa-heart"
																		style="{{ $inWishlist ? '' : 'display:none;' }}"></i>
																</a>
															</div>
															<hr style="border: none; border-top: 2px solid #000; width: 50%; margin: 20px auto;">
															@if ($prod->qty > 0)
																<a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$prod->id}})">
																	<i class="fa fa-shopping-cart"></i> {{trans('Add To Cart')}}
																</a>
															@else
																<a class="btn btn-dark" href="javascript:void(0)" disabled>
																	<i class="fa fa-shopping-cart"></i> {{trans('Out of Stock')}}
																</a>
															@endif
															<div class="card-body text-center mt-3">
																<a class="h6 link" href="product.php">{{trans($prod->title)}}</a>
																<div class="price mt-2">
																	<span class="h5"><strong>{{$prod->price}}$</strong></span>
																	@if ($prod->compared_price > 0)
																		<span class="h6 text-underline"><del>{{$prod->compared_price}}</del></span>
																	@endif
																</div>

																<div style="display: flex; justify-content: center;">
																	@php
																		$avg_rating_per = 0;
																		if ($prod->product_ratings_count > 0) {
																			$avg_rating = number_format(($prod->product_ratings_sum_rating /
																				$prod->product_ratings_count), 2);
																			$avg_rating_per = ($avg_rating * 100) / 5;
																		}
																	@endphp
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
																	<small class="pt-2 ps-1">({{$prod->product_ratings_count}} Reviews)</small>
																</div>
															</div>
														</div>
													</div>
									@endforeach
					@endif
					<div class="col-md-12 pt-5">
						{{$products->withQueryString()->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('customJs')
<script>

	rangeSlider = $(".js-range-slider").ionRangeSlider({
		type: "double",
		min: 1,
		max: 1000,
		from: {{$price_min}},
		step: 10,
		to: {{$price_max}},
		skin: "round",
		max_postfix: "+",
		prefix: "$",
		onFinish: function () {
			apply_filter(); // Corrected function name
		}
	});
	var slider = $(".js-range-slider").data("ionRangeSlider");
	$(".brand-label").change(function () {
		apply_filter();
	});
	$("#sort").change(function () {
		apply_filter();
	});
	function apply_filter() {
		var brands = [];
		$(".brand-label").each(function () {
			if ($(this).is(":checked") == true) {
				brands.push($(this).val());
			}
		});
		var url = '{{url()->current()}}?';
		if (brands.length > 0) {
			url += '&brand=' + brands.toString();
		}

		url += '&price_min=' + slider.result.from + '&price_max=' + slider.result.to;
		url += '&sort=' + $('#sort').val();
		window.location.href = url;

	}
</script>

@endsection