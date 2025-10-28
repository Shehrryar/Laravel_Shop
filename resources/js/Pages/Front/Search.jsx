import React, { useEffect, useState } from 'react';
import Slider from "react-slick";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import { Link, usePage } from "@inertiajs/react";
const Search = () => {
  return (
    <>


      {/* Search Panel */}
      <div className="search-panel w-back pt-3 px-15">
        <Link href={route('front.home')} className="back-btn">
          <i className="iconly-Arrow-Left icli"></i>
        </Link>
        <div className="search-bar">
          <input className="form-control form-theme" placeholder="Search" />
          <i className="iconly-Search icli search-icon"></i>
          <i className="iconly-Camera icli camera-icon"></i>
        </div>
      </div>

      {/* Recent Search */}
      <section className="px-15 recent-search-section">
        <h4 className="page-title">Recent Search</h4>
        <ul>
          {[
            "Party Wear Jumpshuit",
            "Pink Hoodie t-shirt full",
            "Blue Denim Jacket",
            "Men Blue Denim Jacket",
          ].map((item, index) => (
            <li key={index}>
              <a href="#">
                <i className="iconly-Time-Circle icli"></i> {item}
                <img
                  src="front-assets/svg/x.svg"
                  className="img-fluid delete-icon"
                  alt="Delete"
                />
              </a>
            </li>
          ))}
        </ul>
      </section>

      {/* Recommended Section */}
      <section className="px-15">
        <h4 className="page-title">Recommended for you</h4>
        <ul className="row filter-row g-3">
          {["Small", "Medium", "Large", "XL", "2XL"].map((size, index) => (
            <li className="col-4" key={index}>
              <div className="filter-col">{size}</div>
            </li>
          ))}
        </ul>
      </section>

      {/* Trending Categories */}
      <section className="px-15 inner-category">
        <h4 className="page-title">Trending Category</h4>
        <div className="row gx-3">
          {[
            { name: "Flowerprint", img: "front-assets/images/category/flowerprint.png" },
            { name: "Denim", img: "front-assets/images/category/denim.png" },
            { name: "Skirts", img: "front-assets/images/category/skirts.png" },
          ].map((cat, index) => (
            <div className="col-4" key={index}>
              <Link href="shop.html">
                <img src={cat.img} className="img-fluid" alt={cat.name} />
                <h4>{cat.name}</h4>
              </Link>
            </div>
          ))}
        </div>
      </section>

      {/* Brand Section */}
      <section className="brand-section px-15">
        <h4 className="page-title">Biggest Deals on Top Brands</h4>
        <div className="row g-3">
          {[1, 2, 3, 4, 5, 6].map((num) => (
            <div className="col-4" key={num}>
              <Link className="brand-box" href="shop.html">
                <img
                  src={`front-assets/images/brand-logos/${num}.png`}
                  className="img-fluid"
                  alt={`Brand ${num}`}
                />
              </Link>
            </div>
          ))}
        </div>
      </section>

      {/* Panel Space */}
      <section className="panel-space"></section>
    </>
  );
};

export default Search;