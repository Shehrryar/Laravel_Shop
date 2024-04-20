@extends('front.layouts.app')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
	<div class="container">
		<div class="light-font">
			<ol class="breadcrumb primary-color mb-0">
				<li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
				<li class="breadcrumb-item active">Shop</li>
			</ol>
		</div>
	</div>
</section>

<section class="section-6 pt-5">
	<div class="container">
		<div class="row">            
			<div class="col-md-3 sidebar">
				<div class="sub-title">
					<h2>Categories</h3>
					</div>

					<div class="card">
						<div class="card-body">
							<div class="accordion accordion-flush" id="accordionExample">
								@if($categories->isNotEmpty())
								@foreach ($categories as $key => $cat)
								<div class="accordion-item">
									@if($cat->sub_category->isNotEmpty())
									<h2 class="accordion-header" id="headingOne">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target= "#collapseOne-{{ $key }}" aria-expanded="false" aria-controls= "collapseOne-{{ $key }}">
											{{$cat->name}}
										</button>
									</h2>
									@else
									<a href='{{route("front.shop",$cat->slug)}}'class="nav-item nav-link {{($categroy_selected == $cat->id) ? 'text-primary' : ''}}">{{$cat->name}}</a>
									@endif
									@if($cat->sub_category->isNotEmpty())
									<div id="collapseOne-{{ $key }}" class="accordion-collapse collapse {{($categroy_selected == $cat->id) ? 'show' : ''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
										<div class="accordion-body">
											<div class="navbar-nav">
												
												@foreach($cat->sub_category as $subcat)
												<a href='{{route("front.shop",[$cat->slug,$subcat->slug])}}' class="nav-item nav-link {{($subcategroy_selected == $subcat->id) ? 'text-primary' : ''}}">{{$subcat->name}}</a> 
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
						<h2>Brand</h3>
						</div>
						<div class="card">
							<div class="card-body">
								@if($brands->isNotEmpty())
								@foreach($brands as $bard)
								<div class="form-check mb-2">
									<input class="form-check-input brand-label" name="brand[]" type="checkbox" value="{{$bard->id}}" id="brand-{{$bard->id}}" {{(in_array($bard->id,$brandsArray)) ? 'checked' : ''}} >
									<label class="form-check-label" for="brand-{{$bard->id}}">
										{{$bard->name}}
									</label>
								</div>  
								@endforeach
								@endif              
							</div>
						</div>

						<div class="sub-title mt-5">
							<h2>Price</h3>
							</div>

							<div class="card">
								<div class="card-body">
									<div class="form-check mb-2">
										<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
										<label class="form-check-label" for="flexCheckDefault">
											$0-$100
										</label>
									</div>
									<div class="form-check mb-2">
										<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
										<label class="form-check-label" for="flexCheckChecked">
											$100-$200
										</label>
									</div>                 
									<div class="form-check mb-2">
										<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
										<label class="form-check-label" for="flexCheckChecked">
											$200-$500
										</label>
									</div> 
									<div class="form-check mb-2">
										<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
										<label class="form-check-label" for="flexCheckChecked">
											$500+
										</label>
									</div>                 
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<div class="row pb-3">
								<div class="col-12 pb-1">
									<div class="d-flex align-items-center justify-content-end mb-4">
										<div class="ml-2">
											<div class="btn-group">
												<button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="#">Latest</a>
													<a class="dropdown-item" href="#">Price High</a>
													<a class="dropdown-item" href="#">Price Low</a>
												</div>
											</div>                                    
										</div>
									</div>
								</div>
								@if($products->isNotEmpty())
								@foreach($products as $prod)
								@php
								$images_prod = $prod->product_images()->first()
								@endphp
								<div class="col-md-4">
									<div class="card product-card">
										<div class="product-image position-relative">
											<a href="" class="product-img">
												@if(!empty($images_prod))
												<img class="card-img-top" src="{{asset('upload/products/'.$images_prod->image)}}">
												@else
												<img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
												@endif
											</a>
											<a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

											<div class="product-action">
												<a class="btn btn-dark" href="#">
													<i class="fa fa-shopping-cart"></i> Add To Cart
												</a>                            
											</div>
										</div>                        
										<div class="card-body text-center mt-3">
											<a class="h6 link" href="product.php">{{$prod->title}}</a>
											<div class="price mt-2">
												<span class="h5"><strong>{{$prod->price}}</strong></span>
												<span class="h6 text-underline"><del>{{$prod->compared_price}}</del></span>
											</div>
										</div>                        
									</div>                                               
								</div>  
								@endforeach
								@endif
								<div class="col-md-12 pt-5">
									<nav aria-label="Page navigation example">
										<ul class="pagination justify-content-end">
											<li class="page-item disabled">
												<a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
											</li>
											<li class="page-item"><a class="page-link" href="#">1</a></li>
											<li class="page-item"><a class="page-link" href="#">2</a></li>
											<li class="page-item"><a class="page-link" href="#">3</a></li>
											<li class="page-item">
												<a class="page-link" href="#">Next</a>
											</li>
										</ul>
									</nav>
								</div>

							</div>
						</div>
					</div>
				</div>
			</section>  
			@endsection

			@section('customJs')

			<script>

				$(".brand-label").change(function(){

					apply_filter();
				});


				function apply_filter(){
					var brands = [];
					$(".brand-label").each(function(){
						if($(this).is(":checked")==true){
							brands.push($(this).val());
						}
					});
					window.location.href= '{{url()->current()}}?'+'&brand='+brands.toString();
				}

			</script>

			@endsection
