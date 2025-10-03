import React from "react";
import Layout from "../Layouts/Layout";
import { Link, usePage } from "@inertiajs/react";

export default function Home() {
  const { categories, recommended_products, featured_products, latest_products, wishlist, discount } =
    usePage().props;

  return (
    <div>
      {/* ================= Carousel ================= */}
      <section className="section-1">
        <div
          id="carouselExampleIndicators"
          className="carousel slide carousel-fade"
          data-bs-ride="carousel"
          data-bs-interval="false"
        >
          <div className="carousel-inner">
            <div className="carousel-item active">
              <picture>
                <source media="(max-width: 799px)" srcSet="/front-assets/images/carousel-1-m.jpg" />
                <source media="(min-width: 800px)" srcSet="/front-assets/images/carousel-1.jpg" />
                <img src="/front-assets/images/carousel-1.jpg" alt="" />
              </picture>
              <div className="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div className="p-3 text-center">
                  <h1 className="display-4 text-white mb-3">Kids Fashion</h1>
                  <p className="mx-md-5 px-5">
                    Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam
                  </p>
                  <Link className="btn btn-outline-light py-2 px-4 mt-3" href="#">
                    Shop Now
                  </Link>
                </div>
              </div>
            </div>
            {/* TODO: Add the other 2 carousel items here just like above */}
          </div>

          <button className="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span className="carousel-control-prev-icon" aria-hidden="true"></span>
            <span className="visually-hidden">Previous</span>
          </button>
          <button className="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span className="carousel-control-next-icon" aria-hidden="true"></span>
            <span className="visually-hidden">Next</span>
          </button>
        </div>
      </section>

      {/* ================= Features ================= */}
      <section className="section-2 py-5">
        <div className="container">
          <div className="row text-center">
            <div className="col-lg-3">
              <div className="box shadow-lg">
                <div className="fa icon fa-check text-primary m-0 mr-3"></div>
                <h2 className="font-weight-semi-bold m-0">Quality Product</h2>
              </div>
            </div>
            <div className="col-lg-3">
              <div className="box shadow-lg">
                <div className="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                <h2 className="font-weight-semi-bold m-0">Free Shipping</h2>
              </div>
            </div>
            <div className="col-lg-3">
              <div className="box shadow-lg">
                <div className="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                <h2 className="font-weight-semi-bold m-0">14-Day Return</h2>
              </div>
            </div>
            <div className="col-lg-3">
              <div className="box shadow-lg">
                <div className="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                <h2 className="font-weight-semi-bold m-0">24/7 Support</h2>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ================= Categories ================= */}
      <section className="section-3">
        <div className="container">
          <div className="section-title">
            <h2>Categories</h2>
          </div>
          <div className="row pb-3">
            {categories?.map((category) => (
              <div className="col-lg-3" key={category.id}>
                <div className="cat-card">
                  <div className="left">
                    <img src={`/upload/category/${category.image}`} alt={category.name} className="img-fluid" />
                  </div>
                  <div className="right">
                    <div className="cat-data">
                      <h2>{category.name}</h2>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ================= Recommended Products ================= */}
      <section className="section-4 pt-5">
        <div className="container">
          <div className="section-title">
            <h2>Recommended Products</h2>
          </div>
          <div className="row pb-3">
            {recommended_products?.data?.map((product) => (
              <ProductCard key={product.id} product={product} wishlist={wishlist} discount={discount} />
            ))}
          </div>
        </div>
      </section>

      {/* ================= Featured Products ================= */}
      <section className="section-4 pt-5">
        <div className="container">
          <div className="section-title">
            <h2>Featured Products</h2>
          </div>
          <div className="row pb-3">
            {featured_products?.data?.map((product) => (
              <ProductCard key={product.id} product={product} wishlist={wishlist} discount={discount} />
            ))}
          </div>
        </div>
      </section>

      {/* ================= Latest Products ================= */}
      <section className="section-4 pt-5">
        <div className="container">
          <div className="section-title">
            <h2>Latest Products</h2>
          </div>
          <div className="row pb-3">
            {latest_products?.data?.map((product) => (
              <ProductCard key={product.id} product={product} wishlist={wishlist} discount={discount} />
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}

/**
 * Extracted ProductCard Component
 */
function ProductCard({ product, wishlist, discount }) {
  const inWishlist = wishlist?.some((item) => item.product_id === product.id);
  const imagesProd = product.product_images?.[0];
  const price = product.discounted_price ?? product.price;

  return (
    <div className="col-md-3">
      <div className="card product-card">
        <div className="product-image position-relative" style={{ borderBottom: "1px solid #ddd" }}>
          <Link href={`/product/${product.slug}`} className="product-img">
            {imagesProd ? (
              <img style={{ height: "250px", width: "250px" }} className="card-img-top" src={`/upload/products/${imagesProd.image}`} />
            ) : (
              <img className="card-img-top" src="/admin-assets/img/default-150x150.png" />
            )}
          </Link>

          {product.discount_value > 0 && <div className="discount-badge">{product.discount_value}% OFF</div>}

          {/* Wishlist Icons */}
          {!inWishlist ? (
            <a className="whishlist" href="javascript:void(0)">
              <i className="far fa-heart"></i>
            </a>
          ) : (
            <a className="whishlist" href="javascript:void(0)">
              <i className="fas fa-heart text-danger"></i>
            </a>
          )}
        </div>

        <div className="card-body text-center">
          <Link className="h6 link" href={`/product/${product.slug}`}>
            {product.title}
          </Link>
          <div className="price mt-2">
            {product.discounted_price ? (
              <>
                <span className="h5">
                  <strong>{product.discounted_price}$</strong>
                </span>
                <span className="h5">
                  <del>{product.price}$</del>
                </span>
              </>
            ) : (
              <span className="h5">
                <strong>{product.price}$</strong>
              </span>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}

// Attach Layout
Home.layout = (page) => <Layout title="Home">{page}</Layout>;
