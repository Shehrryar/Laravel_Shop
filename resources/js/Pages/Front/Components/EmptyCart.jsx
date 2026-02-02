import React from "react";
import { Link,usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
const EmptyCart = () => {
    const { translations } = usePage().props;
    return (
        <>
            {/* Header Start */}
            <header>
                <div className="back-links">
                    <Link href={route("front.shop")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Shop</h2>
                        </div>
                    </Link>
                </div>
                <div className="header-option">
                    <ul>
                        <li>
                            <Link href={route("front.cart")}>
                                {/*  Changed class → className */}
                                <i className="iconly-Buy icli" />
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>
            {/* Header End */}
            {/* Empty Cart Section */}
            <section className="px-15">
                <div className="empty-cart-section text-center">
                    <img
                        src="/front-assets/images/empty-cart.png"
                        className="img-fluid"
                        alt="Empty Cart"
                    />
                    <h2>{translations["Whoops !! Cart is Empty"]}</h2>
                    <p>
                        {translations["Looks like you haven’t added anything to your cart yet. You’ll find lots of interesting products on our “Shop” page."]}
                    </p>
                    <Link
                        href={route("front.shop")}
                        className="btn btn-solid w-100"
                    >
                        {translations["Start Shopping"]}
                    </Link>
                </div>
            </section>
        </>
    );
};
export default EmptyCart;