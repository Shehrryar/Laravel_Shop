import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";
import BottomNav from "../Components/BottomNav";
import { UseCurrency } from "../Components/UseCurrency";
export default function OrderHistory({ orders }) {
    const [openOrder, setOpenOrder] = useState(null);
    const toggleOrder = (id) => {
        // setOpenOrder(openOrder === id ? null : id);
        router.visit(route("front.orderDetails", { orderId: id }));
    };

    const { symbol, convertPrice } = UseCurrency();


    return (
        <>
            {/* header start */}
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
            {/* header end */}
            {/* search panel start */}
            <div className="search-panel top-space px-20">
                <div className="search-bar">
                    <input
                        className="form-control form-theme"
                        placeholder="Search"
                    />
                    <i className="iconly-Search icli search-icon"></i>
                    <i className="iconly-Camera icli camera-icon"></i>
                </div>
                {/* <div
                    className="filter-btn"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasfilter"
                >
                    <i className="iconly-Filter icli"></i>
                </div> */}
            </div>
            {/* search panel end */}
            <section className="px-15">
                <h2 className="page-title">Open Orders</h2>
                <ul className="order-listing">
                    {orders.map((order) => (
                        <li key={order.id}>
                            <div className="order-box">
                                {/* ORDER SUMMARY */}
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
                                            {openOrder === order.id
                                                ? "Hide Details"
                                                : "View Details"}
                                        </button>
                                    </div>
                                    <span className="status-label">
                                        {order.status}
                                    </span>
                                </div>
                                {/* ORDER DETAILS (Collapsible) */}
                                {openOrder === order.id && (
                                    <div className="delivery-status mt-3">
                                        <h5 className="mb-2">Order Items:</h5>
                                        {order.orderitems?.map((item) => (
                                            <div
                                                key={item.id}
                                                className="d-flex align-items-center mb-3"
                                            >
                                                <img
                                                    src={
                                                        item.product
                                                            ?.product_images
                                                            ?.length > 0
                                                            ? `/upload/products/${item.product.product_images[0].image}`
                                                            : "/admin-assets/img/default-150x150.png"
                                                    }
                                                    className="img-fluid order-img"
                                                    alt={
                                                        item.product?.title ||
                                                        "Product"
                                                    }
                                                    style={{
                                                        width: 70,
                                                        height: 70,
                                                        borderRadius: 8,
                                                    }}
                                                />
                                                <div className="media-body ms-3">
                                                    <h5>
                                                        {item.product?.title}
                                                    </h5>
                                                    <h5 className="content-color">
                                                        {(() => {
                                                            let attrs = {};
                                                            try {
                                                                attrs =
                                                                    item.additional_attributes
                                                                        ? JSON.parse(
                                                                              item.additional_attributes,
                                                                          )
                                                                        : {};
                                                            } catch (e) {
                                                                attrs = {};
                                                            }
                                                            return (
                                                                <>
                                                                    {attrs.color && (
                                                                        <span
                                                                            style={{
                                                                                marginRight:
                                                                                    "10px",
                                                                            }}
                                                                        >
                                                                            Color:{" "}
                                                                            <strong>
                                                                                {
                                                                                    attrs.color
                                                                                }
                                                                            </strong>
                                                                        </span>
                                                                    )}
                                                                    {attrs.size && (
                                                                        <span
                                                                            style={{
                                                                                marginRight:
                                                                                    "10px",
                                                                            }}
                                                                        >
                                                                            Size:{" "}
                                                                            <strong>
                                                                                {
                                                                                    attrs.size
                                                                                }
                                                                            </strong>
                                                                        </span>
                                                                    )}
                                                                    <span>
                                                                        Qty:{" "}
                                                                        <strong>
                                                                            {
                                                                                item.quantity
                                                                            }
                                                                        </strong>
                                                                    </span>
                                                                </>
                                                            );
                                                        })()}
                                                    </h5>
                                                    <p className="content-color">
                                                        Qty: {item.quantity} |
                                                        Price: {symbol}
                                                        {convertPrice(
                                                            item.price,
                                                        )}
                                                    </p>
                                                </div>
                                            </div>
                                        ))}
                                        {/* Costs */}
                                        <div className="d-flex mt-3">
                                            <div className="me-3">
                                                <h6 className="content-color">
                                                    Subtotal:
                                                </h6>
                                                <h6>
                                                    {symbol}
                                                    {convertPrice(
                                                        order.subtotal,
                                                    )}
                                                </h6>
                                            </div>
                                            <div className="me-3">
                                                <h6 className="content-color">
                                                    Shipping:
                                                </h6>
                                                <h6>
                                                    {symbol}
                                                    {convertPrice(
                                                        order.shipping,
                                                    )}
                                                </h6>
                                            </div>
                                            <div>
                                                <h6 className="content-color">
                                                    Grand Total:
                                                </h6>
                                                <h6>
                                                    {symbol}
                                                    {convertPrice(
                                                        order.grandtotal,
                                                    )}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </li>
                    ))}
                </ul>
            </section>
            <section className="panel-space"></section>
            <BottomNav />
            {/* Review Offcanvas */}
            <div
                className="offcanvas offcanvas-bottom h-auto"
                tabIndex="-1"
                id="offcanvasreview"
            >
                <div className="offcanvas-body">
                    <h2 className="mb-2">Write Review</h2>
                    <div className="d-flex align-items-center">
                        <h4 className="content-color me-2">Your rating:</h4>
                        <ul className="ratings">
                            {[...Array(5)].map((_, i) => (
                                <li key={i}>
                                    <i
                                        className={`iconly-Star icbo${
                                            i === 4 ? " empty" : ""
                                        }`}
                                    ></i>
                                </li>
                            ))}
                        </ul>
                    </div>
                    <h4 className="content-color mt-2 mb-2">Review:</h4>
                    <form className="mb-4 section-b-space">
                        <textarea rows="4" className="form-control"></textarea>
                    </form>
                    <div className="cart-bottom row m-0">
                        <div>
                            <div className="left-content col-5">
                                <a href="#" className="title-color">
                                    BACK
                                </a>
                            </div>
                            <a
                                data-bs-dismiss="offcanvas"
                                className="btn btn-solid col-7 text-uppercase"
                            >
                                Submit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {/* Filter Offcanvas */}
            <div
                className="offcanvas offcanvas-bottom h-auto"
                tabIndex="-1"
                id="offcanvasfilter"
            >
                <div className="offcanvas-body">
                    <h2 className="mb-2 mt-cls">Filters</h2>
                    <form className="mb-2">
                        {["all", "open", "return", "cancelled"].map(
                            (filter) => (
                                <div
                                    className="me-3 d-flex align-items-center mb-2"
                                    key={filter}
                                >
                                    <input
                                        type="radio"
                                        name="filter"
                                        id={filter}
                                        value={filter}
                                        className="radio_animated"
                                        defaultChecked={filter === "all"}
                                    />
                                    <label
                                        htmlFor={filter}
                                        className="content-color"
                                    >
                                        {filter.charAt(0).toUpperCase() +
                                            filter.slice(1)}{" "}
                                        Orders
                                    </label>
                                </div>
                            ),
                        )}
                    </form>
                    <h2 className="mb-2">Time Filter</h2>
                    <form className="section-b-space mb-3">
                        {[
                            { id: "last30", label: "Last 30 Days" },
                            { id: "last6", label: "Last 6 Months" },
                            { id: "2021", label: "2021" },
                            { id: "2020", label: "2020" },
                        ].map((time) => (
                            <div
                                className="me-3 d-flex align-items-center mb-2"
                                key={time.id}
                            >
                                <input
                                    type="radio"
                                    name="time"
                                    id={time.id}
                                    value={time.id}
                                    className="radio_animated"
                                    defaultChecked={time.id === "last30"}
                                />
                                <label
                                    htmlFor={time.id}
                                    className="content-color"
                                >
                                    {time.label}
                                </label>
                            </div>
                        ))}
                    </form>
                    <div className="cart-bottom row m-0">
                        <div>
                            <div className="left-content col-5">
                                <a href="#" className="title-color">
                                    BACK
                                </a>
                            </div>
                            <a
                                data-bs-dismiss="offcanvas"
                                className="btn btn-solid col-7 text-uppercase"
                            >
                                Apply
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}