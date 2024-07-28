@extends('front.layouts.app')


@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Wishlist</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">

        @include('front.account.sidebar.sidebar')
        
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Wishlist</h2>
                    </div>
                    <div class="card-body p-4">
                        @foreach ($wishlist as $list_fav)
                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                            <div class="d-block d-sm-flex align-items-start text-center text-sm-start">

                                @php
                                $image = getProductImage($list_fav->product->id);
                                @endphp
                                <a class="d-block flex-shrink-0 mx-auto me-sm-4"
                                    href="{{route("front.product",$list_fav->product->slug)}}" style="width: 10rem;">
                                    <!-- <img src="images/product-1.jpg" alt="Product"> -->
                                    @if(!empty($image))
                                    <img class="card-img-top" src="{{asset('upload/products/'.$image->image)}}">
                                    @else
                                    <img class="card-img-top" src="{{asset('admin-assets\img\default-150x150.png')}}">
                                    @endif
                                </a>
                                <div class="pt-2">
                                    <h3 class="product-title fs-base mb-2"><a
                                            href="shop-single-v1.html">{{$list_fav->product->title}}</a></h3>
                                    <div class="fs-lg text-accent pt-2">
                                        <div class="price mt-2">
                                            <span class="h5"><strong>{{$list_fav->product->price}}</strong></span>
                                            <span
                                                class="h6 text-underline"><del>{{$list_fav->product->compare_price}}</del></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                <button onclick="remove_product({{$list_fav->product_id}})"
                                    class="btn btn-outline-danger btn-sm" type="button"><i
                                        class="fas fa-trash-alt me-2"></i>Remove</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



@section('customJs')
<script>
function remove_product(id) {
    $.ajax({
        url: '{{route("account.remove_product_from_wislist")}}',
        type: 'post',
        data: {
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.status == true) {
                window.location.href = "{{route('account.wishlist')}}";
            }
        }
    });
}
</script>
@endsection