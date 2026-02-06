import React, { useEffect, useRef, useState } from "react";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import axios from "axios";
import { UseCurrency } from "./Components/UseCurrency";
import BottomNav from "./Components/BottomNav";
import WishlistButton from "./Components/WishlistButton";

const Search = ({ wishlist, latestproducts }) => {
    const [query, setQuery] = useState("");
    const [results, setResults] = useState([]); // search results
    const [loading, setLoading] = useState(false);
    const cancelSource = useRef(null);

    const { convertPrice, symbol } = UseCurrency();

    // Show latest products initially
    useEffect(() => {
        setResults(latestproducts);
    }, [latestproducts]);

    // Fetch products from backend while typing
    useEffect(() => {
        if (query.trim().length < 2) {
            // Show latest products if query is empty or < 2 chars
            setResults(latestproducts);
            return;
        }

        const timeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 300); // debounce

        return () => clearTimeout(timeout);
    }, [query, latestproducts]);

    const fetchSuggestions = async (value) => {
        if (cancelSource.current) cancelSource.current.cancel();
        cancelSource.current = axios.CancelToken.source();
        setLoading(true);

        try {
            const res = await axios.get(route("front.search.products"), {
                params: { q: value },
                cancelToken: cancelSource.current.token,
            });
            setResults(res.data);
        } catch (error) {
            if (!axios.isCancel(error)) console.error("Search error:", error);
        } finally {
            setLoading(false);
        }
    };

    return (
        <>
            {/* Search Bar */}
            <div className="search-panel w-back pt-3 px-15">
                <Link href={route("front.home")} className="back-btn">
                    <i className="iconly-Arrow-Left icli"></i>
                </Link>
                <div className="search-bar">
                    <input
                        className="form-control form-theme"
                        placeholder="Search products..."
                        value={query}
                        onChange={(e) => setQuery(e.target.value)}
                        autoFocus
                    />
                    <i className="iconly-Search icli search-icon"></i>
                </div>
            </div>

            {/* Product Grid */}
            <section className="px-15 lg-t-space">
                <div className="container-fluid">
                    {loading && <p>Searching...</p>}
                    {!loading && results.length === 0 && <p>No products found</p>}

                    <div className="row g-3">
                        {results.map((prod) => (
                            <div className="col-6" key={prod.id}>
                                <div className="product-box ratio_square shadow-sm rounded-3">
                                    <div className="img-part position-relative">
                                        <Link
                                            href={route("front.product", { slug: prod.slug })}
                                        >
                                            <img
                                                style={{ height: "265px" }}
                                                src={
                                                    prod.product_images?.length > 0
                                                        ? `/upload/products/${prod.product_images[0].image}`
                                                        : "/admin-assets/img/default-150x150.png"
                                                }
                                                alt={prod.title}
                                                className="img-fluid bg-img w-100 rounded-3"
                                            />
                                        </Link>

                                        <WishlistButton
                                            productId={prod.id}
                                            isWishlisted={wishlist[prod.id]}
                                        />

                                        {prod.is_new && (
                                            <label className="badge bg-danger position-absolute top-0 start-0 m-2">
                                                NEW
                                            </label>
                                        )}
                                    </div>

                                    <div className="product-content mt-2 text-center">
                                        <ul className="ratings d-flex justify-content-center mb-1">
                                            {[1, 2, 3, 4, 5].map((i) => (
                                                <li key={i}>
                                                    <i
                                                        className={`iconly-Star icbo ${
                                                            i <= Math.round(prod.avg_rating)
                                                                ? ""
                                                                : "empty"
                                                        }`}
                                                    ></i>
                                                </li>
                                            ))}
                                        </ul>

                                        <Link
                                            href={route("front.product", { slug: prod.slug })}
                                        >
                                            <h4 className="fw-semibold text-dark">
                                                {prod.title}
                                            </h4>
                                        </Link>

                                        <div className="price">
                                            <h5 className="mb-0">
                                                {prod.discount_value > 0 ? (
                                                    <>
                                                        {symbol}
                                                        {convertPrice(prod.discounted_price)}
                                                        <del className="text-muted small ms-1">
                                                            {symbol}
                                                            {convertPrice(prod.actual_price)}
                                                        </del>
                                                        <span className="text-danger ms-1">
                                                            {prod.discount_value}%
                                                        </span>
                                                    </>
                                                ) : (
                                                    <>
                                                        {symbol}
                                                        {convertPrice(prod.actual_price)}
                                                    </>
                                                )}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section className="panel-space"></section>
            <BottomNav />
        </>
    );
};

export default Search;
