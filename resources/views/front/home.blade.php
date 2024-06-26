   
@extends('front.layouts.app')
@section('content')

@if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{Session::get('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-1-m.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-1.jpg')}}" />
                        <img src="{{asset('front-assets/images/carousel-1.jpg')}}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
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
                            <h1 class="display-4 text-white mb-3">Womens Fashion</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
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
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
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
                        <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                        </div>                    
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                        </div>                    
                    </div>
                    <div class="col-lg-3">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                        </div>                    
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                            </div>                    
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-3">
                <div class="container">
                    <div class="section-title">
                        <h2>Categories</h2>
                    </div>           
                    <div class="row pb-3">
                        @if(getcategories()->isNotEmpty())
                        @foreach(getcategories() as $category)
                        <div class="col-lg-3">
                            <div class="cat-card">
                                <div class="left">
                                    <img src='{{asset("upload/category/".$category->image)}}' alt="" class="img-fluid">
                                </div>
                                <div class="right">
                                    <div class="cat-data">
                                        <h2>{{$category->name}}</h2>
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
                        <h2>Featured Products</h2>
                    </div>    
                    <div class="row pb-3">
                        @if($featured_products->isNotEmpty())
                        @foreach($featured_products as $f_product)

                        @php
                        $images_prod = $f_product->product_images()->first()
                        @endphp
                        <div class="col-md-3">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="{{route("front.product",$f_product->slug)}}" class="product-img">

                                        <!-- <img class="card-img-top" src="images/product-1.jpg')}}" alt=""> -->
                                        @if(!empty($images_prod))
                                        <img class="card-img-top" src="{{asset('upload/products/'.$images_prod->image)}}">
                                        @else
                                        <img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
                                        @endif
                                    </a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$f_product->id}})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>                            
                                    </div>
                                </div>                        
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{$f_product->title}}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{$f_product->price}}</strong></span>
                                        <span class="h6 text-underline"><del>{{$f_product->compare_price}}</del></span>
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
                        <h2>Latest Produsts</h2>
                    </div>    
                    <div class="row pb-3">
                        @foreach($latest_product as $late_prod)
                        @php
                        $images_prod = $late_prod->product_images()->first()
                        @endphp
                        <div class="col-md-3">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href='{{route("front.product",$late_prod->slug)}}' class="product-img">
                                        @if(!empty($images_prod))
                                        <img class="card-img-top" src="{{asset('upload/products/'.$images_prod->image)}}">
                                        @else
                                        <img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
                                        @endif
                                    </a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$late_prod->id}})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>                            
                                    </div>
                                </div>                        
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{$late_prod->title}}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{$late_prod->price}}</strong></span>
                                        <span class="h6 text-underline"><del>{{$late_prod->compare_price}}</del></span>
                                    </div>
                                </div>                        
                            </div>                                               
                        </div>   
                        @endforeach             
                    </div>
                </div>
            </section>
        </main>
        <footer class="bg-dark mt-5">
           <div class="container pb-5 pt-3">
              <div class="row">
                 <div class="col-md-4">
                    <div class="footer-card">
                       <h3>Get In Touch</h3>
                       <p>No dolore ipsum accusam no lorem. <br>
                           123 Street, New York, USA <br>
                           exampl@example.com <br>
                       000 000 0000</p>
                   </div>
               </div>

               <div class="col-md-4">
                <div class="footer-card">
                   <h3>Important Links</h3>
                   <ul>
                      <li><a href="about-us.php" title="About">About</a></li>
                      <li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>                       
                      <li><a href="#" title="Privacy">Privacy</a></li>
                      <li><a href="#" title="Privacy">Terms & Conditions</a></li>
                      <li><a href="#" title="Privacy">Refund Policy</a></li>
                  </ul>
              </div>
          </div>

          <div class="col-md-4">
            <div class="footer-card">
               <h3>My Account</h3>
               <ul>
                  <li><a href="#" title="Sell">Login</a></li>
                  <li><a href="#" title="Advertise">Register</a></li>
                  <li><a href="#" title="Contact Us">My Orders</a></li>                     
              </ul>
          </div>
      </div>            

@endsection


