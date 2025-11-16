import React, { useState } from "react";
import axios from "axios";
import { Link, usePage, router } from "@inertiajs/react";
import ProductSlider from "./Components/ProductSlider";
import EmptyCart from "./Components/EmptyCart";
import { route } from "ziggy-js";
export default function CartPage() {
    const {
        cartcontent,
        colors,
        sizes,
        carttotalamount,
        wishlist,
        wishlistitems,
        shippingAmount,
        totalPayable,
        bagsavingvalue,
    } = usePage().props;

    console.log(cartcontent);

    const [selecteditemId, setSelectedItemId] = useState(null);
    const [selectedItemToWishlist, setSelectedItemToWishlist] = useState(null);
    const [selectedItem, setSelectedItem] = useState(null);
    // New states for size/color selection and dynamic price
    const [quantity, setQuantity] = useState(1);
    const [availableSizes, setAvailableSizes] = useState([]);
    const [availableColors, setAvailableColors] = useState([]);
    const [selectedSize, setSelectedSize] = useState(null);
    const [selectedColor, setSelectedColor] = useState(null);
    const [priceSize, setSizePrice] = useState(null);
    const [priceColor, setColorPrice] = useState(null);
    const [message, setMessage] = useState({ text: "", type: "" });
    // const [updatedPrice, setUpdatedPrice] = useState(null);
    // State for variant price
    const [variantPrice, setVariantPrice] = useState({
        actual: 0,
        discounted: 0,
        discount_value: 0,
    });
    const updateVariantPrice = (sizeId, colorId, qty = quantity) => {
        if (!selectedItem) return;
        let basePrice = parseFloat(selectedItem.product.actual_price || 0);
        let baseDiscounted = parseFloat(
            selectedItem.product.discounted_price || basePrice
        );
        let discountValue = selectedItem.product.discount_value || 0;
        // Add size price
        if (sizeId) {
            const sizeObj = sizes.find(
                (s) => parseInt(s.id) === parseInt(sizeId)
            );
            if (sizeObj?.price) {
                basePrice += parseFloat(sizeObj.price);
                baseDiscounted += parseFloat(sizeObj.price);
            }
        }
        // Add color price
        if (colorId) {
            const colorObj = colors.find(
                (c) => parseInt(c.id) === parseInt(colorId)
            );
            if (colorObj?.price) {
                basePrice += parseFloat(colorObj.price);
                baseDiscounted += parseFloat(colorObj.price);
            }
        }
        // Apply discount
        if (discountValue > 0) {
            baseDiscounted = basePrice - (basePrice * discountValue) / 100;
        }
        // Multiply by quantity
        basePrice *= Number(qty);
        baseDiscounted *= Number(qty);
        //  Store as object (array-like structure)
        setVariantPrice({
            actual: basePrice.toFixed(2),
            discounted: baseDiscounted.toFixed(2),
            discount_value: discountValue,
        });
    };
    const handlesetQuantity = (q) => {
        const newQty = Number(q);
        if (!selectedItem) return;
        const selectedSizeObj = sizes.find(
            (s) => parseInt(s.id) === parseInt(selectedItem.size_id)
        );
        const selectedColorObj = colors.find(
            (c) => parseInt(c.id) === parseInt(selectedItem.color_id)
        );
        const sizePrice = selectedSizeObj ? Number(selectedSizeObj.price) : 0;
        const colorPrice = selectedColorObj
            ? Number(selectedColorObj.price)
            : 0;
        // Update states first
        setSizePrice(sizePrice);
        setColorPrice(colorPrice);
        setQuantity(newQty);
        // Update variant price using *new values directly*
        updateVariantPrice(selectedSize, selectedColor, newQty);
    };
    // size updation
    const handleSizeChange = (s) => {
        setSelectedSize(s.id);
        setSizePrice(s.price);
        // Recalculate price immediately
        updateVariantPrice(s.id, selectedColor, quantity);
    };
    // color updation
    const handleColorChange = (c) => {
        setSelectedColor(c.id);
        setColorPrice(c.price);
        // Recalculate price immediately
        updateVariantPrice(selectedSize, c.id, quantity);
    };
    const handleAddToCart = async () => {
        if (!selectedItem) return;
        try {
            const response = await axios.post(route("front.addToCart"), {
                product_id: selectedItem.product_id,
                size_id: selectedSize || 0,
                color_id: selectedColor || 0,
                quantity: quantity,
                price: variantPrice,
            });
            // Show success or error message
            setMessage({
                text: response.data.message || "Something went wrong!",
                type: response.data.status ? "success" : "error",
            });
            // Hide message after 5 seconds
            setTimeout(() => setMessage({ text: "", type: "" }), 5000);
            // Close offcanvas manually if open
            const offcanvasIds = ["selectQty", "selectSize", "selectColor"];
            offcanvasIds.forEach((id) => {
                const offcanvasEl = document.getElementById(id);
                if (offcanvasEl) {
                    const bsOffcanvas =
                        bootstrap.Offcanvas.getInstance(offcanvasEl);
                    if (bsOffcanvas) bsOffcanvas.hide();
                }
            });
            // Dynamically reload cart content without full page reload
            router.reload({ only: ["cartcontent"] });
        } catch (error) {
            console.error(error);
            setMessage({ text: "Something went wrong!", type: "error" });
            setTimeout(() => setMessage({ text: "", type: "" }), 5000);
        }
    };
    const handleremoveproduct = async () => {
        try {
            const response = await axios.post(route("front.deleteitem.cart"), {
                item_id: selecteditemId,
                action: "removefromcart",
            });
            if (response.data.status === true) {
                router.reload({ only: ["cartcontent"] });
            }
        } catch (error) {
            console.error("Error removing item:", error);
        }
    };
    const handlemoveproducttowishlist = async () => {
        try {
            const response = await axios.post(route("front.deleteitem.cart"), {
                item_id: selectedItemToWishlist[0],
                product_id: selectedItemToWishlist[1],
                user_id: selectedItemToWishlist[2],
                action: "AddtoWishlist",
            });
            if (response.data.status === true) {
                router.reload({ only: ["cartcontent"] });
            }
        } catch (error) {
            console.error("Error removing item:", error);
        }
    };

    const handlePlaceOrder = (e) => {
        e.preventDefault();
        router.get(route("front.checkout"), {
            totalcartamount: carttotalamount,
            cartcontent: cartcontent,
        });
    };

    const goToCoupons = () => {
        router.visit(route("front.coupons"), {
            data: {
                totalPayable: totalPayable, // pass the total amount including shipping
            },
        });
    };

    return (
        <>
            {cartcontent && cartcontent.length > 0 ? (
                <div>
                    {/* Header Start */}
                    <header>
                        <div className="back-links">
                            <Link to="/" href="/">
                                <i className="iconly-Arrow-Left icli"></i>
                                <div className="content">
                                    <h2>Shopping Cart</h2>
                                    <h6>Step 1 of 3</h6>
                                </div>
                            </Link>
                        </div>
                        <div className="header-option">
                            <ul>
                                <li>
                                    <Link href={route("account.wishlist")}>
                                        <i className="iconly-Heart icli"></i>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </header>
                    {/* Header End */}
                    {/* Cart Items */}
                    <section className="cart-section pt-0 top-space">
                        {message.text && (
                            <div
                                className={`alert alert-${
                                    message.type === "success"
                                        ? "success"
                                        : "danger"
                                } alert-dismissible fade show text-center mx-3 mt-3`}
                                role="alert"
                            >
                                {message.text}
                                <button
                                    type="button"
                                    className="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"
                                    onClick={() =>
                                        setMessage({ text: "", type: "" })
                                    }
                                ></button>
                            </div>
                        )}
                        {cartcontent.map((item) => (
                            <div key={item.id}>
                                <div className="cart-box px-15">
                                    <a href="#" className="cart-img">
                                        <img
                                            src={
                                                item.product_image
                                                    ? `/upload/products/${item.product_image}`
                                                    : "/admin-assets/img/default-150x150.png"
                                            }
                                            className="img-fluid"
                                            alt="Product"
                                        />
                                    </a>
                                    <div className="cart-content">
                                        <a href="#">
                                            <h4>{item.title}</h4>
                                        </a>
                                        <div className="price">
                                            {parseFloat(item.discounted_value) >
                                            0 ? (
                                                <h4>
                                                    ${item.discounted_price}{" "}
                                                    <del className="text-muted small ms-1">
                                                        ${item.price}
                                                    </del>{" "}
                                                    <span className="text-danger ms-1">
                                                        {item.discounted_value}%
                                                    </span>
                                                </h4>
                                            ) : (
                                                <h4>${item.price}</h4>
                                            )}
                                        </div>

                                        <div className="select-size-sec">
                                            {/* Quantity */}
                                            <Link
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#selectQty"
                                                className="option"
                                                onClick={() => {
                                                    setQuantity(item.quantity);
                                                    setSelectedItem(item);
                                                    setSelectedSize(
                                                        item.size_id
                                                    );
                                                    setSelectedColor(
                                                        item.color_id
                                                    );
                                                    updateVariantPrice(
                                                        item.size_id,
                                                        item.color_id,
                                                        item.quantity
                                                    );
                                                }}
                                            >
                                                <h6>Qty: {item.quantity}</h6>
                                                <i className="iconly-Arrow-Down-2 icli"></i>
                                            </Link>
                                            {/* Size */}
                                            {(item.size_id > 0 ||
                                                item.additional_attributes
                                                    ?.size) && (
                                                <Link
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#selectSize"
                                                    className="option"
                                                    onClick={() => {
                                                        setSelectedItem(item);
                                                        const filteredSizes =
                                                            sizes.filter(
                                                                (s) =>
                                                                    parseInt(
                                                                        s.product_id
                                                                    ) ===
                                                                    parseInt(
                                                                        item.product_id
                                                                    )
                                                            );
                                                        setAvailableSizes(
                                                            filteredSizes
                                                        );
                                                        setSelectedSize(
                                                            item.size_id
                                                        );
                                                        setSelectedColor(
                                                            item.color_id
                                                        );
                                                        const selectedSizeObj =
                                                            filteredSizes.find(
                                                                (s) =>
                                                                    parseInt(
                                                                        s.id
                                                                    ) ===
                                                                    parseInt(
                                                                        item.size_id
                                                                    )
                                                            );
                                                        setSizePrice(
                                                            selectedSizeObj.price
                                                        );
                                                        const selectedColorObj =
                                                            colors.find(
                                                                (c) =>
                                                                    parseInt(
                                                                        c.id
                                                                    ) ===
                                                                    parseInt(
                                                                        item.color_id
                                                                    )
                                                            );
                                                        setColorPrice(
                                                            selectedColorObj.price
                                                        );
                                                        setQuantity(
                                                            item.quantity
                                                        );
                                                        updateVariantPrice(
                                                            item.size_id,
                                                            item.color_id,
                                                            item.quantity
                                                        );
                                                    }}
                                                >
                                                    <h6>
                                                        Size:{" "}
                                                        {item.additional_attributes
                                                            ? JSON.parse(
                                                                  item.additional_attributes
                                                              ).size || "N/A"
                                                            : "N/A"}
                                                    </h6>

                                                    <i className="iconly-Arrow-Down-2 icli"></i>
                                                </Link>
                                            )}
                                            {/* Color */}
                                            {(item.color_id > 0 ||
                                                item.additional_attributes
                                                    ?.color) && (
                                                <Link
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#selectColor"
                                                    className="option"
                                                    onClick={() => {
                                                        setSelectedItem(item);
                                                        const filteredColors =
                                                            colors.filter(
                                                                (c) =>
                                                                    parseInt(
                                                                        c.product_id
                                                                    ) ===
                                                                    parseInt(
                                                                        item.product_id
                                                                    )
                                                            );
                                                        setAvailableColors(
                                                            filteredColors
                                                        );
                                                        setSelectedSize(
                                                            item.size_id
                                                        );
                                                        setSelectedColor(
                                                            item.color_id
                                                        );
                                                        const selectedColorObj =
                                                            filteredColors.find(
                                                                (c) =>
                                                                    parseInt(
                                                                        c.id
                                                                    ) ===
                                                                    parseInt(
                                                                        item.color_id
                                                                    )
                                                            );
                                                        setColorPrice(
                                                            selectedColorObj.price
                                                        );
                                                        const selectedSizeObj =
                                                            sizes.find(
                                                                (s) =>
                                                                    parseInt(
                                                                        s.id
                                                                    ) ===
                                                                    parseInt(
                                                                        item.size_id
                                                                    )
                                                            );
                                                        setSizePrice(
                                                            selectedSizeObj.price
                                                        );
                                                        setQuantity(
                                                            item.quantity
                                                        );
                                                        updateVariantPrice(
                                                            item.size_id,
                                                            item.color_id,
                                                            item.quantity
                                                        );
                                                    }}
                                                >
                                                    <h6>
                                                        Color:{" "}
                                                        {item.additional_attributes
                                                            ? JSON.parse(
                                                                  item.additional_attributes
                                                              ).color || "N/A"
                                                            : "N/A"}
                                                    </h6>

                                                    <i className="iconly-Arrow-Down-2 icli"></i>
                                                </Link>
                                            )}
                                        </div>
                                        <div className="cart-option">
                                            <h5
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#removecart"
                                                onClick={() =>
                                                    setSelectedItemToWishlist([
                                                        item.id,
                                                        item.product_id,
                                                        item.user_id,
                                                    ])
                                                }
                                            >
                                                <i className="iconly-Heart icli"></i>{" "}
                                                Move to wishlist
                                            </h5>
                                            <span className="divider-cls">
                                                |
                                            </span>
                                            <h5
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#removecart"
                                                onClick={() =>
                                                    setSelectedItemId(item.id)
                                                }
                                            >
                                                <i className="iconly-Delete icli"></i>{" "}
                                                Remove
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div className="divider"></div>
                            </div>
                        ))}
                    </section>
                    {/* Suggested Products */}
                    <ProductSlider
                        title="You May Like this"
                        products={wishlist}
                        wishlist={wishlistitems}
                    />
                    {/* Order Details */}
                    <div className="divider"></div>
                    {/* You may also like section end */}
                    {/* Coupon section */}
                    <section className="px-15 pt-0">
                        <h2 className="title">Coupons:</h2>
                        <div className="coupon-section">
                            <i className="iconly-Discount icli icon-discount"></i>
                            <input
                                className="form-control form-theme"
                                placeholder="Apply Coupons"
                            />
                            <i className="iconly-Arrow-Right-2 icli icon-right"></i>
                        </div>
                    </section>
                    <div className="divider"></div>
                    <section id="order-details" className="px-15 pt-0">
                        <h2 className="title">Order Details:</h2>
                        <div className="order-details">
                            <ul>
                                <li>
                                    <h4>
                                        Bag total{" "}
                                        <span>${carttotalamount}</span>
                                    </h4>
                                </li>
                                <li>
                                    <h4>
                                        Bag savings{" "}
                                        <span className="text-green">
                                            -${" "}
                                            {
                                                variantPrice.actual &&
                                                variantPrice.discounted
                                                    ? (
                                                          parseFloat(
                                                              variantPrice.actual
                                                          ) -
                                                          parseFloat(
                                                              variantPrice.discounted
                                                          )
                                                      ).toFixed(2)
                                                    : bagsavingvalue // fallback value from page load
                                            }
                                        </span>
                                    </h4>
                                </li>
                                <li>
                                    <h4>
                                        Coupon Discount{" "}
                                        <span
                                            onClick={goToCoupons}
                                            className="theme-color"
                                            style={{ cursor: "pointer" }}
                                        >
                                            Apply Coupon
                                        </span>
                                    </h4>
                                </li>
                                <li>
                                    <h4>
                                        Delivery <span>${shippingAmount}</span>
                                    </h4>
                                </li>
                            </ul>
                            <div className="total-amount">
                                <h4>
                                    Total Amount <span>${totalPayable}</span>
                                </h4>
                            </div>
                            <div className="delivery-info">
                                <img
                                    src="/front-assets/images/truck.gif"
                                    className="img-fluid"
                                    alt="Delivery Truck"
                                />
                                <h4>
                                    No Delivery Charges applied on this order
                                </h4>
                            </div>
                        </div>
                    </section>
                    <div className="divider"></div>
                    {/* order details end  */}
                    {/* Service Section Start */}
                    <section className="service-wrapper px-15 pt-0">
                        <div className="row">
                            <div className="col-4">
                                <div className="service-wrap">
                                    <div className="icon-box">
                                        <img
                                            src="/front-assets/svg/returning.svg"
                                            className="img-fluid"
                                            alt="7 Day Return"
                                        />
                                    </div>
                                    <span>7 Day Return</span>
                                </div>
                            </div>
                            <div className="col-4">
                                <div className="service-wrap">
                                    <div className="icon-box">
                                        <img
                                            src="/front-assets/svg/24-hours.svg"
                                            className="img-fluid"
                                            alt="24/7 Support"
                                        />
                                    </div>
                                    <span>24/7 Support</span>
                                </div>
                            </div>
                            <div className="col-4">
                                <div className="service-wrap">
                                    <div className="icon-box">
                                        <img
                                            src="/front-assets/svg/wallet.svg"
                                            className="img-fluid"
                                            alt="Secure Payment"
                                        />
                                    </div>
                                    <span>Secure Payment</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div className="divider"></div>
                    {/* Bottom Panel */}
                    <div className="cart-bottom">
                        <div>
                            <div className="left-content">
                                <h4>${totalPayable}</h4>
                                <a
                                    href="#order-details"
                                    className="theme-color"
                                >
                                    View details
                                </a>
                            </div>
                            <button
                                onClick={handlePlaceOrder}
                                className="btn btn-solid"
                            >
                                Place Order
                            </button>
                        </div>
                    </div>
                    {/* Offcanvas Components */}
                    {/* Quantity */}
                    <div
                        className="offcanvas offcanvas-bottom h-auto qty-canvas"
                        id="selectQty"
                    >
                        <div className="offcanvas-body small">
                            <h4>Select Quantity:</h4>
                            <input
                                type="number"
                                className="form-control form-theme qty-input input-number"
                                value={quantity}
                                onChange={(e) =>
                                    handlesetQuantity(e.target.value)
                                }
                            />
                            <button
                                className="btn btn-solid w-100 mt-3"
                                data-bs-dismiss="offcanvas"
                                onClick={handleAddToCart}
                            >
                                Add to Bag
                            </button>
                        </div>
                    </div>
                    {/* Size */}
                    <div
                        className="offcanvas offcanvas-bottom h-auto qty-canvas"
                        id="selectSize"
                    >
                        <div className="offcanvas-body small">
                            <h4>Select Size:</h4>
                            <div className="size-detail mb-2 mt-2">
                                <ul className="size-select">
                                    {availableSizes.length > 0 ? (
                                        availableSizes.map((s) => (
                                            <li
                                                key={s.id}
                                                className={
                                                    selectedSize === s.id
                                                        ? "active"
                                                        : ""
                                                }
                                                onClick={() => {
                                                    handleSizeChange(s);
                                                }}
                                            >
                                                {s.code}
                                            </li>
                                        ))
                                    ) : (
                                        <li className="disable">
                                            No sizes available
                                        </li>
                                    )}
                                </ul>
                            </div>
                            <div className="price mb-3">
                                <h4>${variantPrice.actual}</h4>
                            </div>
                            <button
                                className="btn btn-solid w-100"
                                data-bs-dismiss="offcanvas"
                                onClick={handleAddToCart}
                            >
                                DONE
                            </button>
                        </div>
                    </div>
                    {/* Color Selector Offcanvas */}
                    <div
                        className="offcanvas offcanvas-bottom h-auto qty-canvas"
                        id="selectColor"
                    >
                        <div className="offcanvas-body small p-3">
                            <h5 className="mb-3">Select Color:</h5>
                            <div className="d-flex flex-wrap gap-2 mb-3">
                                {availableColors.length > 0 ? (
                                    availableColors.map((c) => (
                                        <button
                                            key={c.id}
                                            type="button"
                                            className={`btn ${
                                                selectedColor === c.id
                                                    ? "btn-primary"
                                                    : "btn-outline-secondary"
                                            } btn-sm`}
                                            onClick={() => {
                                                handleColorChange(c);
                                            }}
                                        >
                                            {c.name}
                                        </button>
                                    ))
                                ) : (
                                    <span className="text-muted">
                                        No colors available
                                    </span>
                                )}
                            </div>
                            <div className="mb-3">
                                <h5 className="mb-0">
                                    Price: ${variantPrice.actual}
                                </h5>
                            </div>
                            <button
                                type="button"
                                className="btn btn-success w-100"
                                data-bs-dismiss="offcanvas"
                                onClick={handleAddToCart}
                            >
                                DONE
                            </button>
                        </div>
                    </div>
                    {/* Remove Item */}
                    <div
                        className="offcanvas offcanvas-bottom h-auto removecart-canvas"
                        id="removecart"
                    >
                        <div className="offcanvas-body small">
                            <div className="content">
                                <h4>Remove Item:</h4>
                                <p>
                                    Are you sure you want to remove or move this
                                    item from the cart?
                                </p>
                            </div>
                            <div className="bottom-cart-panel">
                                <div className="row">
                                    <div className="col-7">
                                        <button
                                            onClick={
                                                handlemoveproducttowishlist
                                            }
                                            className="title-color"
                                        >
                                            MOVE TO WISHLIST
                                        </button>
                                    </div>
                                    <div className="col-5">
                                        <button
                                            onClick={handleremoveproduct}
                                            className="theme-color"
                                        >
                                            REMOVE
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ) : (
                <EmptyCart />
            )}
        </>
    );
}
