import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import axios from "axios";
import { route } from "ziggy-js";

const OrderPlaced = () => {
  const { order, order_items } = usePage().props;

  return (
    <>
      <header>
        <div className="back-links">
          <Link href={route("front.home")}>
            <i className="iconly-Arrow-Left icli"></i>
            <div className="content">
              <h2>Order Placed</h2>
            </div>
          </Link>
        </div>
      </header>

      <section className="order-success-section px-15 top-space">
        <div>
          <div className="check-circle">
            <img src="/front-assets/images/check-circle.gif" className="img-fluid" alt="check-circle" />
          </div>
          <h1>Order Successful!</h1>
          <h2>Your payment was processed and your order is on the way.</h2>
        </div>
      </section>

      <section className="px-15">
        <h2 className="page-title">Order Details</h2>
        <div className="details">
          <ul>
            <li className="mb-3 d-block">
              <h4 className="fw-bold mb-1">Your order # is: {order?.id}</h4>
              <h4 className="content-color">
                A receipt has been sent to your email address.
              </h4>
            </li>
            <li className="mb-3 d-block">
              <h4 className="fw-bold mb-1">Shipping Address:</h4>
              <h4 className="content-color">{order?.address}</h4>
            </li>
            <li className="d-block">
              <h4 className="fw-bold mb-1">Payment Method</h4>
              <h4 className="content-color">{order?.payment_method}</h4>
            </li>
          </ul>
        </div>
      </section>

      <div className="divider"></div>

      <section className="px-15 pt-0">
        <h2 className="page-title">Order Summary</h2>
        <div className="product-section">
          <div className="row gy-3">
            {order_items.map((item, index) => (
              <div className="col-12" key={index}>
                <div className="product-inline">
                  <Link href={route("front.product", item.product?.slug)}>
                    <img
                      src={item.product?.image_url}
                      className="img-fluid"
                      alt={item.product?.title}
                    />
                  </Link>
                  <div className="product-inline-content">
                    <div>
                      <Link href={route("front.product", item.product?.slug)}>
                        <h4>{item.product?.title}</h4>
                      </Link>
                      <h5 className="content-color">
                        Size: {item.size}, Qty: {item.qty}
                      </h5>
                      <div className="price">
                        <h4>${item.price}</h4>
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
                Bag total <span>${order?.subtotal}</span>
              </h4>
            </li>
            <li>
              <h4>
                Delivery <span>${order?.shipping}</span>
              </h4>
            </li>
          </ul>
          <div className="total-amount">
            <h4>
              Total Amount <span>${order?.grandtotal}</span>
            </h4>
          </div>
        </div>
      </section>

      <section className="panel-space"></section>

      <div className="delivery-cart cart-bottom">
        <div>
          <div className="left-content">
            <Link 
            // href={route("front.order.tracking", order.id)} 
            className="title-color">
              Track Order
            </Link>
          </div>
          <Link href={route("front.home")} className="btn btn-solid">
            Continue shopping
          </Link>
        </div>
      </div>
    </>
  );
};

export default OrderPlaced;
