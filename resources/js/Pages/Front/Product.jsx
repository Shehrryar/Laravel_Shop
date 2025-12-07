import React, { useState } from "react";
import Slider from "react-slick";
import axios from "axios";
import { Link, usePage, router } from "@inertiajs/react";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import ProductSlider from "./Components/ProductSlider";
import ProductReviewAndRating from "./Components/ProductReviewAndRating";
const ProductDetails = () => {
    const { product, showrelatedproduct, wishlistitems } = usePage().props;
    const [selectedSize, setSelectedSize] = useState(null);
    const [selectedColor, setSelectedColor] = useState(null);
    const [quantity, setQuantity] = useState(1);
    const [filteredColors, setFilteredColors] = useState([]);
    const [variantPrice, setVariantPrice] = useState({
        discounted: product.discounted_price,
        actual: product.actual_price,
        discount_value: product.discount_value,
        baseactualprice: product.actual_price,
        basediscountedprice: product.discounted_price,
    });

    const [message, setMessage] = useState({ text: "", type: "" });
    const handleSizeChange = (sizeId) => {
        setSelectedSize(sizeId);
        const matchedColors = product.color.filter(
            (color) => parseInt(color.size_id) === parseInt(sizeId)
        );
        setFilteredColors(matchedColors);
        setSelectedColor(null);
        updateVariantPrice(sizeId, selectedColor);
    };
    const handleColorChange = (colorId) => {
        setSelectedColor(colorId);
        updateVariantPrice(selectedSize, colorId);
    };
    const handleIncrease = () => {
        const newQty = quantity + 1;
        setQuantity(newQty);
        updateVariantPrice(selectedSize, selectedColor, newQty);
    };
    const handleDecrease = () => {
        if (quantity > 1) {
            const newQty = quantity - 1;
            setQuantity(newQty);
            updateVariantPrice(selectedSize, selectedColor, newQty);
        }
    };
    const handleQuantityChange = (e) => {
        const value = Math.max(1, parseInt(e.target.value) || 1);
        setQuantity(value);
        updateVariantPrice(selectedSize, selectedColor, value);
    };

    const updateVariantPrice = (sizeId, colorId, qty = quantity) => {
        // Always use product's original base price
        const originalBasePrice = parseFloat(product.actual_price);
        const originalDiscountedPrice = parseFloat(product.discounted_price);
        const discountValue = product.discount_value || 0;

        let finalBasePrice = originalBasePrice;
        let finalDiscountedPrice = originalDiscountedPrice;

        // Add size price if selected
        if (sizeId) {
            const size = product.size.find((s) => s.id === sizeId);
            if (size?.price) {
                finalBasePrice += parseFloat(size.price);
                finalDiscountedPrice += parseFloat(size.price);
            }
        }

        // Add color price if selected
        if (colorId) {
            const color = product.color.find((c) => c.id === colorId);
            if (color?.price) {
                finalBasePrice += parseFloat(color.price);
                finalDiscountedPrice += parseFloat(color.price);
            }
        }

        // Reapply discount on updated finalBasePrice
        if (discountValue > 0) {
            finalDiscountedPrice =
                finalBasePrice - (finalBasePrice * discountValue) / 100;
        }

        // Multiply final prices by quantity
        const finalActual = (finalBasePrice * qty).toFixed(2);
        const finalDiscounted = (finalDiscountedPrice * qty).toFixed(2);

        setVariantPrice({
            actual: finalActual,
            discounted: finalDiscounted,
            discount_value: discountValue,
            baseactualprice: finalBasePrice.toFixed(2),
            basediscountedprice: finalDiscountedPrice.toFixed(2),
        });
    };

    const handleAddToCart = async () => {
        const popupMessage = new bootstrap.Modal(
            document.getElementById("popupMessage")
        );

        if (product.size && product.size.length > 0) {
            if (!selectedSize) {
                setMessage({
                    text: "Please select a size before adding to cart.",
                    type: "error",
                });
                popupMessage.show();
                return;
            }
        }
        try {
            const response = await axios.post(route("front.addToCart"), {
                product_id: product.id,
                size_id: selectedSize,
                color_id: selectedColor, // optional
                quantity: quantity,
                variantPrice: variantPrice,
                page: "product",
            });
            if (
                response.data.status === false &&
                response.data.userlogin === false
            ) {
                window.location.href = route("front.login");
                return;
            }
            if (response.data.status && response.data.add_to_cart) {
                setMessage({
                    text: "Product added to cart successfully!",
                    type: "success",
                });
                popupMessage.show();
            } else {
                setMessage({
                    text: response.data.message || "Something went wrong!",
                    type: "error",
                });
                popupMessage.show();
            }
        } catch (error) {
            setMessage({
                text: "Something went wrong! Please try again.",
                type: "error",
            });
            popupMessage.show();
        }
        setTimeout(() => {
            setMessage({ text: "", type: "" });
        }, 3000);
    };
    const [rating, setRating] = useState(0);
    const [hoverRating, setHoverRating] = useState(0);
    const [comment, setComment] = useState("");
    const handleStarClick = (value) => setRating(value);
    const handleSubmit = async (e) => {
        const popupMessage = new bootstrap.Modal(
            document.getElementById("popupMessage")
        );
        e.preventDefault();
        try {
            const response = await axios.post(route("front.productRating"), {
                product_id: product.id,
                rating: rating,
                comment: comment,
            });
            if (response.data.status) {
                setMessage({
                    text:
                        response.data.message ||
                        "Review submitted successfully!",
                    type: "success",
                });
                setComment("");
                setRating(0);
                popupMessage.show();

                router.reload({ only: ["product"] });
            } else {
                setMessage({
                    text:
                        response.data.message ||
                        "You have already rated this product.",
                    type: "error",
                });
                popupMessage.show();
            }
        } catch (error) {
            console.error("Error submitting review:", error);
            setMessage({
                text: "Something went wrong while submitting your review.",
                type: "error",
            });
            popupMessage.show();
        }
    };

    const imageSliderSettings = {
        dots: true,
        infinite: true,
        arrows: false,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
    };

    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>{product.title}</h2>
                        </div>
                    </Link>
                </div>
                <div className="header-option">
                    <ul>
                        <li>
                            <a href="#">
                                <img
                                    src="/front-assets/svg/share-2.svg"
                                    alt="Share"
                                    className="img-fluid"
                                />
                            </a>
                        </li>
                        <li>
                            <Link href={route("account.wishlist")}>
                                <i className="iconly-Heart icli"></i>
                            </Link>
                        </li>
                        <li>
                            <Link href={route("front.cart")}>
                                <i className="iconly-Buy icli"></i>
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>
            {/* Product Section */}

            <section className="product-page-section top-space pt-0">
                {/*  Main Product Image Slider */}

                <div className="home-slider slick-default theme-dots ratio_asos overflow-hidden">
                    <Slider {...imageSliderSettings}>
                        {product?.product_images?.length > 0 ? (
                            product.product_images.map((img, i) => (
                                <div key={i}>
                                    <div className="home-img">
                                        <img
                                            src={`/upload/products/${img.image}`}
                                            alt={`Product ${i + 1}`}
                                            className="img-fluid bg-img"
                                        />
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div>
                                <div className="home-img">
                                    <img
                                        src="/front-assets/images/full-img/2.jpg"
                                        alt="Default"
                                        className="img-fluid bg-img"
                                    />
                                </div>
                            </div>
                        )}
                    </Slider>
                </div>

                {/*  Product Details */}
                <div className="product-detail-box px-15 pt-2">
                    <div className="main-detail">
                        <h2 className="text-capitalize">
                            {product.description}
                        </h2>
                        <h6 className="content-color">
                            Black, off-white and peach-coloured printed flared
                            skirt, has zip closure, attached lining
                        </h6>
                        <div className="rating-section">
                            <ul className="ratings">
                                {[1, 2, 3, 4, 5].map((star) => (
                                    <li key={star}>
                                        <i
                                            className={`iconly-Star icbo ${
                                                star <=
                                                Math.round(product.avg_rating)
                                                    ? ""
                                                    : "empty"
                                            }`}
                                        ></i>
                                    </li>
                                ))}
                            </ul>
                            <h6 className="content-color">
                                ({product.product_ratings_count} ratings)
                            </h6>
                        </div>
                        <div className="price">
                            <h4>
                                {variantPrice.discount_value != 0 ? (
                                    <>
                                        ${variantPrice.discounted}
                                        <del>${variantPrice.actual}</del>
                                        <span>
                                            ({variantPrice.discount_value}% off)
                                        </span>
                                    </>
                                ) : (
                                    <>${variantPrice.actual}</>
                                )}
                            </h4>
                        </div>
                        <h6 className="text-green">inclusive of all taxes</h6>
                    </div>
                </div>

                <div className="divider"></div>
                {/*  Size & Color Selection */}
                <div className="product-detail-box px-15">
                    {product.size.length > 0 ? (
                        <>
                            <div className="size-detail">
                                <h4 className="size-title">
                                    Select Size: <a href="#">Size Chart</a>
                                </h4>
                                <ul className="size-select">
                                    {product.size.map((s) => (
                                        <li
                                            key={s.id}
                                            className={
                                                selectedSize === s.id
                                                    ? "active"
                                                    : ""
                                            }
                                            onClick={() =>
                                                handleSizeChange(s.id)
                                            }
                                        >
                                            <a href="#">{s.code}</a>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </>
                    ) : null}

                    <div className="color-detail">
                        {/*  Show colors even if no size exists */}
                        {product.color.length > 0 && (
                            <>
                                <h4 className="size-title">Select Color:</h4>
                                <ul className="filter-color">
                                    {(product.size.length > 0
                                        ? filteredColors
                                        : product.color
                                    ).map((color) => (
                                        <li
                                            key={color.id}
                                            className={
                                                selectedColor === color.id
                                                    ? "active"
                                                    : ""
                                            }
                                            onClick={() =>
                                                handleColorChange(color.id)
                                            }
                                        >
                                            <a href="#">
                                                <div
                                                    className="color-box"
                                                    style={{
                                                        backgroundColor:
                                                            color.value,
                                                    }}
                                                    title={color.name}
                                                ></div>
                                            </a>
                                        </li>
                                    ))}
                                </ul>
                            </>
                        )}
                    </div>

                    <div className="size-detail">
                        <h4 className="size-title">Quantity:</h4>
                        <div className="qty-counter">
                            <div className="input-group">
                                <button
                                    type="button"
                                    className="btn quantity-left-minus"
                                    onClick={handleDecrease}
                                >
                                    <img
                                        src="/front-assets/svg/minus-square.svg"
                                        alt="-"
                                        className="img-fluid"
                                    />
                                </button>
                                <input
                                    type="number"
                                    name="quantity"
                                    className="form-control form-theme qty-input input-number"
                                    value={quantity}
                                    onChange={handleQuantityChange}
                                    min="1"
                                />
                                <button
                                    type="button"
                                    className="btn quantity-right-plus"
                                    onClick={handleIncrease}
                                >
                                    <img
                                        src="/front-assets/svg/plus-square.svg"
                                        alt="+"
                                        className="img-fluid"
                                    />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="divider"></div>
                <ProductReviewAndRating product={product} />
                {/* Divider */}
                <div className="divider"></div>
                {/* Add Review Section */}
                <div className="px-15">
                    <h4 className="page-title">Write a Review</h4>
                    <form onSubmit={handleSubmit} className="review-form">
                        {/* Star Rating */}
                        <div className="rating-select mb-3">
                            <ul className="ratings d-flex">
                                {[1, 2, 3, 4, 5].map((star) => (
                                    <li key={star}>
                                        <i
                                            className={`iconly-Star icbo ${
                                                (hoverRating || rating) >= star
                                                    ? ""
                                                    : "empty"
                                            }`}
                                            style={{
                                                cursor: "pointer",
                                                color:
                                                    (hoverRating || rating) >=
                                                    star
                                                        ? "#ffc107"
                                                        : "#ccc",
                                            }}
                                            onMouseEnter={() =>
                                                setHoverRating(star)
                                            }
                                            onMouseLeave={() =>
                                                setHoverRating(0)
                                            }
                                            onClick={() =>
                                                handleStarClick(star)
                                            }
                                        ></i>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        {/* Comment Input */}
                        <textarea
                            className="form-control mb-3"
                            placeholder="Write your comment..."
                            value={comment}
                            onChange={(e) => setComment(e.target.value)}
                            rows="4"
                            required
                        ></textarea>
                        {/* Submit Button */}
                        <button type="submit" className="btn btn-solid w-100">
                            Submit Review
                        </button>
                    </form>
                </div>
                <div className="divider"></div>
                {/*  Similar Products Slider */}
                <ProductSlider
                    title="Similar Products"
                    products={showrelatedproduct}
                    wishlist={wishlistitems}
                />
                <div className="panel-space"></div>
                {/*  Fixed Bottom Panel */}
                <div className="fixed-panel">
                    <div className="row">
                        <div className="col-6">
                            <Link href={route("account.wishlist")}>
                                <i className="iconly-Heart icli"></i> WISHLIST
                            </Link>
                        </div>
                        <div className="col-6">
                            <button
                                className="theme-color"
                                onClick={handleAddToCart}
                            >
                                <i className="iconly-Buy icli"></i> ADD TO BAG
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <div className="modal fade" id="popupMessage" aria-hidden="true">
                <div
                    className="modal-dialog"
                    style={{
                        position: "fixed",
                        top: "20px",
                        left: "50%",
                        transform: "translateX(-50%)",
                        margin: 0,
                        pointerEvents: "none",
                    }}
                >
                    <div
                        className={`alert alert-${
                            message.type === "success" ? "success" : "danger"
                        } d-flex align-items-center justify-content-between`}
                        role="alert"
                        style={{
                            minWidth: "260px",
                            pointerEvents: "auto", // allow clicking inside
                            boxShadow: "0 4px 12px rgba(0,0,0,0.15)",
                        }}
                    >
                        <span>{message.text}</span>

                        {/* Close Button */}
                        <button
                            type="button"
                            className="btn-close ms-3"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            onClick={() => setMessage({ text: "", type: "" })}
                        ></button>
                    </div>
                </div>
            </div>
        </>
    );
};
export default ProductDetails;
