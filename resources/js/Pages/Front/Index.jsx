import React, { useEffect, useState } from "react";
import Slider from "react-slick";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import { Link, usePage, router } from "@inertiajs/react";
import BottomNav from "./Components/BottomNav";
import Sidebar from "./Components/SideBar";
import ProductSlider from "./Components/ProductSlider";
import WishlistButton from "./Components/WishlistButton";
import CountdownTimer from "./Components/CountdownTimer";
import HomeProductTabs from "./Components/HomeProductTabs";
import { UseCurrency } from "./Components/UseCurrency";
export default function HomePage() {
    const { convertPrice, symbol } = UseCurrency();
    const {
        categories,
        featured_products,
        wishlistitems,
        dis_products,
        discount,
        brands,
        cartquantity,
        homelables,
        translations,
        productsByLabel,
        current_currency,
    } = usePage().props;
    const [loading, setLoading] = useState(true);
    const [sidebarOpen, setSidebarOpen] = useState(false);
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
    const openSidebar = () => {
        setSidebarOpen(true);
        document.body.style.overflow = "hidden";
    };
    const closeSidebar = () => {
        setSidebarOpen(false);
        document.body.style.overflow = "auto";
    };
    useEffect(() => {
        // Ensure scrolling is enabled whenever a page loads
        document.body.style.overflow = "auto";
        // Optional cleanup when component unmounts
        return () => {
            document.body.style.overflow = "auto";
        };
    }, []);
    return (
        <>
            {/* loader start */}
            {/* loader end */}
            {/* header start */}
            <header>
                <div className="nav-bar" id="opensidebar" onClick={openSidebar}>
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
                                {cartquantity.totalQuantity > 0 ? (
                                    <span>{cartquantity.totalQuantity}</span>
                                ) : null}
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>
            <Sidebar open={sidebarOpen} onClose={closeSidebar} />
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
                                    className="img-fluid"
                                />
                                <h4>{cat.translated_name || "Kids"}</h4>
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
                                    <h2>
                                        {translations["Welcome To Multikart"]}
                                    </h2>
                                    <h1>{translations["Flat 50% OFF"]}</h1>
                                    <h6>
                                        {
                                            translations[
                                                "Free Shipping Till Mid Night"
                                            ]
                                        }
                                    </h6>

                                    <Link className="btn btn-solid"href={route("front.shop")}>
                                        SHOP NOW
                                    </Link>

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
                    <h2>{translations["Deals of the Day"]}</h2>
                    <Link href={route("front.shop")}>
                        {translations["See All"]}
                    </Link>
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
                                                    product.slug,
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
                                                            product.slug,
                                                        )}
                                                    >
                                                        <h4>
                                                            {
                                                                product.translated_title
                                                            }
                                                        </h4>
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
                                                            {product.discount_value !==
                                                            0 ? (
                                                                <>
                                                                    {symbol}
                                                                    {convertPrice(
                                                                        product.discounted_price,
                                                                    )}
                                                                    <del className="text-muted small ms-1">
                                                                        {symbol}
                                                                        {convertPrice(
                                                                            product.actual_price,
                                                                        )}
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
                                                                    {symbol}
                                                                    {convertPrice(
                                                                        product.actual_price,
                                                                    )}
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
                                <p>{translations["No deals available."]}</p>
                            </div>
                        )}
                    </div>
                </div>
            </section>
            <div className="divider" />
            <HomeProductTabs
                homelables={homelables}
                productsByLabel={productsByLabel}
                wishlistitems={wishlistitems}
                translations={translations}
            />
            {/* timer banner start */}
            <section className="banner-timer">
                <div className="banner-bg">
                    <div className="banner-content">
                        <div>
                            <h6>{translations["Denim Wear"]}</h6>
                            <h2>{translations["Sales Starts In"]}</h2>
                            <CountdownTimer initialSeconds={3600} />
                            <Link href="shop.html">
                                {translations["explore now"]}
                            </Link>
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
                <h2 className="title">
                    {translations["Biggest Deals on Top Brands"]}
                </h2>
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
                                    {/* {bran.name} */}
                                    {bran.translated_name}
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
                <ProductSlider
                    title="The Featured Products"
                    products={featured_products}
                    wishlist={wishlistitems}
                    current_currency={current_currency} // ← ADD THIS
                />
            </section>
            {/* kids corner section end */}
            {/* offer corner start */}
            <section className="offer-corner-section px-15">
                <h2 className="title">{translations["Offer Corner"]}</h2>
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
                    <p className="text-muted">
                        {translations["No offers available right now."]}
                    </p>
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
