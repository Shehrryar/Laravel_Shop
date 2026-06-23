@php
    $adminUser = Auth::guard('admin')->user();

    $isMainAdmin = $adminUser && (int) $adminUser->role === 2;
    $isVendor = $adminUser && (int) $adminUser->role === 3;

    $permissions = $adminUser->permissions ?? [];

    $canAccess = function ($key) use ($isVendor, $permissions) {
        return $isVendor && !empty($permissions[$key]);
    };
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('admin-assets/img/AdminLTELogo.png') }}"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">

        <span class="brand-text font-weight-light">LARAVEL SHOP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- ================= MAIN ADMIN MENU ================= --}}
                @if ($isMainAdmin)

                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">MAIN ADMIN</li>

                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Category</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('subcategories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list-alt"></i>
                            <p>Sub Category Level 2</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('subsubcategories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-list-ul"></i>
                            <p>Sub Category Level 3</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('brands.index') }}" class="nav-link">
                            <i class="nav-icon far fa-bookmark"></i>
                            <p>Brands</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="fas fa-shopping-cart nav-icon"></i>
                            <p>
                                Products
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a style="margin-left: 28px;" href="{{ route('product.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product List</p>
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
                        <a href="{{ route('colorss.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>Color</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('themes.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-palette"></i>
                            <p>Theme</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('sizes.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-ruler"></i>
                            <p>Size</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('stock.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Stock Management</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('shipping.create') }}" class="nav-link">
                            <i class="fas fa-truck nav-icon"></i>
                            <p>Shipping</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('order.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Orders</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-percent"></i>
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
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('vendor.permissions.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Vendor Permissions</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('currency.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>Currencies</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('language.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>Language</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('promotion.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Promotions</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('chat.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chat</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('chat.checkSocketMessage') }}" class="nav-link">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>Sockets Chat</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
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
                                <a style="margin-left: 28px;" href="{{ route('Frontapi.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>FrontSide APIS</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('onboarding.index') }}" class="nav-link">
                            <i class="nav-icon far fa-file-alt"></i>
                            <p>Onboarding</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('homepage-labels.index') }}" class="nav-link">
                            <i class="nav-icon far fa-file-alt"></i>
                            <p>Homepage Label</p>
                        </a>
                    </li>

                @endif


                {{-- ================= VENDOR / SUB ADMIN MENU ================= --}}
                @if ($isVendor)

                    @if (!empty($permissions['dashboard']))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Vendor Dashboard</p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-header">MY STORE PANEL</li>

                    @if ($canAccess('category'))
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Category</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('sub_category_level_2'))
                        <li class="nav-item">
                            <a href="{{ route('subcategories.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Sub Category Level 2</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('sub_category_level_3'))
                        <li class="nav-item">
                            <a href="{{ route('subsubcategories.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>Sub Category Level 3</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('brands'))
                        <li class="nav-item">
                            <a href="{{ route('brands.index') }}" class="nav-link">
                                <i class="nav-icon far fa-bookmark"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('products'))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-shopping-cart nav-icon"></i>
                                <p>
                                    Products
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a style="margin-left: 28px;" href="{{ route('product.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Product List</p>
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
                    @endif

                    @if ($canAccess('colors'))
                        <li class="nav-item">
                            <a href="{{ route('colorss.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-palette"></i>
                                <p>Color</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('themes'))
                        <li class="nav-item">
                            <a href="{{ route('themes.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-palette"></i>
                                <p>Theme</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('sizes'))
                        <li class="nav-item">
                            <a href="{{ route('sizes.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-ruler"></i>
                                <p>Size</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('stock'))
                        <li class="nav-item">
                            <a href="{{ route('stock.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-boxes"></i>
                                <p>Stock Management</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('shipping'))
                        <li class="nav-item">
                            <a href="{{ route('shipping.create') }}" class="nav-link">
                                <i class="fas fa-truck nav-icon"></i>
                                <p>Shipping</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('orders'))
                        <li class="nav-item">
                            <a href="{{ route('order.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('discount'))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-percent"></i>
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
                    @endif

                    @if ($canAccess('users'))
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('currencies'))
                        <li class="nav-item">
                            <a href="{{ route('currency.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>Currencies</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('language'))
                        <li class="nav-item">
                            <a href="{{ route('language.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>Language</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('promotions'))
                        <li class="nav-item">
                            <a href="{{ route('promotion.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-bullhorn"></i>
                                <p>Promotions</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('chat'))
                        <li class="nav-item">
                            <a href="{{ route('chat.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>Chat</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('sockets_chat'))
                        <li class="nav-item">
                            <a href="{{ route('chat.checkSocketMessage') }}" class="nav-link">
                                <i class="nav-icon fas fa-globe"></i>
                                <p>Sockets Chat</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('web_services'))
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
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
                                    <a style="margin-left: 28px;" href="{{ route('Frontapi.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>FrontSide APIS</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if ($canAccess('onboarding'))
                        <li class="nav-item">
                            <a href="{{ route('onboarding.index') }}" class="nav-link">
                                <i class="nav-icon far fa-file-alt"></i>
                                <p>Onboarding</p>
                            </a>
                        </li>
                    @endif

                    @if ($canAccess('homepage_labels'))
                        <li class="nav-item">
                            <a href="{{ route('homepage-labels.index') }}" class="nav-link">
                                <i class="nav-icon far fa-file-alt"></i>
                                <p>Homepage Label</p>
                            </a>
                        </li>
                    @endif

                @endif

            </ul>
        </nav>
    </div>
</aside>