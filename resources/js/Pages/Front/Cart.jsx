import React from "react";
import Slider from "react-slick";
import { Link, usePage } from "@inertiajs/react";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
export default function CartPage() {
    // small helper to toggle sidebar
    const settings = {
    slidesToShow: 5,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false,
    dots: false,
    responsive: [
      { breakpoint: 992, settings: { slidesToShow: 3 } },
      { breakpoint: 576, settings: { slidesToShow: 2 } },
    ],
  }
  return (
    <div>
      {/* Header Start */}
      <header>
        <div className="back-links">
          <Link to='/' href='/'>
            <i className="iconly-Arrow-Left icli"></i>
            <div className="content">
              <h2>Shopping Cart</h2>
              <h6>Step 1 of 3</h6>
            </div>
          </Link>
        </div>
        <div className="header-option">
          <ul>
            <li>
              <Link href={route('account.wishlist')}>

                
                <i className="iconly-Heart icli"></i>
              </Link>
            </li>
          </ul>
        </div>
      </header>
      {/* Header End */}
      {/* Cart Items Start */}
      <section className="cart-section pt-0 top-space">
        {[1, 2, 3].map((item) => (
          <div key={item}>
            <div className="cart-box px-15">
              <a href="product.html" className="cart-img">
                <img
                  src={`front-assets/images/products/${item}.jpg`}
                  className="img-fluid"
                  alt="Product"
                />
              </a>
              <div className="cart-content">
                <a href="product.html">
                  <h4>Pink Hoodie t-shirt full</h4>
                </a>
                <h5 className="content-color">by Mango</h5>
                <div className="price">
                  <h4>
                    $32.00 <del>$35.00</del>
                    <span>20%</span>
                  </h4>
                </div>
                <div className="select-size-sec">
                  <a
                    data-bs-toggle="offcanvas"
                    data-bs-target="#selectQty"
                    className="opion"
                  >
                    <h6>Qty: 1</h6>
                    <i className="iconly-Arrow-Down-2 icli"></i>
                  </a>
                  <a
                    data-bs-toggle="offcanvas"
                    data-bs-target="#selectSize"
                    className="opion"
                  >
                    <h6>Size: S</h6>
                    <i className="iconly-Arrow-Down-2 icli"></i>
                  </a>
                </div>
                <div className="cart-option">
                  <h5 data-bs-toggle="offcanvas" data-bs-target="#removecart">
                    <i className="iconly-Heart icli"></i> Move to wishlist
                  </h5>
                  <span className="divider-cls">|</span>
                  <h5 data-bs-toggle="offcanvas" data-bs-target="#removecart">
                    <i className="iconly-Delete icli"></i> Remove
                  </h5>
                </div>
              </div>
            </div>
            <div className="divider"></div>
          </div>
        ))}
      </section>
      {/* Cart Items End */}
      {/* You May Also Like Section */}
      <section className="pt-0 product-slider-section overflow-hidden">
        <div className="title-section px-15">
          <h2>You May also Like</h2>
        </div>
        <div className="product-slider slick-default pl-15">
      <Slider {...settings} className="product-slider slick-default pl-15">
          {[9, 10, 8, 2, 4].map((item) => (
            <div key={item}>
              <div className="product-box ratio_square">
                <div className="img-part">
                  <a href="product.html">
                    <img
                      src={`front-assets/images/products/${item}.jpg`}
                      alt="Product"
                      className="img-fluid bg-img"
                    />
                  </a>
                  <div className="wishlist-btn">
                    <i className="iconly-Heart icli"></i>
                    <i className="iconly-Heart icbo"></i>
                    <div className="effect-group">
                      {[...Array(5)].map((_, i) => (
                        <span key={i} className="effect"></span>
                      ))}
                    </div>
                  </div>
                </div>
                <div className="product-content">
                  <ul className="ratings">
                    {[1, 2, 3, 4].map((i) => (
                      <li key={i}>
                        <i className="iconly-Star icbo"></i>
                      </li>
                    ))}
                    <li>
                      <i className="iconly-Star icbo empty"></i>
                    </li>
                  </ul>
                  <a href="product.html">
                    <h4>Blue Denim Jacket</h4>
                  </a>
                  <div className="price">
                    <h4>
                      $32.00 <del>$35.00</del>
                      <span>20%</span>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          ))}
          </Slider>
        </div>
      </section>
      <div className="divider"></div>
      {/* Coupon Section */}
      <section className="px-15 pt-0">
        <h2 className="title">Coupons:</h2>
        <div className="coupon-section">
          <i className="iconly-Discount icli icon-discount"></i>
          <input
            className="form-control form-theme"
            placeholder="Apply Coupons"
          />
          <i className="iconly-Arrow-Right-2 icli icon-right"></i>
        </div>
      </section>
      <div className="divider"></div>
      {/* Order Details */}
      <section id="order-details" className="px-15 pt-0">
        <h2 className="title">Order Details:</h2>
        <div className="order-details">
          <ul>
            <li>
              <h4>
                Bag total <span>$220.00</span>
              </h4>
            </li>
            <li>
              <h4>
                Bag savings <span className="text-green">-$20.00</span>
              </h4>
            </li>
            <li>
              <h4>
                Coupon Discount{" "}
                <a href="coupons.html" className="theme-color">
                  Apply Coupon
                </a>
              </h4>
            </li>
            <li>
              <h4>
                Delivery <span>$50.00</span>
              </h4>
            </li>
          </ul>
          <div className="total-amount">
            <h4>
              Total Amount <span>$270.00</span>
            </h4>
          </div>
          <div className="delivery-info">
            <img src="front-assets/images/truck.gif" className="img-fluid" alt="" />
            <h4>No Delivery Charges applied on this order </h4>
          </div>
        </div>
      </section>
      <div className="divider"></div>
      {/* Service Section */}
      <section className="service-wrapper px-15 pt-0">
        <div className="row">
          {[
            { img: "returning.svg", text: "7 Day Return" },
            { img: "24-hours.svg", text: "24/7 Support" },
            { img: "wallet.svg", text: "Secure Payment" },
          ].map((service, i) => (
            <div key={i} className="col-4">
              <div className="service-wrap">
                <div className="icon-box">
                  <img
                    src={`front-assets/svg/${service.img}`}
                    className="img-fluid"
                    alt=""
                  />
                </div>
                <span>{service.text}</span>
              </div>
            </div>
          ))}
        </div>
      </section>
      <section className="panel-space"></section>
      {/* Bottom Panel */}
      <div className="cart-bottom">
        <div>
          <div className="left-content">
            <h4>$270.00</h4>
            <a href="#order-details" className="theme-color">
              View details
            </a>
          </div>
          <a href="delivery.html" className="btn btn-solid">
            Place Order
          </a>
        </div>
      </div>
      {/* Offcanvas Components */}
      {/* Quantity Offcanvas */}
      <div className="offcanvas offcanvas-bottom h-auto qty-canvas" id="selectQty">
        <div className="offcanvas-body small">
          <h4>Select Quantity:</h4>
          <div className="qty-counter">
            <div className="input-group">
              <button type="button" className="btn quantity-left-minus">
                <img src="front-assets/svg/minus-square.svg" className="img-fluid" alt="" />
              </button>
              <input
                type="text"
                name="quantity"
                className="form-control form-theme qty-input input-number"
                defaultValue="1"
              />
              <button type="button" className="btn quantity-right-plus">
                <img src="front-assets/svg/plus-square.svg" className="img-fluid" alt="" />
              </button>
            </div>
          </div>
          <a href="delivery.html" className="btn btn-solid w-100" data-bs-dismiss="offcanvas">
            Add to Bag
          </a>
        </div>
      </div>
      {/* Size Offcanvas */}
      <div className="offcanvas offcanvas-bottom h-auto qty-canvas" id="selectSize">
        <div className="offcanvas-body small">
          <h4>Select Size:</h4>
          <div className="size-detail mb-2 mt-2">
            <ul className="size-select">
              <li>S</li>
              <li>M</li>
              <li>L</li>
              <li className="disable">XL</li>
            </ul>
          </div>
          <div className="price mb-3">
            <h4>
              $32.00 <del>$35.00</del>
              <span>20%</span>
            </h4>
          </div>
          <a className="btn btn-solid w-100" data-bs-dismiss="offcanvas">
            DONE
          </a>
        </div>
      </div>
      {/* Remove Item Offcanvas */}
      <div className="offcanvas offcanvas-bottom h-auto removecart-canvas" id="removecart">
        <div className="offcanvas-body small">
          <div className="content">
            <h4>Remove Item:</h4>
            <p>Are you sure you want to remove or move this item from the cart?</p>
          </div>
          <div className="bottom-cart-panel">
            <div className="row">
              <div className="col-7">
                <a href="wishlist.html" className="title-color">
                  MOVE TO WISHLIST
                </a>
              </div>
              <div className="col-5">
                <a href="#" className="theme-color">
                  REMOVE
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}