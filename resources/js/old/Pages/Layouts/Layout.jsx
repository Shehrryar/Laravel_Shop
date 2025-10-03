import React from "react";
import { Link, usePage } from "@inertiajs/react";

export default function Layout({ children, title }) {
  const { auth, cart, categories, keyword, languages, locale } = usePage().props;

  return (
    <div>
      {/* ================= Top Header ================= */}
      <div className="bg-light top-header">
        <div className="container">
          <div className="row align-items-center py-3 d-none d-lg-flex justify-content-between">
            <div className="col-lg-4 logo">
              <Link href="/" className="text-decoration-none">
                <span className="h1 text-uppercase text-primary bg-dark px-2">
                  ONLINE SHOP
                </span>
              </Link>
            </div>

            <div className="col-lg-6 col-6 text-left d-flex justify-content-end align-items-center">
              {auth?.user ? (
                <Link href="/account/profile" className="nav-link text-dark">
                  {auth.user.name}
                </Link>
              ) : (
                <Link href="/account/login" className="nav-link text-dark">
                  Login
                </Link>
              )}

              {/* Search form */}
              <form
                id="search_product"
                name="search_product"
                action="/product/search"
                method="POST"
              >
                <div className="input-group">
                  <input
                    type="text"
                    defaultValue={keyword || ""}
                    name="search_query"
                    placeholder="Search For Products"
                    className="form-control"
                  />
                  <span className="input-group-text">
                    <button type="submit">
                      <i className="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      {/* ================= Header / Navbar ================= */}
      <header className="bg-dark">
        <div className="container">
          <nav className="navbar navbar-expand-xl" id="navbar">
            <Link href="/" className="text-decoration-none mobile-logo">
              <span className="h2 text-uppercase text-primary bg-dark">Online</span>
              <span className="h2 text-uppercase text-white px-2">SHOP</span>
            </Link>

            <button
              className="navbar-toggler menu-btn"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
            >
              <i className="navbar-toggler-icon fas fa-bars"></i>
            </button>

            <div className="collapse navbar-collapse" id="navbarSupportedContent">
              <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                {categories?.length > 0 &&
                  categories.map((category) => (
                    <li className="nav-item dropdown" key={category.id}>
                      <Link
                        href={`/shop/${category.slug}`}
                        className="btn btn-dark dropdown-toggle"
                      >
                        {category.name}
                      </Link>

                      {category.sub_category?.length > 0 && (
                        <ul className="dropdown-menu dropdown-menu-dark">
                          {category.sub_category.map((subcategory) => (
                            <li key={subcategory.id} className="dropdown-submenu">
                              <Link
                                className="dropdown-item nav-link"
                                href={`/shop/${category.slug}/${subcategory.slug}`}
                              >
                                {subcategory.name}
                              </Link>

                              {subcategory.sub_sub_category?.length > 0 && (
                                <ul className="dropdown-menu dropdown-menu-dark">
                                  {subcategory.sub_sub_category.map((subSub) => (
                                    <li key={subSub.id}>
                                      <Link
                                        className="dropdown-item nav-link"
                                        href={`/shop/${category.slug}/${subcategory.slug}/${subSub.slug}`}
                                      >
                                        {subSub.name}
                                      </Link>
                                    </li>
                                  ))}
                                </ul>
                              )}
                            </li>
                          ))}
                        </ul>
                      )}
                    </li>
                  ))}
              </ul>
            </div>

            {/* Right Side */}
            <div className="right-nav py-0 d-flex align-items-center">
              <Link href="#" id="chatboxdisplay" className="nav-link d-flex align-items-center">
                <i className="fas fa-comments" style={{ marginRight: "8px" }}></i>
              </Link>

              <ul className="navbar-nav ml-auto">
                <li className="nav-item dropdown">
                  <select id="languageSelect" className="form-control">
                    {languages?.map((lang) =>
                      lang.status === 1 ? (
                        <option
                          key={lang.id}
                          value={lang.Isocode}
                          selected={locale === lang.Isocode}
                        >
                          {lang.name}
                        </option>
                      ) : null
                    )}
                  </select>
                </li>
              </ul>

              <Link href="/cart" className="d-flex notification" style={{ marginLeft: "10px" }}>
                <i className="fa-solid fa-cart-shopping" style={{ fontSize: "29px" }}></i>
                <span className="badge">{cart?.totalQuantity || 0}</span>
              </Link>


              
            </div>
          </nav>
        </div>
      </header>

      {/* ================= Page Content ================= */}
      <main>{children}</main>

      {/* ================= Footer ================= */}
      <footer className="bg-dark mt-5">
        <div className="container pb-5 pt-3">
          <div className="row">
            <div className="col-md-4">
              <div className="footer-card">
                <h3>Get In Touch</h3>
                <p>
                  No dolore ipsum accusam no lorem. <br />
                  123 Street, New York, USA <br />
                  example@example.com <br />
                  000 000 0000
                </p>
              </div>
            </div>

            <div className="col-md-4">
              <div className="footer-card">
                <h3>Important Links</h3>
                <ul>
                  <li><Link href="/about">About</Link></li>
                  <li><Link href="/contact">Contact Us</Link></li>
                  <li><Link href="#">Privacy</Link></li>
                  <li><Link href="#">Terms & Conditions</Link></li>
                  <li><Link href="#">Refund Policy</Link></li>
                </ul>
              </div>
            </div>

            <div className="col-md-4">
              <div className="footer-card">
                <h3>My Account</h3>
                <ul>
                  <li><Link href="/login">Login</Link></li>
                  <li><Link href="/register">Register</Link></li>
                  <li><Link href="/orders">My Orders</Link></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div className="copyright-area">
          <div className="container">
            <div className="row">
              <div className="col-12 mt-3">
                <div className="copy-right text-center">
                  <p>© Copyright 2025 Online Shop. All Rights Reserved</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}
