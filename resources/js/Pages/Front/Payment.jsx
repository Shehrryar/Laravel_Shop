import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
import { loadStripe } from "@stripe/stripe-js";
const stripePromise = loadStripe("pk_test_123456789");
const PaymentDetails = () => {
    const {
        totalcartamount,
        bagsavingvalue,
        totalPayable,
        shippingAmount,
        couponApplied,
        couponcode,
        discount_coupon_amount,
        translations,
    } = usePage().props;
    // Fixed: Proper useState (no TS syntax)
    const [paymentMethod, setPaymentMethod] = useState("cod");
    const [loading, setLoading] = useState(false);
    const redirectToPrevious = (e) => {
        e.preventDefault();
        router.get(route("front.checkout"));
    };
    const goToCoupons = () => {
        router.visit(route("front.coupons"), {
            data: {
                totalcartamount: totalcartamount,
                // totalPayable: totalcartamount,
                shippingAmount: shippingAmount,
                couponApplied: couponApplied,
                couponcode: couponcode,
            },
        });
    };
    const handlePaymentNow = async (e) => {
        e.preventDefault();
        if (paymentMethod === "cod") {
            // COD flow
            try {
                const response = await axios.post(
                    route("front.processCheckout"),
                    {
                        totalcartamount,
                        paymentMethod,
                        totalPayable,
                        shippingAmount,
                        discount_coupon_amount,
                        bagsavingvalue,
                    },
                );
                if (response.data.status) {
                    router.visit(route("front.orderPlaced"));
                }
            } catch (error) {
                console.error("COD payment failed:", error);
            }
        } else if (paymentMethod === "card") {
            // Stripe flow
            setLoading(true);
            try {
                const stripe = await stripePromise;
                const response = await axios.post(
                    route("front.processCheckout"),
                    {
                        totalcartamount,
                        paymentMethod,
                        totalPayable,
                        shippingAmount,
                        bagsavingvalue,
                    },
                );
                if (response.data.url) {
                    window.location.href = response.data.url; // Redirect to Stripe Checkout
                } else {
                    console.error("No checkout URL returned from server");
                }
            } catch (error) {
                console.error("Stripe payment error:", error);
            } finally {
                setLoading(false);
            }
        } else if (paymentMethod === "Paypal") {
            // Stripe flow
            setLoading(true);
            try {
                const stripe = await stripePromise;
                const response = await axios.post(
                    route("front.processCheckout"),
                    {
                        totalcartamount,
                        paymentMethod,
                        totalPayable,
                        shippingAmount,
                    },
                );
                if (response.data.url) {
                    window.location.href = response.data.url; // Redirect to Stripe Checkout
                } else {
                    console.error("No checkout URL returned from server");
                }
            } catch (error) {
                console.error("Stripe payment error:", error);
            } finally {
                setLoading(false);
            }
        }
    };
    // Fixed: No TypeScript syntax
    const handleMethodChange = (method) => {
        setPaymentMethod(method);
    };
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link onClick={redirectToPrevious}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>{translations["Payment Details"]}</h2>
                            <h6>{translations["Step 3 of 3"]}</h6>
                        </div>
                    </Link>
                </div>
            </header>
            {/* Offer Section */}
            <section className="offer-section px-15 top-space">
                <h2 className="page-title">
                    {translations["Offers & promotions"]}
                </h2>
                <div className="offer-listing">
                    <ul className="listing">
                        <li>
                            {
                                translations[
                                    "Get upto 25% discount on Multikart Pay using ICICI"
                                ]
                            }
                            {translations["Bank Net banking or Cards"]}
                        </li>
                        <li>
                            {
                                translations[
                                    "Enjoy upto 50% off & free delivery on online orders!"
                                ]
                            }
                        </li>
                        <li>
                            {
                                translations[
                                    "Get upto 25% discount on Multikart Pay using ICICI"
                                ]
                            }
                            {translations["Bank Net banking or Cards"]}
                        </li>
                        <li>
                            {
                                translations[
                                    "Enjoy upto 50% off & free delivery on online orders!"
                                ]
                            }
                        </li>
                    </ul>
                    <div className="overlay-offer"></div>
                </div>
                <a href="#" className="show-more">
                    {translations["Show More (5 offers)"]}
                </a>
            </section>
            <div className="divider"></div>
            {/* Payment Method Section */}
            <section className="px-15 payment-method-section pt-0">
                <div className="accordion" id="accordionExample">
                    {/* Cash on Delivery */}
                    <div className="card">
                        <div className="card-header" id="h_one">
                            <div
                                className="btn btn-link"
                                data-bs-toggle="collapse"
                                data-bs-target="#one"
                            >
                                <label htmlFor="r_one">
                                    <img
                                        src="/assets/images/payment/1.png"
                                        className="img-fluid"
                                        alt=""
                                    />
                                    {translations["Cash On Delivery"]}
                                    <input
                                        type="radio"
                                        className="radio_animated"
                                        id="r_one"
                                        name="payment_method"
                                        checked={paymentMethod === "cod"}
                                        onChange={() =>
                                            handleMethodChange("cod")
                                        }
                                        required
                                    />
                                </label>
                            </div>
                        </div>
                        <div
                            id="one"
                            className="collapse show"
                            aria-labelledby="h_one"
                            data-bs-parent="#accordionExample"
                        >
                            <div className="card-body p-0"></div>
                        </div>
                    </div>
                    {/* Debit / Credit Card */}
                    <div className="card">
                        <div className="card-header" id="h_two">
                            <div
                                className="btn btn-link"
                                data-bs-toggle="collapse"
                                data-bs-target="#two"
                            >
                                <label htmlFor="r_two">
                                    <img
                                        src="/assets/images/payment/2.png"
                                        className="img-fluid"
                                        alt=""
                                    />
                                    {translations["Debit/Credit Card"]}
                                    <input
                                        type="radio"
                                        className="radio_animated"
                                        id="r_two"
                                        name="payment_method"
                                        checked={paymentMethod === "card"}
                                        onChange={() =>
                                            handleMethodChange("card")
                                        }
                                        required
                                    />
                                </label>
                            </div>
                        </div>
                    </div>
                    {/* Wallets */}
                    <div className="card">
                        <div className="card-header" id="h_three">
                            <div
                                className="btn btn-link"
                                data-bs-toggle="collapse"
                                data-bs-target="#three"
                            >
                                <label htmlFor="r_three">
                                    <img
                                        src="/assets/images/payment/3.png"
                                        className="img-fluid"
                                        alt=""
                                    />
                                    {translations["Paypal"]}
                                    <input
                                        type="radio"
                                        className="radio_animated"
                                        id="r_three"
                                        name="payment_method"
                                        checked={paymentMethod === "Paypal"}
                                        onChange={() =>
                                            handleMethodChange("Paypal")
                                        }
                                        required
                                    />
                                </label>
                            </div>
                        </div>
                    </div>
                    {/* Net Banking */}
                </div>
            </section>
            <div className="divider"></div>
            <section className="px-15 pt-0">
                <div
                    style={{
                        display: "flex",
                        justifyContent: "space-between",
                        alignItems: "center",
                    }}
                >
                    <h4>{translations["Coupon Discount"]}</h4>
                    <span
                        onClick={goToCoupons}
                        className="theme-color"
                        style={{ cursor: "pointer", fontWeight: "600" }}
                    >
                        {translations["Apply Coupon"]}
                    </span>
                </div>
            </section>
            <div className="divider"></div>
            {/* Order Details */}
            <section className="px-15 pt-0">
                <h2 className="title">{translations["Order Details"]}:</h2>
                <div className="order-details">
                    <ul>
                        <li>
                            <h4>
                                {translations["Bag total"]}{" "}
                                <span>${totalcartamount}</span>
                            </h4>
                        </li>
                        <li>
                            <h4>
                                {translations["Bag saving"]}{" "}
                                <span className="text-green">
                                    -${bagsavingvalue}
                                </span>
                            </h4>
                        </li>
                        {!!discount_coupon_amount && (
                            <li>
                                <h4>
                                    {translations["Coupon Discount"]}{" "}
                                    <span className="text-green">
                                        -${discount_coupon_amount}
                                    </span>
                                </h4>
                            </li>
                        )}
                        <li>
                            <h4>
                                {translations["Delivery"]}{" "}
                                <span>${shippingAmount}</span>
                            </h4>
                        </li>
                    </ul>
                    <div className="total-amount">
                        <h4>
                            {translations["Total Amount"]}{" "}
                            <span>${totalPayable}</span>
                        </h4>
                    </div>
                </div>
            </section>
            <section className="panel-space"></section>
            {/* Bottom Panel */}
            <div className="cart-bottom">
                <div>
                    <div className="left-content">
                        <h4>${totalPayable}</h4>
                        {/* <a href="#" className="theme-color">
                            View details
                        </a> */}
                    </div>
                    <Link onClick={handlePaymentNow} className="btn btn-solid">
                        {translations["Pay Now"]}
                    </Link>
                </div>
            </div>
        </>
    );
};
export default PaymentDetails;