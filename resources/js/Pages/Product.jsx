import React from "react";
import Layout from "../Layouts/Layout";
import { Link, router } from "@inertiajs/react";
import axios from "axios";
import { useState } from "react";
export default function Product({
  product,
  wishlist,
  showrelatedproduct,
  avg_rating,
  avg_rating_per,
  discount,
  getPrice,
  product_available_size
}) {


  const [selectedSize, setSelectedSize] = useState("");
  const [selectedColor, setSelectedColor] = useState("");
  


const handleSizeChange = async (sizeId) => {
  setSelectedSize(sizeId);
  setSelectedColor(""); // reset color when size changes
  if (!sizeId) {
    setColors([]); // reset if no size selected
    return;
  }
  try {
    const response = await axios.post(route("product.getcolor"), {
      size_id: sizeId,
    });
    console.log(response);

    // if (response.data.status) {
    //   setColors(response.data.colors);
    // } else {
    //   setColors([]);
    // }
  } catch (error) {
    console.error("Error fetching colors:", error);
  }
};
  
  // const [selectedColor, setSelectedColor] = useState("");
  const [quantity, setQuantity] = useState(1);
    const increment = () => {
    setQuantity((prev) => prev + 1);
  };

  const decrement = () => {
    setQuantity((prev) => (prev > 1 ? prev - 1 : 1)); // prevent going below 1
  };
    const handleAddToCart = () => {  
    // TODO: Implement add to cart functionality
    axios.post('/add-to-cart', {
      product_id: product.id,
      discount_value: getPrice.discount_value,
      discounted_price: getPrice.discounted_price,
      actual_price: getPrice.actual_price,
      quantity: quantity,
    })
    .then(response => {
      if(response.data.status == false && response.data.userlogin == false){
        router.visit('/account/login');
      }
    })
    .catch(error => {
      console.error("Error adding product to cart:", error);
    });
  };





  return (
    <Layout title={product.title}>
      {/* Breadcrumb */}
      <section className="section-5 pt-3 pb-3 mb-3 bg-white">
        <div className="container">
          <div className="light-font">
            <ol className="breadcrumb primary-color mb-0">
              <li className="breadcrumb-item">
                <Link href="/">Home</Link>
              </li>
              <li className="breadcrumb-item">
                <Link href="/shop">Shop</Link>
              </li>
              <li className="breadcrumb-item active">{product.title}</li>
            </ol>
          </div>
        </div>
      </section>
      {/* Product Details */}
      <section className="section-7 pt-3 mb-3">
        <div className="container">
          <div className="row">
            {/* Product Images */}
            <div className="col-md-5">
              <div id="product-carousel" className="carousel slide">
                <div className="carousel-inner bg-light">
                  {product.product_images?.map((img, index) => (
                    <div
                      key={img.id}
                      className={`carousel-item ${index === 0 ? "active" : ""}`}
                    >
                      <img
                        className="w-100 h-100"
                        src={`/upload/products/${img.image}`}
                        alt={product.title}
                      />
                    </div>
                  ))}
                </div>
              </div>
            </div>
            {/* Product Info */}
            <div className="col-md-7">
              <h1>{product.title}</h1>
              <p>{product.short_description}</p>
              {/* Price */}
              <h3>
                {product.discounted_price ? (
                  <>
                    <span className="h5 text-danger">
                      {product.discounted_price}$
                    </span>{" "}
                    <del>{product.price}$</del>
                  </>
                ) : (
                  <span>{product.price}$</span>
                )}
              </h3>
              {/* Rating */}
              <div className="d-flex mb-3">
                <div className="star-rating">
                  <div className="back-stars">
                    {[...Array(5)].map((_, i) => (
                      <i key={i} className="fa fa-star" />
                    ))}
                    <div
                      className="front-stars"
                      style={{ width: `${avg_rating_per}%` }}
                    >
                      {[...Array(5)].map((_, i) => (
                        <i key={i} className="fa fa-star" />
                      ))}
                    </div>
                  </div>
                </div>
                <small className="ps-2">
                  ({product.product_ratings_count} Reviews)
                </small>
              </div>



              {/* Size Selection */}
              {product_available_size?.length > 0 && (
                <div className="mb-3">
                  <h5>Select Size</h5>
                  <select
                    className="form-control"
                    value={selectedSize}
                    onChange={(e) => handleSizeChange(e.target.value)}
                  >
                    <option value="">Select Size</option>
                    {product_available_size.map((size) => (
                      <option key={size.id} value={size.id}>
                        {size.name}
                      </option>
                    ))}
                  </select>
                </div>
              )}



            {/* handle quantity */}
              <div className="d-flex align-items-center mb-3">
                <h5 className="me-3">Select Quantity:</h5>
                <div className="d-flex align-items-center">
                  <button className="btn btn-secondary" onClick={decrement}>
                    <i className="fal fa-minus"></i>
                  </button>
                  <input
                    type="text"
                    className="form-control text-center mx-2"
                    style={{ width: "60px" }}
                    value={quantity}
                    readOnly
                  />
                  <button className="btn btn-secondary" onClick={increment}>
                    <i className="fal fa-plus"></i>
                  </button>
                </div>
              </div>





              {/* Add to Cart Button */}
              <button onClick={handleAddToCart} className="btn btn-dark">
                <i className="fas fa-shopping-cart"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>



      </section>


      {/* Related Products */}
      <section className="pt-5 section-8">
        <div className="container">
          <h2>Related Products</h2>
          <div className="row">
            {showrelatedproduct?.map((related) => (
              <div key={related.id} className="col-md-3">
                <div className="card product-card">
                  <div className="product-image">
                    <Link href={`/product/${related.slug}`}>
                      <img
                        className="card-img-top"
                        src={
                          related.product_images?.[0]
                            ? `/upload/products/${related.product_images[0].image}`
                            : "/admin-assets/img/default-150x150.png"
                        }
                        alt={related.title}
                      />
                    </Link>
                  </div>
                  <div className="card-body text-center">
                    <h6>{related.title}</h6>
                    <p>
                      <strong>{related.price}$</strong>
                      {related.compare_price > 0 && (
                        <del className="ms-2">{related.compare_price}$</del>
                      )}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </Layout>
  );
}