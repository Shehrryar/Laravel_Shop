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
</head>
@php


@endphp

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
                    <form id="search_prodcut" name="search_prodcut" action="{{ route('product.search') }}"
                        method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" value="{{$keyword}}" name="search_query"
                                placeholder="Search For Products" class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">
                                <button type="submit"><i class="fa fa-search"></i></button>
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
                    <a href="#" id="chatboxdisplay" class="nav-link d-flex align-items-center" style="cursor: pointer;">
                        <i class="fas fa-comments" style="margin-right: 8px;"></i> <!-- Chat icon -->
                    </a>
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <select id="languageSelect" class="form-control">
                                @php
                                    $languages = \App\Models\Language::all();
                                @endphp
                                @foreach ($languages as $language)
                                    @if ($language->status == 1)
                                        <option value="{{ $language->Isocode }}" {{ app()->getLocale() == $language->Isocode ? 'selected' : '' }}>
                                            {{ trans($language->name) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </li>
                    </ul>
                    <a href="{{route(('front.cart'))}}" class="d-flex notification" style="margin-left: 10px;">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 29px;"></i>
                        <span class="badge">{{getcartquantityandtotal()['totalQuantity']}}</span>
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </a>
                </div>
            </nav>



            <div id="chatBox" class="chat-box"
                style="display:none; position: fixed; z-index: 9; bottom: 10%; right: 2%; width: 300px; height: 400px; border: 1px solid #ccc; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                <div class="chat-header"
                    style="background-color: #f1f1f1; padding: 10px; border-bottom: 1px solid #ccc;">
                    <span>Chat</span>
                    <button id="closeChat" class="close-chat-btn"
                        style="float: right; border: none; background: none; font-size: 20px; cursor: pointer;">&times;</button>
                </div>
                <div class="chat-content" id="chatContent" uieywriouewor
                    style="height: calc(100% - 100px); overflow-y: auto; padding: 10px; background-color: #ffffff;">
                    <!-- Messages will go here -->
                    <p id="sener_p" style="background-color:white;word-break: break-all;width: 60%;">Welcome! How can we
                        help you today?</p>
                    <p id="receiver_p"
                        style="background-color:gray;word-break: break-all;width: 60%;margin-left: 107px;">Welcome! How
                        can we help you today?</p>
                </div>
                <div class="chat-input" style="padding: 10px; border-top: 1px solid #ccc; background-color: #f9f9f9;">
                    <input type="text" id="chatMessageInput" placeholder="Type a message..."
                        style="width: calc(100% - 60px); padding: 5px; " />
                    <button id="sendMessageBtn"
                        style="padding: 5px 10px; margin-left: 5px; font-size:13px; ">Send</button>
                </div>
            </div>





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
            window.onscroll = function () {
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



            function addToCart(id, discount_val, discount_price, actual_price, attribute_Array) {
                $.ajax({
                    url: '{{ route("front.addToCart") }}',
                    type: 'POST',
                    data: {
                        id: id,
                        discount_val: discount_val,
                        discount_price: discount_price,
                        actual_price: actual_price,
                        attribute_Array: attribute_Array,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === true) {
                            window.location.href = "{{ route('front.cart') }}"; // Redirect to cart if product added
                        } else if (response.userlogin == 'isnotlogged') {
                            window.location.href = "{{ route('account.login') }}"; // Redirect to login if not logged in
                        } else {
                            alert(response.message); // Show the error message
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Error:', error); // Optional: log the error for debugging
                    }
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
                    success: function (response) {
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
                    success: function (response) {
                        if (response.status == true) {
                            $(addwishlistid).css('display', 'block');
                            $(removewishlistid).css('display', 'none');
                        }
                    }
                });
            }
            document.getElementById('languageSelect').addEventListener('change', function () {
                var selectedLanguage = this.value;
                // Redirect to the selected language URL
                var url = "{{ route('front.localizationcontroller', ':locale') }}";
                url = url.replace(':locale', selectedLanguage);
                window.location.href = url;



            });
            document.addEventListener('DOMContentLoaded', function () {
                var dropdownItems = document.querySelectorAll('.nav-item.dropdown');
                // Loop through each dropdown item and add event listeners
                dropdownItems.forEach(function (dropdown) {
                    dropdown.addEventListener('mouseenter', function () {
                        var dropdownMenu = this.querySelector('.dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.classList.add('show');
                            dropdown.classList.add('show');
                        }
                    });
                    dropdown.addEventListener('mouseleave', function () {
                        var dropdownMenu = this.querySelector('.dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.classList.remove('show');
                            dropdown.classList.remove('show');
                        }
                    });
                });
                var subDropdownItems = document.querySelectorAll('.dropdown-submenu');
                // Loop through each sub-dropdown item and add event listeners
                subDropdownItems.forEach(function (subDropdown) {
                    subDropdown.addEventListener('mouseenter', function () {
                        var dropdownMenu = this.querySelector('.dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.classList.add('show');
                            subDropdown.classList.add('show');
                        }
                    });
                    subDropdown.addEventListener('mouseleave', function () {
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



        <script>
            // Toggle chat box visibility
            document.getElementById('chatboxdisplay').addEventListener('click', function (event) {
                const chatBox = document.getElementById('chatBox');
                chatBox.style.display = chatBox.style.display === 'none' || chatBox.style.display === '' ? 'block' : 'none';
                event.preventDefault();
                fetchMessages(); // Fetch messages immediately when clicked
            });

            // Function to fetch and update chat messages
            function fetchMessages() {
                $.ajax({
                    url: "{{ route('front.chat') }}",
                    type: 'GET',
                    success: function (messages) {
                        const chatContent = document.getElementById('chatContent'); // Make sure this element exists
                        chatContent.innerHTML = ''; // Clear existing messages if needed

                        for (let i = 0; i < messages.chat_message.length; i++) {
                            const message = messages.chat_message[i];
                            let newMessage = document.createElement('p');
                            newMessage.style.wordBreak = 'break-all';
                            newMessage.style.width = '60%';
                            newMessage.style.color = 'white';
                            newMessage.style.borderRadius = '10px';
                            newMessage.style.padding = '10px';

                            // Check if the message sender matches
                            if (messages.sender_id == message.sender_id) {
                                newMessage.style.backgroundColor = 'blue';
                                newMessage.textContent = message.message_content;
                            } else {
                                newMessage.style.backgroundColor = 'grey';
                                newMessage.style.marginLeft = '107px';
                                newMessage.textContent = message.message_content;
                            }

                            // Append the new message to the chat content container
                            chatContent.appendChild(newMessage);
                        }
                    }
                });
            }

            // Set up auto-refresh every 5 seconds (adjust the interval as needed)
            setInterval(fetchMessages, 50);



            // Close chat box when close button is clicked
            document.getElementById('closeChat').addEventListener('click', function () {
                document.getElementById('chatBox').style.display = 'none';
            });

            // Optional: Send message logic (dummy example)
            document.getElementById('sendMessageBtn').addEventListener('click', function () {
                event.preventDefault();
                const messageInput = document.getElementById('chatMessageInput');
                const chatContent = document.getElementById('chatContent');

                $.ajax({
                    url: "{{ route('send.message') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        message_content: messageInput.value
                    },
                    success: function (message) {

                        const newMessage = document.createElement('p');
                        newMessage.textContent = message.message_content;
                        newMessage.style.backgroundColor = 'blue';
                        newMessage.style.color = 'white';
                        newMessage.style.borderRadius = '10px';
                        newMessage.style.padding = '10px';
                        newMessage.style.wordBreak = 'break-all';
                        newMessage.style.width = '60%';
                        chatContent.appendChild(newMessage);
                        messageInput.value = ''; // Clear input field
                        chatContent.scrollTop = chatContent.scrollHeight; // Scroll to bottom
                    }
                });
            });
        </script>
        @yield('customJs')
</body>

</html>