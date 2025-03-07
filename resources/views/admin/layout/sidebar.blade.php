<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{asset('admin-assets/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LARAVEL SHOP</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
								with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('categories.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('subcategories.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Sub Category Level 2</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('subsubcategories.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-list-ul"></i>
                        <p>Sub Category Level 3</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('brands.index')}}" class="nav-link">
                        <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p>Brands</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-cart nav-icon" aria-hidden="true"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a style="margin-left: 28px;" href='{{route("product.index")}}' class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product list</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="margin-left: 28px;" href="{{ route('productattribute.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Attribute</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href='{{route("colorss.index")}}' class="nav-link">
                        <i class="nav-icon fas fa-palette"></i>
                        <p>Color</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href='{{route("sizes.index")}}' class="nav-link">
                        <i class="nav-icon fas fa-ruler"></i>
                        <p>Size</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href='{{route("stock.index")}}' class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Stock Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("shipping.create")}}" class="nav-link">
                        <!-- <i class="nav-icon fas fa-tag"></i> -->
                        <i class="fas fa-truck nav-icon"></i>
                        <p>Shipping</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route("order.index")}}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-percent" aria-hidden="true"></i>
                        <p>
                            Discount
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a style="margin-left: 28px;" href="{{ route('discount.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Discount</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="margin-left: 28px;" href="{{ route('coupon.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Discount by Coupon</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('currency.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>Currencies</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('language.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Language</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('chat.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('chat.checkSocketMessage')}}" class="nav-link">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Sockets Chat</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs" aria-hidden="true"></i>
                        <p>
                            Web Services
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a style="margin-left: 28px;" href="{{ route('webservice.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>AdminSide APIS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="margin-left: 28px;" href="{{ route('coupon.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>FrontSide APIS</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="pages.html" class="nav-link">
                        <i class="nav-icon  far fa-file-alt"></i>
                        <p>Pages</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>