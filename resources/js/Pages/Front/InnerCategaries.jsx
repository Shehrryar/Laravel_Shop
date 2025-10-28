import React, { useEffect, useState } from 'react';
import Slider from "react-slick";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import { Link, usePage } from "@inertiajs/react";
const InnerCategoryPage = () => {
    const { category ,subcategories, brands} = usePage().props;
  return (
    <>
      {/* Header */}
      <header>
        <div className="back-links">
          <Link href={route('product.getCategories')}>
            <i className="iconly-Arrow-Left icli"></i>
            <div className="content">
              <h2>
                Categories{" "}
                <span>
                  <i className="iconly-Arrow-Right-2 icli"></i> {category.name}
                </span>
              </h2>
            </div>
          </Link>
        </div>
        <div className="header-option">
          <ul>
            <li>
                <Link href={route('account.wishlist')}><i className="iconly-Heart icli" /></Link>
            </li>
            <li>
                <Link href={route('front.cart')}><i className="iconly-Buy icli" /></Link>
            </li>
          </ul>
        </div>
      </header>
      {/* Category Title */}
      <section className="category-listing px-15 top-space pt-0 cate-padding">
        <Link href={route('front.shop', category.slug )} className="category-wrap">
          <div className="content-part">
            <h2>{category.name}</h2>
            <h4>t-shirts, tops, bottoms..</h4>
          </div>
          <div className="img-part">
            <img
              src="front-assets/images/category/women.png"
              className="img-fluid"
              alt=""
            />
          </div>
        </Link>
      </section>
      {/* Category Menu */}
      <section className="px-15 category-menu">
        <div className="accordion px-15">
          {subcategories.map((subcategory, index) => (
            <div className="accordion-item" key={subcategory.id || index}>
              <h2 className="accordion-header">
                <button
                  className="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target={`#collapse-${subcategory.id}`}
                >
                  {subcategory.name}
                </button>
              </h2>

              <div id={`collapse-${subcategory.id}`} className="accordion-collapse collapse">
                <div className="accordion-body">
                  <ul>
                    {subcategory.sub_sub_category.map((sub_sub_category, i) => (
                      <li key={sub_sub_category.id || i}>
                        <Link
                          href={route("front.shop", {
                            cat_slug: category.slug ,
                            subcat_slug: subcategory.slug,
                            subsubcat_slug: sub_sub_category.slug,
                          })}>
                          {sub_sub_category.name}
                        </Link>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* Inner Category */}
      {/* <section className="inner-category px-15">
        <div className="row gx-3">
          {[
            { img: "flowerprint.png", label: "Flowerprint" },
            { img: "denim.png", label: "Denim" },
            { img: "skirts.png", label: "Skirts" },
          ].map((item, index) => (
            <div className="col-4" key={index}>
              <a href="shop.html">
                <img
                  src={`front-assets/images/category/${item.img}`}
                  className="img-fluid"
                  alt={item.label}
                />
                <h4>{item.label}</h4>
              </a>
            </div>
          ))}
        </div>
      </section> */}
<section className="inner-category px-15">
  <div className="row gx-3">
    {subcategories?.map((subcategory, index) =>
      subcategory.sub_sub_category?.map((sub_sub_category, i) => (
        <div className="col-6 col-md-4 mb-3" key={sub_sub_category.id}>
          <a
            href="#"
            className="d-block text-center py-4 rounded-3 shadow-sm inner-cat-box"
            style={{
              background: "linear-gradient(135deg, #f9f9f9, #eef1f5)",
              border: "1px solid #ddd",
              color: "#333",
              textDecoration: "none",
              transition: "all 0.3s ease",
            }}
            onMouseEnter={(e) =>
              (e.currentTarget.style.background =
                "linear-gradient(135deg, #ff9a9e, #fad0c4)")
            }
            onMouseLeave={(e) =>
              (e.currentTarget.style.background =
                "linear-gradient(135deg, #f9f9f9, #eef1f5)")
            }
          >
            <h4
              className="fw-semibold"
              style={{
                fontSize: "1.1rem",
                textTransform: "capitalize",
                letterSpacing: "0.5px",
              }}
            >
              {sub_sub_category.name}
            </h4>
          </a>
        </div>
      ))
    )}
  </div>
</section>
      {/* Brand Section */}
      <section className="brand-section px-15">
        <h2 className="title">Biggest Deals on Top Brands</h2>
        <div className="row g-3">
          {brands.map((num) => (
            <div className="col-4" key={num.id}>
              <a className="brand-box" href="#">
              <h4
                className="brand-text text-center fw-semibold"
                style={{
                  background: "linear-gradient(90deg, #ff7e5f, #feb47b)",
                  WebkitBackgroundClip: "text",
                  WebkitTextFillColor: "transparent",
                  fontSize: "1.3rem",
                  letterSpacing: "1px",
                  textTransform: "uppercase",
                }}
              >
                {num.name}
              </h4>
              </a>
            </div>
          ))}
        </div>
      </section>
      {/* Panel Space */}
      <section className="panel-space"></section>
      {/* Bottom Panel */}
      <div className="bottom-panel">
        <ul>
          {[
            { to: route('front.home'), label: 'Home', icon: 'Home' },
            { to: route('product.getCategories'), label: 'Category', icon: 'Category' },
            { to: route('front.cart'), label: 'Cart', icon: 'Buy' },
            { to: route('account.wishlist'), label: 'Wishlist', icon: 'Heart' },
            { to: route('account.profile'), label: 'Profile', icon: 'Profile' }
              ].map((item, index) => (
            <li className={index === 0 ? 'active' : ''} key={item.label}>
              <Link href={item.to}>
                <div className="icon">
                  <i className={`iconly-${item.icon.toLowerCase()} icli`} />
                  <i className={`iconly-${item.icon.toLowerCase()} icbo`} />
                </div>
                <span>{item.label}</span>
              </Link>
            </li>
          ))}
        </ul>
      </div>
    </>
  );
};
export default InnerCategoryPage;