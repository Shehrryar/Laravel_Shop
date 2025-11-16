import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
import { loadStripe } from "@stripe/stripe-js";

const stripePromise = loadStripe("pk_test_123456789");

const PaymentDetails = () => {
    const { totalcartamount, cartcontent } = usePage().props;
    // Fixed: Proper useState (no TS syntax)
    const [paymentMethod, setPaymentMethod] = useState("cod");
    const [loading, setLoading] = useState(false);
    const redirectToPrevious = (e) => {
        e.preventDefault();
        router.get(route("front.checkout"), {
            totalcartamount,
            cartcontent,
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
                        cartcontent,
                        paymentMethod,
                    }
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
                        cartcontent,
                        paymentMethod,
                    }
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
                            <h2>Payment Details</h2>
                            <h6>Step 3 of 3</h6>
                        </div>
                    </Link>
                </div>
            </header>
            {/* Offer Section */}
            <section className="offer-section px-15 top-space">
                <h2 className="page-title">Offers & promotions</h2>
                <div className="offer-listing">
                    <ul className="listing">
                        <li>
                            Get upto 25% discount on Multikart Pay using ICICI
                            Bank Net banking or Cards
                        </li>
                        <li>
                            Enjoy upto 50% off & free delivery on online orders!
                        </li>
                        <li>
                            Get upto 25% discount on Multikart Pay using ICICI
                            Bank Net banking or Cards
                        </li>
                        <li>
                            Enjoy upto 50% off & free delivery on online orders!
                        </li>
                    </ul>
                    <div className="overlay-offer"></div>
                </div>
                <a href="#" className="show-more">
                    Show More (5 offers)
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
                                    Cash On Delivery
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
                                    Debit/Credit Card
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
                        <div
                            id="two"
                            className="collapse"
                            aria-labelledby="h_two"
                            data-bs-parent="#accordionExample"
                        >
                            {/* <div className="card-body">
                                <form
                                    className="pt-2"
                                    onSubmit={(e) => {
                                        e.preventDefault();
                                        handlePaymentNow(e);
                                    }}
                                >
                                    <div className="form-floating mb-4">
                                        <label htmlFor="c-name">
                                            name on card
                                        </label>
                                        <input
                                            type="text"
                                            className="form-control"
                                            id="c-name"
                                            placeholder="name on card"
                                        />
                                    </div>
                                    <div className="form-floating mb-4">
                                        <label htmlFor="c1name">
                                            card number
                                        </label>
                                        <input
                                            type="text"
                                            className="form-control"
                                            id="c1name"
                                            placeholder="card number"
                                        />
                                    </div>
                                    <div className="row">
                                        <div className="form-floating mb-4 col-8">
                                            <label htmlFor="cname">
                                                expiration date
                                            </label>
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="cname"
                                                placeholder="MM/YY"
                                            />
                                        </div>
                                        <div className="form-floating mb-4 col-4">
                                            <label htmlFor="c2name">CVV</label>
                                            <input
                                                type="number"
                                                className="form-control"
                                                id="c2name"
                                                placeholder="CVV"
                                            />
                                        </div>
                                    </div>
                                    <div className="payment-btn">
                                        <button
                                            type="submit"
                                            className="btn btn-solid color1"
                                        >
                                            make payment
                                        </button>
                                    </div>
                                </form>
                            </div> */}
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
                                    Wallets
                                    <input
                                        type="radio"
                                        className="radio_animated"
                                        id="r_three"
                                        name="payment_method"
                                        checked={paymentMethod === "wallet"}
                                        onChange={() =>
                                            handleMethodChange("wallet")
                                        }
                                        required
                                    />
                                </label>
                            </div>
                        </div>
                        <div
                            id="three"
                            className="collapse"
                            aria-labelledby="h_three"
                            data-bs-parent="#accordionExample"
                        >
                            <div className="card-body">
                                <form
                                    className="wallet-section"
                                    onSubmit={(e) => {
                                        e.preventDefault();
                                        handlePaymentNow(e);
                                    }}
                                >
                                    <h4 className="page-title">
                                        Select Popular Banks
                                    </h4>
                                    <div>
                                        {[
                                            "Industrial & Commercial Bank",
                                            "Construction Bank Corp.",
                                            "Agricultural Bank",
                                            "HSBC Holdings",
                                            "Bank of America",
                                            "JPMorgan Chase & Co.",
                                        ].map((bank, index) => (
                                            <div
                                                className="form-check ps-0 mb-1"
                                                key={index}
                                            >
                                                <input
                                                    className="radio_animated"
                                                    type="radio"
                                                    name="exampleRadios1"
                                                    id={`Radios${index}`}
                                                    defaultChecked={index === 0}
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor={`Radios${index}`}
                                                >
                                                    {bank}
                                                </label>
                                            </div>
                                        ))}
                                    </div>
                                    <div className="form-floating mt-3">
                                        <select
                                            className="form-select"
                                            id="floatingSelect"
                                            defaultValue="1"
                                        >
                                            <option disabled value="1">
                                                Choose Bank...
                                            </option>
                                            <option value="2">ICICI</option>
                                            <option value="3">BOB</option>
                                        </select>
                                        <label htmlFor="floatingSelect">
                                            Choose Bank
                                        </label>
                                    </div>
                                    <div className="payment-btn">
                                        <button
                                            type="submit"
                                            className="btn btn-solid mt-4"
                                        >
                                            make payment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {/* Net Banking */}
                    <div className="card">
                        <div className="card-header" id="h_four">
                            <div
                                className="btn btn-link"
                                data-bs-toggle="collapse"
                                data-bs-target="#four"
                            >
                                <label htmlFor="r_four">
                                    <img
                                        src="/assets/images/payment/4.png"
                                        className="img-fluid"
                                        alt=""
                                    />
                                    Net Banking
                                    <input
                                        type="radio"
                                        className="radio_animated"
                                        id="r_four"
                                        name="payment_method"
                                        checked={paymentMethod === "netbanking"}
                                        onChange={() =>
                                            handleMethodChange("netbanking")
                                        }
                                        required
                                    />
                                </label>
                            </div>
                        </div>
                        <div
                            id="four"
                            className="collapse"
                            aria-labelledby="h_four"
                            data-bs-parent="#accordionExample"
                        >
                            <div className="card-body">
                                <form
                                    className="wallet-section"
                                    onSubmit={(e) => {
                                        e.preventDefault();
                                        handlePaymentNow(e);
                                    }}
                                >
                                    <h4 className="page-title">
                                        Select Your Wallet
                                    </h4>
                                    <div>
                                        {[
                                            "Adyen",
                                            "Airtel Money",
                                            "AlliedWallet",
                                            "Apple Pay",
                                            "Brinks",
                                            "CardFree",
                                        ].map((wallet, index) => (
                                            <div
                                                className="form-check ps-0 mb-1"
                                                key={index}
                                            >
                                                <input
                                                    className="radio_animated"
                                                    type="radio"
                                                    name="exampleRadios2"
                                                    id={`exampleRadios${index}`}
                                                    defaultChecked={index === 0}
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor={`exampleRadios${index}`}
                                                >
                                                    {wallet}
                                                </label>
                                            </div>
                                        ))}
                                    </div>
                                    <div className="payment-btn mt-4">
                                        <button
                                            type="submit"
                                            className="btn btn-solid"
                                        >
                                            make payment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div className="divider"></div>
            {/* Order Details */}
            <section className="px-15 pt-0">
                <h2 className="title">Order Details:</h2>
                <div className="order-details">
                    <ul>
                        <li>
                            <h4>
                                Bag total <span>${totalcartamount}</span>
                            </h4>
                        </li>
                        <li>
                            <h4>
                                Bag savings{" "}
                                <span className="text-green">-$20.00</span>
                            </h4>
                        </li>
                        {/* <li>
                            <h4>
                                Coupon Discount{" "}
                                <Link className="theme-color">
                                    Apply Coupon
                                </Link>
                            </h4>
                        </li> */}
                        <li>
                            <h4>
                                Delivery <span>$50.00</span>
                            </h4>
                        </li>
                    </ul>
                    <div className="total-amount">
                        <h4>
                            Total Amount <span>${totalcartamount}</span>
                        </h4>
                    </div>
                </div>
            </section>
            <section className="panel-space"></section>
            {/* Bottom Panel */}
            <div className="cart-bottom">
                <div>
                    <div className="left-content">
                        <h4>${totalcartamount}</h4>
                        <a href="#" className="theme-color">
                            View details
                        </a>
                    </div>
                    <Link onClick={handlePaymentNow} className="btn btn-solid">
                        Pay Now
                    </Link>
                </div>
            </div>
        </>
    );
};
export default PaymentDetails;
