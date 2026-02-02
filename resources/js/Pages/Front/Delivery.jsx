import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
import CustomerAddresses from "./Components/CustomerAddresses";
const DeliveryDetails = () => {
    const {
        customerAddresses,
        totalcartamount,
        bagsavingvalue,
        shippingAmount,
        totalPayable,
        translations,
    } = usePage().props;
    const [message, setMessage] = useState({ text: "", type: "" });
    const handleProceedToPayment = async (e) => {
        e.preventDefault();
        // Redirect after success
        router.visit(route("front.payment"));
    };
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.cart")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>{translations["Delivery Details"]}</h2>
                            <h6>{translations["Step 2 of 3"]}</h6>
                        </div>
                    </Link>
                </div>
                <div className="header-option">
                    <ul>
                        <li>
                            <Link>
                                <i className="iconly-Heart icli"></i>
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>
            {/* Delivery option section */}
            <CustomerAddresses customerAddresses={customerAddresses} />
            <div className="divider"></div>
            {/* Expected delivery section */}
            <section className="px-15 pt-0">
                <h2 className="page-title">{translations["Expected Delivery"]}</h2>
                <div className="product-section">
                    <div className="row gy-3">
                        <div className="col-12">
                            <div className="product-inline">
                                <Link>
                                    <img
                                        src="/front-assets/images/products/2.jpg"
                                        className="img-fluid"
                                        alt="Men Blue Denim Jacket"
                                    />
                                </Link>
                                <div className="product-inline-content">
                                    <div>
                                        <Link>
                                            <h4 className="content-color">
                                                Men Blue Denim Jacket
                                            </h4>
                                        </Link>
                                        <div className="price">
                                            <h4>
                                                Delivery by{" "}
                                                <span>25th July</span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {/* Panel space */}
            <section className="panel-space"></section>
            {/* Bottom panel */}
            <div className="delivery-cart cart-bottom">
                <div>
                    <div className="left-content">
                        <h4>${totalPayable}</h4>
                        <a
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasdetails"
                            className="theme-color"
                        >
                            {translations["View details"]}
                        </a>
                    </div>
                    <Link
                        onClick={handleProceedToPayment}
                        className="btn btn-solid"
                    >
                        {translations["Proceed to Payment"]}
                    </Link>
                </div>
            </div>
            {/* Order details offcanvas */}
            <div
                className="offcanvas offcanvas-bottom h-auto"
                tabIndex="-1"
                id="offcanvasdetails"
            >
                <div className="offcanvas-body">
                    <div className="order-details">
                        <ul>
                            <li>
                                <h4>
                                    {translations["Bag total"]} <span>${totalcartamount}</span>
                                </h4>
                            </li>
                            <li>
                                <h4>
                                    {translations["Bag savings"]}{" "}
                                    <span className="text-green">
                                        -${bagsavingvalue}
                                    </span>
                                </h4>
                            </li>
                            <li>
                                <h4>
                                    {translations["Delivery"]} <span>${shippingAmount}</span>
                                </h4>
                            </li>
                        </ul>
                        <div className="total-amount">
                            <h4>
                                {translations["Total Amount"]} <span>${totalPayable}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};
export default DeliveryDetails;