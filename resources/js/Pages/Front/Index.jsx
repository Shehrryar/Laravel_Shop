import React, { useEffect, useState } from "react";
import Slider from "react-slick";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import { Link, usePage } from "@inertiajs/react";
import BottomNav from "./Components/BottomNav";
import Sidebar from "./Components/SideBar";
import ProductSlider from "./Components/ProductSlider";
import WishlistButton from "./Components/WishlistButton";

export default function HomePage() {
    const {
        categories,
        recommended_products,
        featured_products,
        latest_products,
        wishlistitems,
        dis_products,
        discount,
        brands,
        cartquantity,
        homelables,
    } = usePage().props;

    const [loading, setLoading] = useState(true);
    const [activeId, setActiveId] = React.useState(homelables[0].id);
    useEffect(() => {
        // simulate loader finishing
        const t = setTimeout(() => setLoading(false), 600);
        return () => clearTimeout(t);
    }, []);

    // small helper to toggle sidebar
    const settings = {
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        dots: false,
        responsive: [
            { breakpoint: 992, settings: { slidesToShow: 3 } },
            { breakpoint: 576, settings: { slidesToShow: 2 } },
        ],
    };
    /*=====================
    03.  Header sidebar 
  ==========================*/
    function toggleSidebar() {
        $(".header-sidebar").addClass("show");
        $(".overlay-sidebar").addClass("show");
        $("body").css({
            overflow: "hidden",
        });
    }
    $(".overlay-sidebar").on("click", function () {
        $(".header-sidebar").removeClass("show");
        $(".overlay-sidebar").removeClass("show");
        $("body").css({
            overflow: "auto",
        });
    });
    return (
        <>
            {/* loader start */}
            {/* loader end */}
            {/* header start */}
            <header>
                <div
                    className="nav-bar"
                    id="opensidebar"
                    onClick={toggleSidebar}
                >
                    <img
                        src="front-assets/svg/bar.svg"
                        className="img-fluid"
                        alt="menu"
                    />
                </div>
                <a className="brand-logo">
                    <img
                        src="front-assets/images/logo.png"
                        className="img-fluid main-logo"
                        alt="logo"
                    />
                    <img
                        src="front-assets/images/logo-white.png"
                        className="img-fluid white-logo"
                        alt="logo white"
                    />
                </a>
                <div className="header-option">
                    <ul>
                        <li>
                            <Link href={route("product.search")}>
                                <i className="iconly-Search icli" />
                            </Link>
                        </li>
                        <li>
                            <a href="notification.html">
                                <i className="iconly-Notification icli" />
                            </a>
                        </li>
                        <li>
                            <Link href={route("account.wishlist")}>
                                <i className="iconly-Heart icli" />
                            </Link>
                        </li>
                        <li>
                            <Link href={route("front.cart")}>
                                <i className="iconly-Buy icli" />
                                <span>{cartquantity.totalQuantity}</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>

            <Sidebar />

            {/* header end */}
            {/* category start */}
            <section className="category-section top-space">
                <ul className="category-slide">
                    {categories?.map((cat) => (
                        <li key={cat.id || cat.name}>
                            <Link
                                href={route("product.getInnerCategory", {
                                    categoryid: cat.id,
                                })}
                                className="category-box"
                            >
                                <img
                                    src={`/upload/category/${cat.image}`}
                                    alt={cat.name}
                                    className="img-fluid"
                                />
                                <h4>{cat.name || "Kids"}</h4>
                            </Link>
                        </li>
                    ))}
                </ul>
            </section>
            <div className="divider t-12 b-20" />
            {/* category end */}
            {/* home slider start */}
            <section className="pt-0 home-section ratio_55">
                <div className="home-slider slick-default theme-dots">
                    <div>
                        <div className="slider-box">
                            <img
                                src="front-assets/images/home-slider/1.jpg"
                                className="img-fluid bg-img"
                                alt="slide"
                            />
                            <div className="slider-content">
                                <div>
                                    <h2>Welcome To Multikart</h2>
                                    <h1>Flat 50% OFF</h1>
                                    <h6>Free Shipping Till Mid Night</h6>
                                    <a
                                        href="shop.html"
                                        className="btn btn-solid"
                                    >
                                        SHOP NOW
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {/* home slider end */}

            {/* deals section start */}
            <section className="deals-section px-15 pt-0">
                <div className="title-part">
                    <h2>Deals of the Day</h2>
                    <Link href={route("front.shop")}>See All</Link>
                </div>

                <div className="product-section">
                    <div className="row gy-3">
                        {dis_products && dis_products.length > 0 ? (
                            dis_products.map((product) => {
                                const avgRating =
                                    product.product_ratings_count > 0
                                        ? product.product_ratings_sum_rating /
                                          product.product_ratings_count
                                        : 0;

                                return (
                                    <div className="col-12" key={product.id}>
                                        <div className="product-inline">
                                            <Link
                                                href={route(
                                                    "front.product",
                                                    product.slug
                                                )}
                                            >
                                                <img
                                                    src={
                                                        product.product_images
                                                            ?.length
                                                            ? `/upload/products/${product.product_images[0].image}`
                                                            : "/admin-assets/img/default-150x150.png"
                                                    }
                                                    className="img-fluid"
                                                    alt={product.title}
                                                />
                                            </Link>

                                            <div className="product-inline-content">
                                                <div>
                                                    <Link
                                                        href={route(
                                                            "front.product",
                                                            product.slug
                                                        )}
                                                    >
                                                        <h4>{product.title}</h4>
                                                    </Link>

                                                    <div className="product_rating">
                                                        <ul className="ratings">
                                                            {[
                                                                1, 2, 3, 4, 5,
                                                            ].map((star) => (
                                                                <li key={star}>
                                                                    <i
                                                                        className={`iconly-Star icbo ${
                                                                            avgRating >=
                                                                            star
                                                                                ? "filled"
                                                                                : avgRating >=
                                                                                  star -
                                                                                      0.5
                                                                                ? "half"
                                                                                : "empty"
                                                                        }`}
                                                                    ></i>
                                                                </li>
                                                            ))}
                                                        </ul>
                                                    </div>

                                                    <div className="price">
                                                        <h4>
                                                            {product.discount_value !=
                                                            0 ? (
                                                                <>
                                                                    $
                                                                    {
                                                                        product.discounted_price
                                                                    }
                                                                    <del className="text-muted small ms-1">
                                                                        $
                                                                        {
                                                                            product.actual_price
                                                                        }
                                                                    </del>
                                                                    <span className="text-danger ms-1">
                                                                        {
                                                                            product.discount_value
                                                                        }
                                                                        %
                                                                    </span>
                                                                </>
                                                            ) : (
                                                                <>
                                                                    $
                                                                    {
                                                                        product.actual_price
                                                                    }
                                                                </>
                                                            )}
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <WishlistButton
                                                productId={product.id}
                                                isWishlisted={
                                                    wishlistitems[product.id]
                                                }
                                            />
                                        </div>
                                    </div>
                                );
                            })
                        ) : (
                            <div className="col-12">
                                <p>No deals available.</p>
                            </div>
                        )}
                    </div>
                </div>
            </section>

            <div className="divider" />
            {/* deals section end */}
            {/* tab section start */}
            <section className="pt-0 tab-section">
                <div className="title-section px-15">
                    <h2>Find your Style</h2>
                    <h3>Super Summer Sale</h3>
                </div>
                <div className="tab-section">
                    <ul className="nav nav-tabs theme-tab pl-15">
                        {homelables.map((label) => (
                            <li key={label.id} className="nav-item">
                                <button
                                    type="button"
                                    className={`nav-link ${
                                        activeId === label.id ? "active" : ""
                                    }`}
                                    onClick={() => setActiveId(label.id)}
                                >
                                    {label.label_name}
                                </button>
                            </li>
                        ))}
                    </ul>

                    <div className="tab-content px-15">
                        <div
                            className="tab-pane fade show active"
                            id="trending"
                        >
                            <div className="row gy-3 gx-3">
                                <div className="col-md-4 col-6">
                                    <div className="product-box ratio_square">
                                        <div className="img-part">
                                            <a href="product.html">
                                                <img
                                                    src="front-assets/images/products/4.jpg"
                                                    alt=""
                                                    className="img-fluid bg-img"
                                                />
                                            </a>
                                            <div className="wishlist-btn">
                                                <i className="iconly-Heart icli" />
                                                <i className="iconly-Heart icbo" />
                                                <div className="effect-group">
                                                    <span className="effect" />
                                                    <span className="effect" />
                                                    <span className="effect" />
                                                    <span className="effect" />
                                                    <span className="effect" />
                                                </div>
                                            </div>
                                        </div>
                                        <div className="product-content">
                                            <ul className="ratings">
                                                <li>
                                                    <i className="iconly-Star icbo" />
                                                </li>
                                                <li>
                                                    <i className="iconly-Star icbo" />
                                                </li>
                                                <li>
                                                    <i className="iconly-Star icbo" />
                                                </li>
                                                <li>
                                                    <i className="iconly-Star icbo" />
                                                </li>
                                                <li>
                                                    <i className="iconly-Star icbo empty" />
                                                </li>
                                            </ul>
                                            <a href="product.html">
                                                <h4>Blue Denim Jacket</h4>
                                            </a>
                                            <div className="price">
                                                <h4>
                                                    $32.00 <del>$35.00</del>
                                                    <span>20%</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/* other tab panes can be built similarly - keeping structure concise */}
                    </div>
                </div>
            </section>
            {/* tab section end */}
            {/* timer banner start */}
            <section className="banner-timer">
                <div className="banner-bg">
                    <div className="banner-content">
                        <div>
                            <h6>Denim Wear</h6>
                            <h2>Sales Starts In</h2>
                            <div className="counters">
                                <div className="counter d-none">
                                    <span id="days">NA</span>
                                    <p>Days</p>
                                </div>
                                <div className="counter">
                                    <span id="hours">NA</span>
                                    <p>Hours</p>
                                </div>
                                <div className="counter">
                                    <span id="minutes">NA</span>
                                    <p>Minutes</p>
                                </div>
                                <div className="counter">
                                    <span id="seconds">NA</span>
                                    <p>Seconds</p>
                                </div>
                            </div>
                            <a href="shop.html">explore now</a>
                        </div>
                    </div>
                    <div className="banner-img">
                        <img
                            src="front-assets/images/banner-image.png"
                            className="img-fluid"
                            alt="banner"
                        />
                    </div>
                </div>
            </section>
            {/* timer banner end */}
            {/* brands section start */}
            <section className="brand-section pl-15">
                <h2 className="title">Biggest Deals on Top Brands</h2>
                <Slider {...settings} className="brand-slider slick-default">
                    {brands.map((bran, i) => (
                        <div key={i}>
                            <Link
                                className="brand-box"
                                href={route("front.shop", {
                                    brand_id: [bran.id],
                                })}
                            >
                                <h4
                                    className="brand-text text-center fw-semibold"
                                    style={{
                                        background:
                                            "linear-gradient(90deg, #ff7e5f, #feb47b)",
                                        WebkitBackgroundClip: "text",
                                        WebkitTextFillColor: "transparent",
                                        fontSize: "1.3rem",
                                        letterSpacing: "1px",
                                        textTransform: "uppercase",
                                    }}
                                >
                                    {bran.name}
                                </h4>
                            </Link>
                        </div>
                    ))}
                </Slider>
            </section>
            <div className="divider" />
            {/* brands section end */}
            {/* kids corner section start */}
            <section className="pt-0 product-slider-section overflow-hidden">
                {/* <div className="title-section px-15">
                    <h2>The Featured Products</h2>
                    <h3>Clothing for your Li’l One’s</h3>
                </div> */}
                <ProductSlider
                    title="The Featured Products"
                    products={featured_products}
                    wishlist={wishlistitems}
                />
            </section>
            {/* kids corner section end */}
            {/* offer corner start */}

            <section className="offer-corner-section px-15">
                <h2 className="title">Offer Corner</h2>
                {discount && discount.length > 0 ? (
                    <div className="row g-3">
                        {discount.map((t, idx) => (
                            <div className="col-6" key={idx}>
                                <div className="offer-box">
                                    <Link
                                        href={route("front.shop", {
                                            disct_id: [t.id],
                                        })}
                                    >
                                        {t.name}
                                    </Link>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <p className="text-muted">No offers available right now.</p>
                )}
            </section>
            {/* offer corner end */}
            <section className="panel-space" />
            {/* bottom panel start */}
            <BottomNav />
            {/* bottom panel end */}
        </>
    );
}
