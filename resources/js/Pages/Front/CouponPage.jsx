import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
export default function CouponPage() {
    const { coupons, totalPayable } = usePage().props;

    const [originalTotalAmount] = useState(totalPayable); // keep original total fixed
    const [TotalAmount, setCartTotalAmount] = useState(totalPayable);
    const [successApplied, setSuccessApplied] = useState(false);
    const [appliedCoupon, setAppliedCoupon] = useState(null);

    const applyCoupon = async (couponCode, type, amount) => {
        try {
            const response = await axios.post(route("front.applycoupon"), {
                coupon_code: couponCode,
                cart_total: originalTotalAmount,
                type: type,
                ammount: amount,
            });
            // Update state with returned data
            setAppliedCoupon(response.data.couponApplied);
            setCartTotalAmount(response.data.cartTotalAmount);
            setSuccessApplied(response.data.successapplied);
        } catch (err) {
            // Handle errors
            console.error(err.response?.data || err);
        }
    };

    const handlePlaceOrder = (e) => {
        e.preventDefault();
        router.get(route("front.checkout"), {
            totalcartamount: TotalAmount,
        });
    };

    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href="/shop">
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Coupons</h2>
                        </div>
                    </Link>
                </div>
            </header>

            {/* Coupon List */}
            <section className="px-15 top-space pt-0">
                <div className="search-coupons">
                    <input
                        className="form-control form-theme"
                        placeholder="Search or Apply Coupons"
                    />
                    <i className="iconly-Discount icli"></i>
                </div>

                {coupons.length > 0 ? (
                    <ul className="coupon-listing">
                        {coupons.map((coupon) => (
                            <li key={coupon.id}>
                                <div className="coupon-box">
                                    <div className="top-bar">
                                        <h4>{coupon.code}</h4>
                                        <span>
                                            {coupon.type === "percent"
                                                ? `Save ${coupon.discont_amount}%`
                                                : `Save $${coupon.discont_amount}`}
                                        </span>

                                        <button
                                            className={`btn btn-sm ${
                                                appliedCoupon === coupon.code
                                                    ? "btn-success text-white"
                                                    : "btn-outline"
                                            }`}
                                            onClick={() =>
                                                applyCoupon(
                                                    coupon.code,
                                                    coupon.type,
                                                    coupon.discont_amount
                                                )
                                            }
                                            disabled={
                                                appliedCoupon === coupon.code
                                            } // disable if already applied
                                        >
                                            {appliedCoupon === coupon.code
                                                ? "APPLIED"
                                                : "APPLY"}
                                        </button>
                                    </div>

                                    {/* <p>
                                        {coupon.description
                                            ? coupon.description
                                            : `Minimum order: $${coupon.min_amount}`}
                                    </p> */}

                                    <div className="mt-2 text-muted text-sm">
                                        <p>
                                            <strong>Valid From:</strong>{" "}
                                            {new Date(
                                                coupon.start_at
                                            ).toLocaleDateString()}{" "}
                                            - <strong>Expires:</strong>{" "}
                                            {new Date(
                                                coupon.expires_at
                                            ).toLocaleDateString()}
                                        </p>
                                    </div>

                                    <Link
                                        href="/terms-condition"
                                        className="text-green d-block mt-1"
                                    >
                                        View T&amp;C
                                    </Link>
                                </div>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <p className="text-center mt-4">
                        No active coupons available.
                    </p>
                )}
            </section>

            {/* Panel Space */}
            <section className="panel-space"></section>

            {/* Bottom Panel */}
            <div className="cart-bottom">
                <div>
                    <div className="left-content">
                        <h4>${TotalAmount}</h4>
                        <a href="#order-details" className="theme-color">
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
        </>
    );
}
