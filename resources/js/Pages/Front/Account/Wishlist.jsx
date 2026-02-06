import React from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
import BottomNav from "../Components/BottomNav";
import { UseCurrency } from "../Components/UseCurrency";
const Wishlist = () => {
    const { wishlist, translations } = usePage().props;

    const { symbol, convertPrice } = UseCurrency();

    //Handle remove item
    const handleRemove = async (productId) => {
        try {
            const response = await axios.post(route("front.addtowishlist"), {
                product_id: productId,
                action: "remove",
            });
            if (
                response.data.status === false &&
                response.data.userlogin === false
            ) {
                // Redirect if not logged in
                window.location.href = route("front.login");
                return;
            }
            router.visit(route("account.wishlist"));
        } catch (error) {
            console.error("Error removing wishlist item:", error);
        }
    };
    //  Handle add to cart (example)
    // const handleAddToCart = async (productId, color_id, size_id) => {
    //     try {
    //         const response = await axios.post(route("front.addToCart"), {
    //             product_id: productId,
    //             color_id: color_id,
    //             size_id: size_id,
    //             page: "wishlist",
    //         });
    //         if (
    //             response.data.status === false &&
    //             response.data.userlogin === false
    //         ) {
    //             window.location.href = route("front.login");
    //             return;
    //         }
    //     } catch (error) {
    //         console.error("Error adding to cart:", error);
    //     }
    // };
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>{translations["Your Wishlist"]} ({wishlist.length})</h2>
                        </div>
                    </Link>
                </div>
                <div className="header-option">
                    <ul>
                        <li>
                            <Link href={route("front.cart")}>
                                <i className="iconly-Buy icli"></i>
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>
            {/* Wishlist Items */}
            <section className="cart-section pt-0 top-space section-b-space">
                {wishlist.length > 0 ? (
                    wishlist.map((item) => {
                        // Calculate average rating BEFORE return
                        const avgRating =
                            item.product_ratings_count > 0
                                ? item.product_ratings_sum_rating /
                                  item.product_ratings_count
                                : 0;
                        return (
                            <React.Fragment key={item.id}>
                                <div className="cart-box px-15">
                                    <Link
                                        href={route("front.product", item.slug)}
                                        className="cart-img"
                                    >
                                        <img
                                            src={
                                                item.product_images?.length
                                                    ? `/upload/products/${item.product_images[0].image}`
                                                    : "/admin-assets/img/default-150x150.png"
                                            }
                                            className="img-fluid"
                                            alt={
                                                item.product?.title || "Product"
                                            }
                                        />
                                    </Link>
                                    <div className="cart-content">
                                        <Link>
                                            <h4>
                                                {item.translated_title ||
                                                    "Unknown Product"}
                                            </h4>
                                        </Link>
                                        <div className="product_rating">
                                            <ul className="ratings">
                                                {[1, 2, 3, 4, 5].map((star) => (
                                                    <li key={star}>
                                                        <i
                                                            className={`iconly-Star icbo ${
                                                                avgRating >=
                                                                star
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
                                        </div>
                                        <div className="price">
                                            <h4>
                                                {item.discount_value != 0 ? (
                                                    <>
                                                        {symbol}{convertPrice(item.discounted_price)}
                                                        <del className="text-muted small ms-1">
                                                            {symbol}{convertPrice(item.actual_price)}
                                                        </del>
                                                        <span className="text-danger ms-1">
                                                            {
                                                                item.discount_value
                                                            }
                                                            %
                                                        </span>
                                                    </>
                                                ) : (
                                                    <>{symbol}{convertPrice(item.actual_price)}</>
                                                )}
                                            </h4>
                                        </div>
                                        {/* Here you can use avgRating if needed */}
                                        {/* <p>Rating: {avgRating.toFixed(1)}</p> */}
                                        <div className="cart-option">
                                            <Link
                                                href={route(
                                                    "front.product",
                                                    item.slug
                                                )}
                                            >
                                                <h5
                                                    style={{
                                                        cursor: "pointer",
                                                    }}
                                                    // onClick={() =>
                                                    //     handleAddToCart(
                                                    //         item.id,
                                                    //         item.color_id,
                                                    //         item.size_id
                                                    //     )
                                                    // }
                                                >
                                                    <i className="iconly-Buy icli"></i>{" "}
                                                    {translations["Add to Cart"]}
                                                </h5>
                                            </Link>
                                            <span className="divider-cls">
                                                |
                                            </span>
                                            <h5
                                                style={{
                                                    cursor: "pointer",
                                                    color: "red",
                                                }}
                                                onClick={() =>
                                                    handleRemove(item.id)
                                                }
                                            >
                                                <i className="iconly-Delete icli"></i>{" "}
                                                {translations["Remove"]}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div className="divider"></div>
                            </React.Fragment>
                        );
                    })
                ) : (
                    <div className="text-center py-5">
                        <i
                            className="iconly-Heart icbo"
                            style={{ fontSize: "48px" }}
                        ></i>
                        <h4 className="mt-3">{translations["Your wishlist is empty"]}</h4>
                        <Link
                            href={route("front.shop")}
                            className="btn btn-solid mt-3"
                        >
                            {translations["Continue Shopping"]}
                        </Link>
                    </div>
                )}
            </section>
            <section className="panel-space" />
            {/* bottom panel start */}
            <BottomNav />
            {/* bottom panel end */}
        </>
    );
};
export default Wishlist;