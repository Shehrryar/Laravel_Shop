import React from "react";
import { route } from "ziggy-js";
import { Link, usePage } from "@inertiajs/react";

const CategoryPage = () => {
  const { categories } = usePage().props;
  return (
    <>
      {/* Header */}
      <header>
        <div className="back-links">
          <Link href={route('front.home')}>
            <i className="iconly-Arrow-Left icli"></i>
            <div className="content">
              <h2>Categories</h2>
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
      {/* Category Section */}
      <section className="category-listing px-15 top-space pt-0">



        {/* Show categories dynamically */}
        {categories && categories.length > 0 ? (
          categories.map((category) => (
            <Link
              key={category.id}
              href={route("product.getInnerCategory", { categoryid: category.id })}
              className="category-wrap"
            >
              <div className="content-part">
                <h2>{category.name}</h2>
                <h4>{category.description || "Explore products"}</h4>
              </div>
              <div className="img-part">
                <img
                  src={
                    category.image
                      ? `/upload/category/${category.image}` // if you store images in public/storage
                      : "front-assets/images/category/default.png" // fallback
                  }
                  className="img-fluid"
                  alt={category.name}
                />
              </div>
            </Link>
          ))
        ) : (
          <p className="text-center py-3">No categories available.</p>
        )}




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
export default CategoryPage;