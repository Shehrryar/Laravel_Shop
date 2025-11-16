import React from "react";
import Slider from "react-slick";
import { Link } from "@inertiajs/react";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import WishlistButton from "./WishlistButton";
const ProductSlider = ({
    title = "Similar Products",
    products = [],
    wishlist = [],
}) => {
    const settings = {
        slidesToShow: 5,
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
            <div className="pl-15">
                <Slider {...settings}>
                    {products.map((p, i) => {
                        //  Calculate average rating
                        const avgRating =
                            p.product_ratings_count > 0
                                ? p.product_ratings_sum_rating /
                                  p.product_ratings_count
                                : 0;
                        return (
                            <div key={i} className="px-2">
                                <div className="product-box ratio_square">
                                    <div className="img-part">
                                        <Link
                                            href={
                                                p.link ||
                                                `/product/${p.slug || p.id}`
                                            }
                                        >
                                            <img
                                                src={
                                                    p.image
                                                        ? p.image
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
                                        {/* ✅ Dynamic Ratings */}
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
                                                $
                                                {p.discounted_price ??
                                                    p.actual_price}
                                                .00{" "}
                                                {p.discount_value > 0 && (
                                                    <>
                                                        <del>
                                                            ${p.actual_price}.00
                                                        </del>{" "}
                                                        <span>
                                                            ({p.discount_value}%
                                                            off)
                                                        </span>
                                                    </>
                                                )}
                                            </h4>
                                        </div>
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
