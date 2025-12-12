import React from "react";
import Slider from "react-slick";
import { Link } from "@inertiajs/react";
import WishlistButton from "./WishlistButton";
const ProductSlider = ({
    title = "Similar Products",
    products = [],
    wishlist = [],
}) => {
    const settings = {
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2500,
        arrows: false,
        dots: false,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 4 } },
            { breakpoint: 992, settings: { slidesToShow: 3 } },
            { breakpoint: 576, settings: { slidesToShow: 2 } },
        ],
    };
    if (!products.length) {
        return null; // or a message like <p>No products found</p>
    }
    return (
        <section className="pt-0 product-slider-section overflow-hidden">
            <div className="title-section px-15">
                <h2>{title}</h2>
            </div>
            <div className="product-slider slick-default pl-15">
                <Slider {...settings}>
                    {products.map((p, i) => {
                        const avgRating =
                            p.product_ratings_count > 0
                                ? p.product_ratings_sum_rating /
                                  p.product_ratings_count
                                : 0;

                        return (
                            <div
                                key={p.id || i} // ← FIXED
                                className="product-box ratio_square"
                            >
                                <div className="img-part">
                                    <Link
                                        href={
                                            p.link ||
                                            `/product/${p.slug || p.id}`
                                        }
                                    >
                                        <img
                                            style={{
                                                height: "170px",
                                                width: "100%",
                                            }}
                                            src={
                                                p.product_images?.length
                                                    ? `/upload/products/${p.product_images[0].image}`
                                                    : "/admin-assets/img/default-150x150.png"
                                            }
                                            alt={p.title || "Product"}
                                            className="img-fluid bg-img"
                                        />
                                    </Link>
                                    <WishlistButton
                                        productId={p.id}
                                        isWishlisted={wishlist[p.id]}
                                    />
                                </div>
                                <div className="product-content">
                                    {/* Dynamic Ratings */}
                                    <ul className="ratings">
                                        {[1, 2, 3, 4, 5].map((star) => (
                                            <li key={star}>
                                                <i
                                                    className={`iconly-Star icbo ${
                                                        avgRating >= star
                                                            ? "filled"
                                                            : avgRating >=
                                                              star - 0.5
                                                            ? "half"
                                                            : "empty"
                                                    }`}
                                                ></i>
                                            </li>
                                        ))}
                                    </ul>
                                    <Link
                                        href={
                                            p.link ||
                                            `/product/${p.slug || p.id}`
                                        }
                                    >
                                        <h4>{p.title}</h4>
                                    </Link>
                                    <div className="price">
                                        <h4>
                                            {p.discount_value != 0 ? (
                                                <>
                                                    ${p.discounted_price}
                                                    <del className="text-muted small ms-1">
                                                        ${p.actual_price}
                                                    </del>
                                                    <span className="text-danger ms-1">
                                                        {p.discount_value}%
                                                    </span>
                                                </>
                                            ) : (
                                                <>${p.actual_price}</>
                                            )}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </Slider>
            </div>
        </section>
    );
};
export default ProductSlider;
