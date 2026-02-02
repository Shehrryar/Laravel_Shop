import React from "react";
import { Link, usePage, router } from "@inertiajs/react";

const OrderPlaced = () => {
    const { order, order_items, translations } = usePage().props;

    return (
        <>
            <header>
                <div className="back-links">
                    <Link href={route("front.shop")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>{translations["Order Placed"]}</h2>
                        </div>
                    </Link>
                </div>
            </header>

            <section className="order-success-section px-15 top-space">
                <div>
                    <div className="check-circle">
                        <img
                            src="/front-assets/images/check-circle.gif"
                            className="img-fluid"
                            alt="check-circle"
                        />
                    </div>
                    <h1>{translations["Order Successful!"]}</h1>
                    <h2>{translations["Your payment was processed and your order is on the way."]}</h2>
                </div>
            </section>

            <section className="px-15">
                <h2 className="page-title">{translations["Order Details"]}</h2>
                <div className="details">
                    <ul>
                        <li className="mb-3 d-block">
                            <h4 className="fw-bold mb-1">
                                {translations["Your order # is:"]} {order?.id}
                            </h4>
                            <h4 className="content-color">
                                {translations["A receipt has been sent to your email address."]}
                            </h4>
                        </li>
                        <li className="mb-3 d-block">
                            <h4 className="fw-bold mb-1">{translations["Shipping Address:"]}</h4>
                            <h4 className="content-color">{order?.translated_address}</h4>
                        </li>
                        <li className="d-block">
                            <h4 className="fw-bold mb-1">{translations["Payment Method"]}</h4>
                            <h4 className="content-color">{order?.payment_method}</h4>
                        </li>
                    </ul>
                </div>
            </section>

            <div className="divider"></div>

            <section className="px-15 pt-0">
                <h2 className="page-title">{translations["Order Summary"]}</h2>
                <div className="product-section">
                    <div className="row gy-3">
                        {order_items.map((item, index) => (
                            <div className="col-12" key={index}>
                                <div className="product-inline">
                                    <div className="product-inline-content">
                                        <div>
                                            <Link href={route("front.product", item.product?.slug)}>
                                                <h4>{item.product?.translated_title}</h4>
                                            </Link>
                                            <h5 className="content-color">
                                                {(() => {
                                                    let attrs = {};
                                                    try {
                                                        attrs = item.additional_attributes
                                                            ? JSON.parse(item.additional_attributes)
                                                            : {};
                                                    } catch (e) {
                                                        attrs = {};
                                                    }

                                                    return (
                                                        <>
                                                            {attrs.color && (
                                                                <span style={{ marginRight: "10px" }}>
                                                                    {translations["Color"]}: <strong>{attrs.color}</strong>
                                                                </span>
                                                            )}
                                                            {attrs.size && (
                                                                <span style={{ marginRight: "10px" }}>
                                                                    {translations["Size"]}: <strong>{attrs.size}</strong>
                                                                </span>
                                                            )}
                                                            <span>
                                                                {translations["Qty"]}: <strong>{item.quantity}</strong>
                                                            </span>
                                                        </>
                                                    );
                                                })()}
                                            </h5>

                                            <div className="price">
                                                {item?.discounted_value > 0 ? (
                                                    <h4>
                                                        ${item.discounted_price}
                                                        <del className="text-muted small ms-1">
                                                            ${item.price}
                                                        </del>
                                                        <span className="text-danger ms-1">
                                                            {item.discounted_value}%
                                                        </span>
                                                    </h4>
                                                ) : (
                                                    <h4>${item?.price}</h4>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section className="px-15">
                <div className="order-details">
                    <ul>
                        <li>
                            <h4>
                                {translations["Bag total"]} <span>${order?.subtotal}</span>
                            </h4>
                        </li>
                        <li>
                            <h4>
                                {translations["Bag saving"]} <span>-${order?.product_discount_amount}</span>
                            </h4>
                        </li>
                        <li>
                            <h4>
                                {translations["Delivery"]} <span>${order?.shipping}</span>
                            </h4>
                        </li>

                        {order?.coupon_discount_amount > 0 && (
                            <li>
                                <h4>
                                    {translations["Coupon Discount"]} <span>${order.coupon_discount_amount}</span>
                                </h4>
                            </li>
                        )}
                    </ul>
                    <div className="total-amount">
                        <h4>
                            {translations["Total Amount"]} <span>${order?.grandtotal}</span>
                        </h4>
                    </div>
                </div>
            </section>

            <section className="panel-space"></section>

            <div className="delivery-cart cart-bottom">
                <div>
                    <div className="left-content">
                        <Link className="title-color">{translations["Track Order"]}</Link>
                    </div>
                    <Link href={route("front.home")} className="btn btn-solid">
                        {translations["Continue shopping"]}
                    </Link>
                </div>
            </div>
        </>
    );
};

export default OrderPlaced;
