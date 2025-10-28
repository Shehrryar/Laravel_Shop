import React, { useState } from "react";
import axios from "axios";
import { Link, usePage, router} from "@inertiajs/react";
import { route } from "ziggy-js";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
const WomenCollection = () => {
  const { products, wishlist, brands, sizes, colors , cat_slug, subcat_slug, subsubcat_slug } = usePage().props;
  const [sortValue, setSortValue] = useState("");
  const [selectedBrands, setSelectedBrands] = useState([]);
  const [selectedSize, setSelectedSize] = useState("");
  const [selectedColor, setSelectedColor] = useState("");
  const [price, setPrice] = useState(0);
  const [wishlistItems, setWishlistItems] = useState(wishlist || {});
  const handleSortChange = (e) => {
    const value = e.target.value;
    setSortValue(value);
  };



  const toggleBrandSelection = (brandId) => {
  setSelectedBrands((prev) =>
    prev.includes(brandId)
      ? prev.filter((id) => id !== brandId) // remove if already selected
      : [...prev, brandId] // add if not selected
  );
};





  const handleApplyFilter = () => {
    const filters = {
      color_id: selectedColor,
      brand_id: selectedBrands,
      size_id: selectedSize,
      price: price,
      sortValue: sortValue,
    };

    router.get(
      route("front.shop", {
        cat_slug: cat_slug || "",
        subcat_slug: subcat_slug || "",
        subsubcat_slug: subsubcat_slug || "",
      }),
      filters,
      {
        preserveScroll: true,
        preserveState: true,
              onSuccess: () => {
        // Close the Bootstrap modal after route finishes
        const modal = document.querySelector("#filterModal"); // your modal ID
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
          modalInstance.hide();
        }
      },
      }
    );
  };



  // ✅ Toggle Wishlist
  const toggleWishlist = async (productId) => {
    const isWishlisted = !!wishlistItems[productId];
    try {
      setWishlistItems((prev) => {
        const updated = { ...prev };
        if (isWishlisted) delete updated[productId];
        else updated[productId] = true;
        return updated;
      });
      const response = await axios.post(route("front.addtowishlist"), {
        product_id: productId,
        action: isWishlisted ? "remove" : "add",
      });
      if (response.data.status === false && response.data.userlogin === false) {
        window.location.href = route("account.login");
      }
    } catch (error) {
      console.error("Error updating wishlist:", error);
    }
  };
  return (
    <>
      {/* Header */}
      <header>
        <div className="back-links">
          <Link href={route("front.home")}>
            <i className="iconly-Arrow-Left icli"></i>
            <div className="content">
              <h2>{cat_slug} Collection</h2>
              <h6>{products.data.length} Products</h6>
            </div>
          </Link>
        </div>
        <div className="header-option">
          <ul>
            <li>
              <Link href={route("account.wishlist")}>
                <i className="iconly-Heart icli"></i>
              </Link>
            </li>
            <li>
              <Link href={route("front.cart")}>
                <i className="iconly-Buy icli"></i>
              </Link>
            </li>
          </ul>
        </div>
      </header>
      {/* Search Panel */}
      <div className="search-panel top-space px-15">
        <div className="search-bar">
          <input className="form-control form-theme" placeholder="Search" />
          <i className="iconly-Search icli search-icon"></i>
          <i className="iconly-Camera icli camera-icon"></i>
        </div>
        <div
          className="filter-btn"
          data-bs-toggle="modal"
          data-bs-target="#filterModal"
        >
          <i className="iconly-Filter icli"></i>
        </div>
      </div>
      {/* Products Section */}
      <section className="px-15 lg-t-space">
        <div className="container-fluid">
          <div className="row g-3">
            {products.data.map((prod) => (
              <div className="col-6" key={prod.id}>
                <div className="product-box ratio_square shadow-sm rounded-3">
                  <div className="img-part position-relative">
                    <Link href={route("front.product", prod.slug)}>
                      <img
                        src={`${prod.image || "/admin-assets/img/default-150x150.png"}`}
                        alt={prod.title}
                        className="img-fluid bg-img w-100 rounded-3"
                      />
                    </Link>
                    {/* Wishlist Button */}
                    <div
                      className={`wishlist-btn ${
                        wishlistItems[prod.id] ? "active" : ""
                      } position-absolute top-0 end-0 m-2`}
                      onClick={() => toggleWishlist(prod.id)}
                      style={{ cursor: "pointer" }}
                    >
                      {wishlistItems[prod.id] ? (
                        <i
                          className="iconly-Heart icbo"
                          style={{ display: "block", color: "red" }}
                        ></i>
                      ) : (
                        <i className="iconly-Heart icli"></i>
                      )}
                      <div className="effect-group">
                        {[...Array(5)].map((_, i) => (
                          <span className="effect" key={i}></span>
                        ))}
                      </div>
                    </div>
                    {/* NEW Badge Example */}
                    {prod.is_new && (
                      <label className="badge bg-danger position-absolute top-0 start-0 m-2">
                        NEW
                      </label>
                    )}
                  </div>
                  <div className="product-content mt-2 text-center">
                    <ul className="ratings d-flex justify-content-center mb-1">
                      {[1, 2, 3, 4].map((i) => (
                        <li key={i}>
                          <i className="iconly-Star icbo"></i>
                        </li>
                      ))}
                      <li>
                        <i className="iconly-Star icbo empty"></i>
                      </li>
                    </ul>
                    <Link href={route("front.product", prod.slug)}>
                      <h4 className="fw-semibold text-dark">{prod.title}</h4>
                    </Link>
                    <div className="price">
                      <h5 className="mb-0">
                        ${prod.price}
                        <del className="text-muted small ms-1">$35.00</del>
                        <span className="text-danger ms-1">20%</span>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
      {/* Filter Modal */}
      <div
        className="modal filter-modal"
        id="filterModal"
        tabIndex="-1"
        aria-hidden="true"
      >
        <div className="modal-dialog modal-fullscreen">
          <div className="modal-content">
            <div className="modal-header">
              <h2>Filters</h2>
              <a data-bs-dismiss="modal">
                <img
                  src="/front-assets/svg/x-dark.svg"
                  className="img-fluid"
                  alt="close"
                />
              </a>
            </div>
            <div className="modal-body">
              {/* Sort By */}
              <div className="filter-box">
                <h2 className="filter-title">Sort By:</h2>
                <div className="filter-content">
                  <select
                  className="form-select form-control form-theme"
                  onChange={handleSortChange}
                  value={sortValue}
                  >
                    <option defaultValue>Recommended</option>
                    <option value="1">Popularity</option>
                    <option value="latest">What's New</option>
                    <option value="pricehigh">Price: High to Low</option>
                    <option value="pricelow">Price: Low to High</option>
                    <option value="byrating">Customer rating</option>
                  </select>
                </div>
              </div>
              {/* Brand */}
              <div className="filter-box">
                <h2 className="filter-title">Brand:</h2>
                <div className="filter-content">
                  <ul className="row filter-row g-3">
                    {brands.map((brand) => (
                      <li
                        key={brand.id}
                        className={`col-6 ${selectedBrands.includes(brand.id) ? "active" : ""}`}
                         onClick={() => toggleBrandSelection(brand.id)}
                      >
                        <div className="filter-col">{brand.name}</div>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
              {/* Size */}
              <div className="filter-box">
                <h2 className="filter-title">Size:</h2>
                <div className="filter-content">
                  <ul className="row filter-row g-3">
                    {sizes.map((size) => (
                      <li
                        key={size.id}
                        className={`col-4 ${
                          selectedSize === size.id ? "active" : ""
                        }`}
                        onClick={() => setSelectedSize(size.id)}
                      >
                        <div className="filter-col">{size.name}</div>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
              {/* Price */}
              <div className="filter-box">
                <h2 className="filter-title">Price:</h2>
                <div className="filter-content text-center">
                  <input
                    type="range"
                    min="0"
                    max="1000"
                    step="10"
                    value={price}
                    className="form-range w-100"
                    onChange={(e) => setPrice(e.target.value)}
                  />
                  <span className="mt-2 fw-semibold">Rs {price}</span>
                </div>
              </div>
              {/* Colors */}
              <div className="filter-box">
                <h2 className="filter-title">Colors:</h2>
                <div className="filter-content">
                  <ul className="filter-color d-flex flex-wrap gap-2">
                    {colors.map((color) => (
                      <li
                        key={color.id}
                        onClick={() => setSelectedColor(color.id)}
                      >
                        <div
                          style={{
                            backgroundColor: color.value,
                            width: "25px",
                            height: "25px",
                            borderRadius: "50%",
                            border:
                              selectedColor === color.id
                                ? "2px solid #000"
                                : "1px solid #ccc",
                            cursor: "pointer",
                          }}
                          title={color.name}
                        ></div>
                      </li>
                    ))}
                  </ul>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              <a className="reset-link" data-bs-dismiss="modal">
                RESET
              </a>
              <button onClick={handleApplyFilter} className="btn btn-primary w-100">
                Apply Filter
              </button>
            </div>
          </div>
        </div>
      </div>
      {/* Bottom Navigation */}
      <section className="panel-space"></section>
      <div className="bottom-panel">
        <ul>
          {[
            { to: route("front.home"), label: "Home", icon: "Home" },
            { to: route("product.getCategories"), label: "Category", icon: "Category" },
            { to: route("front.cart"), label: "Cart", icon: "Buy" },
            { to: route("account.wishlist"), label: "Wishlist", icon: "Heart" },
            { to: route("account.profile"), label: "Profile", icon: "Profile" },
          ].map((item, index) => (
            <li className={index === 0 ? "active" : ""} key={item.label}>
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
export default WomenCollection;