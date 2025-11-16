import React, { useState } from "react";
const ProductReviewAndRating = ({ product }) => {
    const reviews = product?.product_ratings || [];
    return (
        <div className="product-detail-box px-15">
            <h4 className="page-title">
                Customer Reviews ({product.product_ratings_count || 0}){" "}
                <a href="#">All Reviews</a>
            </h4>
            <div className="review-section">
                <ul>
                    {reviews.map((review, index) => (
                        <li key={review.id || index}>
                            {" "}
                            {/* ✅ unique key added here */}
                            <div className="media">
                                <img
                                    src="/front-assets/images/user/2.png"
                                    className="img-fluid"
                                    alt=""
                                />
                                <div className="media-body">
                                    <h4>
                                        {review.username} {" | "}
                                        {new Date(
                                            review.created_at
                                        ).toLocaleDateString()}
                                    </h4>

                                    <ul className="ratings">
                                        {[...Array(5)].map((_, i) => (
                                            <li
                                                key={`star-${
                                                    review.id || index
                                                }-${i}`}
                                            >
                                                {" "}
                                                {/* ✅ unique key for nested list */}
                                                <i
                                                    className={`iconly-Star icbo ${
                                                        i < review.rating
                                                            ? ""
                                                            : "empty"
                                                    }`}
                                                ></i>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            </div>
                            <h4
                                className="content-color text-gray-700 mt-2 leading-relaxed"
                                style={{
                                    whiteSpace: "pre-wrap",
                                    wordBreak: "break-word",
                                    overflowWrap: "anywhere",
                                    width: "100%",
                                    display: "block",
                                }}
                            >
                                {review.comment}
                            </h4>
                            <div className="review-bottom">
                                <div className="liking-sec">
                                    <span className="content-color">
                                        <img
                                            src="/front-assets/svg/thumbs-up.svg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        20
                                    </span>
                                    <span className="content-color">
                                        <img
                                            src="/front-assets/svg/thumbs-down.svg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        2
                                    </span>
                                </div>
                            </div>
                        </li>
                    ))}
                </ul>
            </div>
        </div>
    );
};
export default ProductReviewAndRating;
