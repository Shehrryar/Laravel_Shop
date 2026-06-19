import React, { useState, useEffect, useRef } from "react";
import { Link, router } from "@inertiajs/react";
import { route } from "ziggy-js";
import BottomNav from "../Components/BottomNav";
import { UseCurrency } from "../Components/UseCurrency";
export default function OrderHistory({ orders }) {
    const { symbol, convertPrice } = UseCurrency();
    const [search, setSearch] = useState("");
    const toggleOrder = (id) => {
        router.visit(route("front.orderDetails", { orderId: id }));
    };

    function handleSearch(value) {
        setSearch(value);
        console.log(value);
        
    }
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("account.profile")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Order History</h2>
                        </div>
                    </Link>
                </div>
            </header>
            {/* Search */}
            <div className="search-panel top-space px-20">
                <div className="search-bar">
                    <input
                        className="form-control form-theme"
                        placeholder="Search orders..."
                        value={search}
                        onChange={(e) => handleSearch(e.target.value)}
                    />
                    <i className="iconly-Search icli search-icon"></i>
                </div>
            </div>
            {/* Orders */}
            <section className="px-15">
                <h2 className="page-title">Your Orders</h2>
                {orders.length === 0 ? (
                    <p className="content-color">No orders found.</p>
                ) : (
                    <ul className="order-listing">
                        {orders.map((order) => (
                            <li key={order.id}>
                                <div className="order-box">
                                    <div className="d-flex align-items-center">
                                        <div className="media-body">
                                            <h4>Order #{order.id}</h4>
                                            <h5 className="content-color my-1">
                                                Ordered:{" "}
                                                {new Date(
                                                    order.created_at,
                                                ).toLocaleDateString()}
                                            </h5>
                                            <h5 className="content-color my-1">
                                                Name: {order.firstname}
                                            </h5>
                                            <h6 className="content-color">
                                                Total: {symbol}
                                                {convertPrice(order.grandtotal)}
                                            </h6>
                                            <button
                                                onClick={() =>
                                                    toggleOrder(order.id)
                                                }
                                                className="theme-color"
                                                style={{
                                                    background: "none",
                                                    border: "none",
                                                    padding: 0,
                                                    fontSize: "16px",
                                                    cursor: "pointer",
                                                }}
                                            >
                                                View Details
                                            </button>
                                        </div>
                                        <span className="status-label">
                                            {order.status}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        ))}
                    </ul>
                )}
            </section>
            <section className="panel-space"></section>
            <BottomNav />
        </>
    );
}