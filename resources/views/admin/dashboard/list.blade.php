@extends('admin.layout.app')

@section('content')
    @php
        $adminUser = Auth::guard('admin')->user();
        $isVendor = $adminUser && (int) $adminUser->role === 3;
        $permissions = $adminUser->permissions ?? [];

        $canOpenOrders = !$isVendor || !empty($permissions['orders']);
        $canOpenUsers = !$isVendor || !empty($permissions['users']);
        $canOpenProducts = !$isVendor || !empty($permissions['products']);
        $canOpenStock = !$isVendor || !empty($permissions['stock']);
    @endphp

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($isVendor)
                        <h1>Vendor Dashboard</h1>
                    @else
                        <h1>Dashboard</h1>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ $order_count ?? 0 }}</h3>

                            @if ($isVendor)
                                <p>My Store Orders</p>
                            @else
                                <p>Total Orders</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                        @if ($canOpenOrders)
                            <a href="{{ route('order.index') }}" class="small-box-footer text-dark">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @else
                            <a href="javascript:void(0);" class="small-box-footer text-muted">
                                Permission required
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ $user_count ?? 0 }}</h3>

                            @if ($isVendor)
                                <p>My Customers</p>
                            @else
                                <p>Total Customers</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>

                        @if ($canOpenUsers)
                            <a href="{{ route('users.index') }}" class="small-box-footer text-dark">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @else
                            <a href="javascript:void(0);" class="small-box-footer text-muted">
                                Permission required
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ $product_count ?? 0 }}</h3>

                            @if ($isVendor)
                                <p>My Products</p>
                            @else
                                <p>Total Products</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-pricetag"></i>
                        </div>

                        @if ($canOpenProducts)
                            <a href="{{ route('product.index') }}" class="small-box-footer text-dark">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @else
                            <a href="javascript:void(0);" class="small-box-footer text-muted">
                                Permission required
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ $stock_count ?? 0 }}</h3>

                            @if ($isVendor)
                                <p>My Stock Quantity</p>
                            @else
                                <p>Total Stock Quantity</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-cube"></i>
                        </div>

                        @if ($canOpenStock)
                            <a href="{{ route('stock.index') }}" class="small-box-footer text-dark">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        @else
                            <a href="javascript:void(0);" class="small-box-footer text-muted">
                                Permission required
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box card">
                        <div class="inner">
                            <h3>{{ number_format($totalSales ?? 0, 2) }}$</h3>

                            @if ($isVendor)
                                <p>My Store Sales</p>
                            @else
                                <p>Total Sales</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-cash"></i>
                        </div>

                        <a href="javascript:void(0);" class="small-box-footer">
                            &nbsp;
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('customjs')
@endsection