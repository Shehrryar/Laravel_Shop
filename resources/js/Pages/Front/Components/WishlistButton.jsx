import React, { useState } from "react";
import axios from "axios";
import { route } from "ziggy-js";
const WishlistButton = ({ productId, isWishlisted: initialWishlisted }) => {
    const [isWishlisted, setIsWishlisted] = useState(!!initialWishlisted);
    //  Handle wishlist toggle
    const toggleWishlist = async () => {
        const newStatus = !isWishlisted;
        setIsWishlisted(newStatus);
        try {
            const response = await axios.post(route("front.addtowishlist"), {
                product_id: productId,
                action: newStatus ? "add" : "remove",
            });
            // Redirect if user is not logged in
            if (
                response.data.status === false &&
                response.data.userlogin === false
            ) {
                window.location.href = route("account.login");
            }
        } catch (error) {
            console.error("Error updating wishlist:", error);
            // rollback UI if failed
            setIsWishlisted(!newStatus);
        }
    };
    return (
        <div
            className={`wishlist-btn ${
                isWishlisted ? "active" : ""
            } position-absolute top-0 end-0 m-2`}
            onClick={toggleWishlist}
            style={{ cursor: "pointer" }}
        >
            {isWishlisted ? (
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
    );
};
export default WishlistButton;
