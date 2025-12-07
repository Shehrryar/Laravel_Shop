import React from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import BottomNav from "../Components/BottomNav";
const Wishlist = () => {
    const { wishlist } = usePage().props;


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
    const handleAddToCart = async (productId) => {
        try {
            const response = await axios.post(route("front.addtocart"), {
                product_id: productId,
                quantity: 1,
            });
            if (
                response.data.status === false &&
                response.data.userlogin === false
            ) {
                window.location.href = route("front.login");
                return;
            }
        } catch (error) {
            console.error("Error adding to cart:", error);
        }
    };
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Your Wishlist ({wishlist.length})</h2>
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
                    wishlist.map((item) => (
                        <React.Fragment key={item.id}>
                            <div className="cart-box px-15">
                                <Link
                                    href={route("front.product", item.product.slug)}
                                    className="cart-img"
                                >
                                    <img
                                        src={
                                            item.product?.product_images &&
                                            item.product.product_images.length >
                                                0
                                                ? `/upload/products/${item.product.product_images[0].image}`
                                                : "/admin-assets/img/default-150x150.png"
                                        }
                                        className="img-fluid"
                                        alt={item.product?.title || "Product"}
                                    />
                                </Link>
                                <div className="cart-content">
                                    <Link>
                                        <h4>
                                            {item.product?.title ||
                                                "Unknown Product"}
                                        </h4>
                                    </Link>
                                    <h5 className="content-color">
                                        {item.product?.brand || "No brand"}
                                    </h5>
                                    <div className="price">
                                        <h4>
                                            ${item.product?.price || "0.00"}{" "}
                                            {item.product?.old_price && (
                                                <>
                                                    <del>
                                                        $
                                                        {item.product.old_price}
                                                    </del>{" "}
                                                    <span>20%</span>
                                                </>
                                            )}
                                        </h4>
                                    </div>
                                    <div className="cart-option">
                                        <h5
                                            style={{ cursor: "pointer" }}
                                            onClick={() =>
                                                handleAddToCart(
                                                    item.product?.id
                                                )
                                            }
                                        >
                                            <i className="iconly-Buy icli"></i>{" "}
                                            Add to Cart
                                        </h5>
                                        <span className="divider-cls">|</span>
                                        <h5
                                            style={{
                                                cursor: "pointer",
                                                color: "red",
                                            }}
                                            onClick={() =>
                                                handleRemove(item.product?.id)
                                            }
                                        >
                                            <i className="iconly-Delete icli"></i>{" "}
                                            Remove
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div className="divider"></div>
                        </React.Fragment>
                    ))
                ) : (
                    <div className="text-center py-5">
                        <i
                            className="iconly-Heart icbo"
                            style={{ fontSize: "48px" }}
                        ></i>
                        <h4 className="mt-3">Your wishlist is empty</h4>
                        <Link
                            href={route("front.shop")}
                            className="btn btn-solid mt-3"
                        >
                            Continue Shopping
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
