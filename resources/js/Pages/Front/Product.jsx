import React, { useState } from "react";
import axios from "axios";
import { Link, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";


const ProductDetails = () => {
  const sliderImages = [
    "assets/images/full-img/1.jpg",
    "assets/images/full-img/2.jpg",
  ];

  const sizes = ["S", "M", "L", "XL"];
  const colors = ["light-purple", "light-grey", "blue-purple", "light-orange"];

  const similarProducts = [
    "assets/images/products/9.jpg",
    "assets/images/products/10.jpg",
    "assets/images/products/8.jpg",
  ];

  const reviews = [
    {
      user: "Mark Jacob",
      date: "20 Aug, 2021",
      img: "assets/images/user/2.png",
      text: `It's a really cute skirt! I didn't expect to feel so good in a polyester material. 
             The print is slightly less bright than what is shown in the product description.`,
      likes: 20,
      dislikes: 2,
      size: "S",
    },
    {
      user: "Mark Jacob",
      date: "20 Aug, 2021",
      img: "assets/images/user/3.png",
      text: `It's a really cute skirt! I didn't expect to feel so good in a polyester material. 
             The print is slightly less bright than what is shown in the product description.`,
      likes: 20,
      dislikes: 2,
      size: "S",
    },
  ];

  return (
    <>
      {/* Header */}
      <header>
        <div className="back-links">
          <Link href={route("front.home")}>
            <i className="iconly-Arrow-Left icli"></i>
            <div className="content">
              <h2>Floral Skirts</h2>
            </div>
          </Link>
        </div>

        <div className="header-option">
          <ul>
            <li>
              <a href="#">
                <img src="assets/svg/share-2.svg" alt="Share" className="img-fluid" />
              </a>
            </li>
            <li>
              <Link href={route("account.wishlist")}>
                <i className="iconly-Heart icli"></i>
              </Link>
            </li>
            <li>
              <Link href="cart.html">
                <i className="iconly-Buy icli"></i>
              </Link>
            </li>
          </ul>
        </div>
      </header>

      {/* Product Section */}
      <section className="product-page-section top-space pt-0">
        <div className="home-slider slick-default theme-dots ratio_asos overflow-hidden">
          {sliderImages.map((src, i) => (
            <div key={i}>
              <div className="home-img">
                <img src={src} alt="" className="img-fluid bg-img" />
              </div>
            </div>
          ))}
        </div>

        <div className="product-detail-box px-15 pt-2">
          <div className="main-detail">
            <h2 className="text-capitalize">floral print skirt with white top</h2>
            <h6 className="content-color">
              Black, off-white and peach-coloured printed flared skirt, has zip closure,
              attached lining
            </h6>

            <div className="rating-section">
              <ul className="ratings">
                {[1, 2, 3, 4, 5].map((r, i) => (
                  <li key={i}>
                    <i className={`iconly-Star icbo ${i === 4 ? "empty" : ""}`}></i>
                  </li>
                ))}
              </ul>
              <h6 className="content-color">(20 ratings)</h6>
            </div>

            <div className="price">
              <h4>
                $32.00 <del>$35.00</del>
                <span>(20% off)</span>
              </h4>
            </div>

            <h6 className="text-green">inclusive of all taxes</h6>
          </div>
        </div>

        <div className="divider"></div>

        {/* Size & Color Selection */}
        <div className="product-detail-box px-15">
          <div className="size-detail">
            <h4 className="size-title">
              Select Size: <a href="#">Size Chart</a>
            </h4>
            <ul className="size-select">
              {sizes.map((s, i) => (
                <li key={i} className={s === "XL" ? "disable" : ""}>
                  {s === "XL" ? <del>{s}</del> : <a href="#">{s}</a>}
                </li>
              ))}
            </ul>
          </div>

          <div className="size-detail">
            <h4 className="size-title">Select Color:</h4>
            <ul className="filter-color">
              {colors.map((color, i) => (
                <li key={i} className={i === 1 ? "active" : ""}>
                  <a href="#">
                    <div className={`color-box ${color}`}></div>
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div className="size-detail">
            <h4 className="size-title">Quantity:</h4>
            <div className="qty-counter">
              <div className="input-group">
                <button type="button" className="btn quantity-left-minus">
                  <img src="assets/svg/minus-square.svg" alt="-" className="img-fluid" />
                </button>
                <input
                  type="text"
                  name="quantity"
                  className="form-control form-theme qty-input input-number"
                  defaultValue="1"
                />
                <button type="button" className="btn quantity-right-plus">
                  <img src="assets/svg/plus-square.svg" alt="+" className="img-fluid" />
                </button>
              </div>
            </div>
          </div>
        </div>

        <div className="divider"></div>

        {/* Offers */}
        <div className="product-detail-box px-15">
          <h4 className="page-title">Offers for You</h4>
          <h5>Use code MULTIKART10 to get flat 10%</h5>
          <h6 className="content-color">
            Use code MULTIKART10 to get flat 10% off on minimum order of $200.00. Offer valid
            for first time users only
          </h6>
          <div className="offer-code">
            <div className="code">
              <h6>MULTIKART10</h6>
              <img src="assets/svg/scissor.svg" alt="scissor" className="img-fluid" />
            </div>
            <h6 className="content-color">Tap to copy</h6>
          </div>
        </div>

        <div className="divider"></div>

        {/* Return Policy */}
        <div className="product-detail-box px-15">
          <h4 className="page-title">Return & Exchange Policy</h4>
          <h4 className="content-color">
            This product is eligible for returns and size replacements. Please initiate
            returns/replacements from the 'My Orders' section within 7 days of delivery.
          </h4>
        </div>

        <div className="divider"></div>

        {/* Product Details */}
        <div className="product-detail-box px-15">
          <h4 className="page-title mb-1">Product Details</h4>
          <h4 className="content-color mb-3">
            Black, off-white and peach-coloured printed flared skirt, has zip closure, attached
            lining
          </h4>
          <h4 className="page-title mb-1">Model Size & Fit</h4>
          <h4 className="content-color mb-3">The model (height 5'8") is wearing a size 28</h4>
          <h4 className="page-title mb-1">Material & Care</h4>
          <h4 className="content-color mb-3">100% polyester, Machine-wash</h4>
          <h4 className="page-title mb-1">Product Code</h4>
          <h4 className="content-color mb-minus-2">460356366_floral</h4>
        </div>

        <div className="divider"></div>

        {/* Reviews */}
        <div className="product-detail-box px-15">
          <h4 className="page-title">
            Customer Reviews (24) <a href="#">All Reviews</a>
          </h4>
          <div className="review-section">
            <ul>
              {reviews.map((r, i) => (
                <li key={i}>
                  <div className="media">
                    <img src={r.img} alt={r.user} className="img-fluid" />
                    <div className="media-body">
                      <h4>
                        {r.user} | {r.date}
                      </h4>
                      <ul className="ratings">
                        {[1, 2, 3, 4, 5].map((x, j) => (
                          <li key={j}>
                            <i className={`iconly-Star icbo ${j === 4 ? "empty" : ""}`}></i>
                          </li>
                        ))}
                      </ul>
                    </div>
                  </div>
                  <h4 className="content-color">{r.text}</h4>
                  <div className="review-bottom">
                    <h6>
                      Size bought: <span className="content-color">{r.size}</span>
                    </h6>
                    <div className="liking-sec">
                      <span className="content-color">
                        <img src="assets/svg/thumbs-up.svg" alt="like" className="img-fluid" />{" "}
                        {r.likes}
                      </span>
                      <span className="content-color">
                        <img src="assets/svg/thumbs-down.svg" alt="dislike" className="img-fluid" />{" "}
                        {r.dislikes}
                      </span>
                    </div>
                  </div>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="divider"></div>

        {/* Check Delivery */}
        <div className="check-delivery-section product-detail-box px-15">
          <div className="title-section">
            <h4>Check Delivery</h4>
            <h6 className="content-color">
              Enter Pincode to check delivery date / pickup option
            </h6>
          </div>
          <div className="pincode-form">
            <input className="form-control form-theme" placeholder="Pin code" />
            <a href="#">Check</a>
          </div>
          <div className="service-section">
            <ul>
              <li>
                <img src="assets/svg/delivery.svg" alt="delivery" className="img-fluid" /> Free
                Delivery on orders above $200.00
              </li>
              <li>
                <img src="assets/svg/payment.svg" alt="payment" className="img-fluid" /> Cash On
                Delivery Available
              </li>
              <li>
                <img src="assets/svg/refund.svg" alt="refund" className="img-fluid" /> Easy 21
                days returns and exchanges
              </li>
            </ul>
          </div>
        </div>
      </section>

      {/* Similar Products */}
      <section className="pt-0 product-slider-section overflow-hidden">
        <div className="title-section px-15">
          <h2>Similar Products</h2>
        </div>

        <div className="product-slider slick-default pl-15">
          {similarProducts.map((img, i) => (
            <div key={i}>
              <div className="product-box ratio_square">
                <div className="img-part">
                  <Link href="product.html">
                    <img src={img} alt="" className="img-fluid bg-img" />
                  </Link>
                  <div className="wishlist-btn">
                    <i className="iconly-Heart icli"></i>
                    <i className="iconly-Heart icbo"></i>
                    <div className="effect-group">
                      {[1, 2, 3, 4, 5].map((_, j) => (
                        <span className="effect" key={j}></span>
                      ))}
                    </div>
                  </div>
                </div>
                <div className="product-content">
                  <ul className="ratings">
                    {[1, 2, 3, 4, 5].map((x, j) => (
                      <li key={j}>
                        <i className={`iconly-Star icbo ${j === 4 ? "empty" : ""}`}></i>
                      </li>
                    ))}
                  </ul>
                  <Link href="product.html">
                    <h4>Blue Denim Jacket</h4>
                  </Link>
                  <div className="price">
                    <h4>
                      $32.00 <del>$35.00</del> <span>20%</span>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* Panel Space */}
      <section className="panel-space"></section>

      {/* Fixed Panel */}
      <div className="fixed-panel">
        <div className="row">
          <div className="col-6">
            <Link href={route("account.wishlist")}>
              <i className="iconly-Heart icli"></i> WISHLIST
            </Link>
          </div>
          <div className="col-6">
            <Link href="cart.html" className="theme-color">
              <i className="iconly-Buy icli"></i> ADD TO BAG
            </Link>
          </div>
        </div>
      </div>
    </>
  );
};

export default ProductDetails;
