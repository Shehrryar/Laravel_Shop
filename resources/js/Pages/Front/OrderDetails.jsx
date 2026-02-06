import React from "react";
import { Link, usePage } from "@inertiajs/react";
import { UseCurrency } from "./Components/UseCurrency";
import { route } from "ziggy-js";
const OrderDetails = () => {
    const { order } = usePage().props;
    const { symbol, convertPrice } = UseCurrency();
    if (!order) return <p>No order found.</p>;
    const orderItems = order.order_items || [];
    const shipping = order;
    const steps = [
        {
            key: "ordered",
            title: "Ordered",
            sub: new Date(order.created_at).toLocaleDateString(),
        },
        {
            key: "ready_to_ship",
            title: "Ready To Ship",
            sub: order.created_at || "",
        },
        {
            key: "in_transit",
            title: "In Transit",
            sub: order.created_at || "",
        },
        {
            key: "out_for_delivery",
            title: "Out For Delivery",
            sub: "expected delivery on monday",
        },
    ];

    // Determine the index of the current step
    const statusIndex = steps.findIndex((step) => step.key === order.status);

    const downloadInvoice = async () => {
        try {
            const response = await fetch(`/order/invoice-html/${order.id}`, {
                headers: { Accept: "application/json" },
            });

            const data = await response.json();

            const htmlContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Invoice #${data.id}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 30px;
                    color: #000;
                }
                h2, h4 {
                    margin-bottom: 10px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 15px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background: #f5f5f5;
                }
                .total {
                    margin-top: 20px;
                    font-size: 18px;
                    font-weight: bold;
                }
                @media print {
                    body {
                        margin: 0;
                    }
                }
            </style>
        </head>
        <body>
            <h2>Invoice #${data.id}</h2>
            <p>Date: ${new Date(data.created_at).toLocaleDateString()}</p>

            <h4>Customer Information</h4>
            <p>
                ${data.firstname} ${data.lastname}<br/>
                ${data.address}, ${data.city}, ${data.state} ${data.zip}
            </p>

            <h4>Order Items</h4>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.order_items
                        .map(
                            (item) => `
                        <tr>
                            <td>${item.product?.title || item.name}</td>
                            <td>${item.quantity}</td>
                            <td>${symbol}${convertPrice(item.price)}</td>
                            <td>${symbol}${convertPrice(item.total)}</td>
                        </tr>
                    `,
                        )
                        .join("")}
                </tbody>
            </table>

            <p class="total">Shipping Total: ${symbol}${convertPrice(data.shipping)}</p>c
            <p class="total">Grand Total: ${symbol}${convertPrice(data.grandtotal)}</p>

            <p>Payment Method: ${data.payment_method}</p>
            <p>Payment Status: ${data.payment_status}</p>
        </body>
        </html>
        `;

            const invoiceWindow = window.open("", "_blank");
            invoiceWindow.document.open();
            invoiceWindow.document.write(htmlContent);
            invoiceWindow.document.close();

            // Give browser time to render before print
            invoiceWindow.onload = () => {
                invoiceWindow.print();
            };
        } catch (error) {
            console.error("Failed to download invoice", error);
        }
    };

    return (
        <>
            {/* Header */}
            <header className="bg-transparent">
                <div className="back-links">
                    <Link href={route("account.orders")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Order Details</h2>
                        </div>
                    </Link>
                </div>
            </header>
            {/* Product Details */}
            <div className="map-product-section px-15">
                {orderItems.map((item, index) => (
                    <div key={index} className="product-inline">
                        <Link href={`/product/${item.product_id}`}>
                            <img
                                src={
                                    item.product?.product_images?.length > 0
                                        ? `/upload/products/${item.product.product_images[0].image}`
                                        : "/admin-assets/img/default-150x150.png"
                                }
                                className="img-fluid"
                                alt={item.product?.title || item.name}
                            />
                        </Link>
                        <div className="product-inline-content">
                            <div>
                                <Link href={`/product/${item.product_id}`}>
                                    <h4>{item.product?.title || item.name}</h4>
                                </Link>
                                <h5 className="content-color">
                                    Size:{" "}
                                    {JSON.parse(item.additional_attributes)
                                        ?.size || "-"},
                                    Color:{" "}
                                    {JSON.parse(item.additional_attributes)
                                        ?.color || "-"}
                                    , Qty: {item.quantity}
                                </h5>
                                <div className="price">
                                    <h4>
                                        {symbol}
                                        {convertPrice(item.total)}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
            <div className="order-track px-15">
                {steps.map((step, index) => (
                    <div
                        key={step.key}
                        className={`order-track-step ${index <= statusIndex ? "in-process" : ""}`}
                    >
                        <div className="order-track-status">
                            <span className="order-track-status-dot">
                                <img
                                    src="front-assets/svg/check.svg"
                                    className="img-fluid"
                                    alt=""
                                />
                            </span>
                            <span className="order-track-status-line"></span>
                        </div>
                        <div className="order-track-text">
                            <p className="order-track-text-stat">
                                {step.title}
                            </p>
                            <span className="order-track-text-sub">
                                {step.sub}
                            </span>
                        </div>
                    </div>
                ))}
            </div>
            <div className="rate-section px-15">
                <ul>
                    <li>
                        <i className="iconly-Star icli"></i> Rate & Review
                        Product
                    </li>
                    <li>
                        <i className="iconly-Star icli"></i> Need Help?
                    </li>
                </ul>
            </div>
            {/* Shipping Details */}
            <div className="divider"></div>
            <div className="px-15">
                <h6 className="tracking-title content-color">
                    Shipping Details
                </h6>
                <h4 className="fw-bold mb-1">
                    {shipping.translated_firstname || shipping.firstname}{" "}
                    {shipping.translated_lastname || shipping.lastname}
                </h4>
                <h4 className="content-color">
                    {shipping.translated_address || shipping.address},{" "}
                    {shipping.apartment || ""}
                </h4>
                <h4 className="content-color">
                    {shipping.translated_city || shipping.city},{" "}
                    {shipping.translated_state || shipping.state} {shipping.zip}
                </h4>
                <h4 className="fw-bold mt-1 mb-minus-4">
                    Phone No: {shipping.phone || "N/A"}
                </h4>
            </div>
            {/* Price Details */}
            <div className="divider"></div>
            <div className="px-15 section-b-space">
                <h6 className="tracking-title content-color">Price Details</h6>
                <div className="order-details">
                    <ul>
                        <li>
                            <h4>
                                Bag total{" "}
                                <span>
                                    {symbol}
                                    {convertPrice(order.subtotal)}
                                </span>
                            </h4>
                        </li>
                        <li>
                            <h4>
                                Discount{" "}
                                <span className="text-green">
                                    -{symbol}
                                    {convertPrice(order.discount)}
                                </span>
                            </h4>
                        </li>
                        {order.coupon_discount_amount && (
                            <li>
                                <h4>
                                    Coupon Discount{" "}
                                    <span>
                                        {symbol}
                                        {convertPrice(
                                            order.coupon_discount_amount,
                                        )}
                                    </span>
                                </h4>
                            </li>
                        )}
                        <li>
                            <h4>
                                Delivery{" "}
                                <span>
                                    {symbol}
                                    {convertPrice(order.shipping)}
                                </span>
                            </h4>
                        </li>
                    </ul>
                    <div className="total-amount">
                        <h4>
                            Total Amount{" "}
                            <span>
                                {symbol}
                                {convertPrice(order.grandtotal)}
                            </span>
                        </h4>
                    </div>
                    <div className="mt-2">
                        <p>Payment Method: {order.payment_method}</p>
                        <p>Payment Status: {order.payment_status}</p>
                    </div>
                    <button
                        onClick={downloadInvoice}
                        className="btn btn-outline content-color w-100 mt-4"
                    >
                        Download Invoice
                    </button>
                </div>
            </div>
        </>
    );
};
export default OrderDetails;
