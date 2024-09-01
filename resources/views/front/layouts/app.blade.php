<!DOCTYPE html>
<html class="no-js" lang="en_AU">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo (!empty($title)) ? 'Title-' . $title : 'Home'; ?>Laravel Online Shop</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />


    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/slick-theme.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/video-js.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('front-assets/css/ion.rangeSlider.min.css')}}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->


    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
    <meta name="csrf-token" content="{{csrf_token()}}">

    <style>
    .notification {
        /* background-color: #555; */
        color: white;
        text-decoration: none;
        padding: 9px 13px;
        position: relative;
        display: inline-block;
        border-radius: 2px;
    }

    .notification:hover {
        background: gray;
    }

    .notification .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        display: none;
        position: absolute;
        top: 0;
        left: 100%;
        /* Show the submenu to the right */
        margin-top: -1px;
    }

    .dropdown-submenu-left>.dropdown-menu {
        left: auto;
        right: 100%;
        /* Show the submenu to the left */
    }

    /* Show the submenu on hover */
    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }

    /* Add to Cart Button */
    .product-action .btn-dark {
        background: linear-gradient(45deg, #6b8e23, #4caf50);
        /* Gradient background */
        color: white;
        /* White text color */
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        /* Remove border */
        border-radius: 5px;
        /* Rounded corners */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Light shadow for depth */
        transition: background 0.3s ease, transform 0.3s ease;
        /* Smooth transitions */
    }

    /* Hover effect */
    .product-action .btn-dark:hover {
        background: linear-gradient(45deg, #4caf50, #388e3c);
        /* Darker green gradient */
        transform: translateY(-2px);
        /* Slightly raise the button */
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        /* Increase shadow on hover */
    }

    /* Active state */
    .product-action .btn-dark:active {
        transform: translateY(0);
        /* Reset the translation */
        box-shadow: 0 3px 4px rgba(0, 0, 0, 0.2);
        /* Slightly reduce shadow */
    }

    /* Icon styling */
    .product-action .btn-dark i {
        margin-right: 8px;
        /* Space between icon and text */
        font-size: 18px;
    }

    /* Discount Badge */
    .discount-badge {
        position: absolute;
        top: 10px;
        /* Position it near the top */
        left: 10px;
        /* Position it near the left */
        background-color: #ff4d4d;
        /* Bright red background for visibility */
        color: white;
        /* White text for contrast */
        padding: 5px 10px;
        /* Some padding for better appearance */
        font-size: 14px;
        /* Font size for readability */
        font-weight: bold;
        /* Bold text to stand out */
        border-radius: 5px;
        /* Rounded corners */
        z-index: 10;
        /* Ensure it stays on top of other content */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        /* Subtle shadow for depth */
    }
    </style>
</head>

<body data-instant-intensity="mousedown">

    <div class="bg-light top-header">
        <div class="container">
            <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
                <div class="col-lg-4 logo">
                    <a href="{{route(('front.home'))}}" class="text-decoration-none">
                        <span class="h1 text-uppercase text-primary bg-dark px-2">{{ __("ONLINE SHOP") }}</span>
                    </a>
                </div>
                <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">

                    @if (Auth::check())
                    <a href="{{route('account.profile')}}" class="nav-link text-dark">My Account</a>
                    @else
                    <a href="{{route('account.login')}}" class="nav-link text-dark">Login</a>
                    @endif

                    <form action="">
                        <div class="input-group">
                            <input type="text" placeholder="Search For Products" class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <header class="bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-xl" id="navbar">
                <a href="index.php" class="text-decoration-none mobile-logo">
                    <span class="h2 text-uppercase text-primary bg-dark">Online</span>
                    <span class="h2 text-uppercase text-white px-2">SHOP</span>
                </a>
                <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon icon-menu"></span> -->
                    <i class="navbar-toggler-icon fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if(getcategories()->isNotEmpty())
                        @foreach(getcategories() as $category)
                        <li class="nav-item dropdown">

                            <button onclick="show_category('{{ route('front.shop', $category->slug) }}')"
                                class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ trans($category->name) }}
                            </button>

                            @if($category->sub_category->isNotEmpty())
                            <ul class="dropdown-menu dropdown-menu-dark">
                                @foreach($category->sub_category as $subcategory)
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item nav-link"
                                        href="{{ route('front.shop', [$category->slug, $subcategory->slug]) }}">
                                        {{ trans($subcategory->name) }}
                                    </a>

                                    @if($subcategory->sub_sub_category->isNotEmpty())
                                    <!-- Check for SubSubCategory -->
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        @foreach($subcategory->sub_sub_category as $subSubCategory)
                                        <li>
                                            <a class="dropdown-item nav-link"
                                                href="{{ route('front.shop', [$category->slug, $subcategory->slug, $subSubCategory->slug]) }}">
                                                {{ trans($subSubCategory->name) }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>

                <div class="right-nav py-0 d-flex align-items-center ">

                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <select id="languageSelect" class="form-control">
                                @php
                                $languages = \App\Models\Language::all();
                                @endphp
                                @foreach ($languages as $language)
                                @if ($language->status == 1)
                                <option value="{{ $language->Isocode }}"
                                    {{ app()->getLocale() == $language->Isocode ? 'selected' : '' }}>
                                    {{ trans($language->name) }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </li>
                    </ul>


                    <a href="{{route(('front.cart'))}}" class="d-flex notification" style="margin-left: 10px;">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 29px;"></i>
                        <span class="badge">{{Cart::count()}}</span>
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </a>
                </div>

            </nav>
        </div>
    </header>
    <main>

        @yield('content')
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
                </div>
            </div>
            <div class="copyright-area">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="copy-right text-center">
                                <p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>


        <!-- Modal -->
        <div class="modal fade" id="wishlist_model" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Success</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>


        <script src="{{asset('front-assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('front-assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
        <script src="{{asset('front-assets/js/instantpages.5.1.0.min.js')}}"></script>
        <script src="{{asset('front-assets/js/lazyload.17.6.0.min.js')}}"></script>
        <script src="{{asset('front-assets/js/slick.min.js')}}"></script>
        <script src="{{asset('front-assets/js/ion.rangeSlider.min.js')}}"></script>

        <script src="{{asset('front-assets/js/custom.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function addToCart(id, discount_val, discount_price, actual_price) {
            $.ajax({
                url: '{{ route("front.addToCart") }}',
                type: 'POST',
                data: {
                    id: id,
                    discount_val: discount_val,
                    discount_price: discount_price,
                    actual_price: actual_price
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === true) {
                        window.location.href = "{{ route('front.cart') }}";
                    } else {
                        alert(response.message);
                    }
                },
            });
        }

        $('.redhearticon').css({
            'color': 'red'
        });

        function addToWishlist(id) {
            var addwishlistid = "#addwishlist" + id;
            var removewishlistid = "#removewishlist" + id;
            $.ajax({
                url: '{{ route("front.addtowishlist") }}',
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $(addwishlistid).css('display', 'none');
                        $(removewishlistid).css('display', 'block');
                        $("#wishlist_model .modal-body").html(response.message);
                        $("#wishlist_model").modal('show');
                    } else {
                        // Redirect to login if not successful
                        window.location.href = "{{ route('account.login') }}";
                    }
                }
            });
        }

        function removefromWishlist(id) {
            var addwishlistid = "#addwishlist" + id;
            var removewishlistid = "#removewishlist" + id;
            $.ajax({
                url: '{{route("account.remove_product_from_wislist")}}',
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {

                        $(addwishlistid).css('display', 'block');
                        $(removewishlistid).css('display', 'none');

                    }
                }
            });
        }


        document.getElementById('languageSelect').addEventListener('change', function() {
            var selectedLanguage = this.value;
            // Redirect to the selected language URL
            var url = "{{ route('front.localizationcontroller', ':locale') }}";
            url = url.replace(':locale', selectedLanguage);
            window.location.href = url;
        });


        document.addEventListener('DOMContentLoaded', function() {
            var dropdownItems = document.querySelectorAll('.nav-item.dropdown');

            // Loop through each dropdown item and add event listeners
            dropdownItems.forEach(function(dropdown) {
                dropdown.addEventListener('mouseenter', function() {
                    var dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.add('show');
                        dropdown.classList.add('show');
                    }
                });

                dropdown.addEventListener('mouseleave', function() {
                    var dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.remove('show');
                        dropdown.classList.remove('show');
                    }
                });
            });

            var subDropdownItems = document.querySelectorAll('.dropdown-submenu');

            // Loop through each sub-dropdown item and add event listeners
            subDropdownItems.forEach(function(subDropdown) {
                subDropdown.addEventListener('mouseenter', function() {
                    var dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.add('show');
                        subDropdown.classList.add('show');
                    }
                });

                subDropdown.addEventListener('mouseleave', function() {
                    var dropdownMenu = this.querySelector('.dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.classList.remove('show');
                        subDropdown.classList.remove('show');
                    }
                });
            });
        });


        function show_category(url) {
            if (url) {
                window.location.href = url;
            }
        }
        </script>

        @yield('customJs')
</body>

</html>