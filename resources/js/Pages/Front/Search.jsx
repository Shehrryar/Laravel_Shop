import React, { useEffect, useRef, useState } from "react";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import axios from "axios";
import SpeechRecognition, {
    useSpeechRecognition,
} from "react-speech-recognition";

import { UseCurrency } from "./Components/UseCurrency";
import BottomNav from "./Components/BottomNav";
import WishlistButton from "./Components/WishlistButton";

const Search = ({ wishlist, latestproducts, translations }) => {
    const [query, setQuery] = useState("");
    const [results, setResults] = useState([]);
    const [loading, setLoading] = useState(false);

    const cancelSource = useRef(null);

    const { convertPrice, symbol } = UseCurrency();

    const {
        transcript,
        listening,
        resetTranscript,
        browserSupportsSpeechRecognition,
    } = useSpeechRecognition();

    // Show latest products when page opens
    useEffect(() => {
        setResults(latestproducts);
    }, [latestproducts]);

    // When voice text changes, put it inside search box
    useEffect(() => {
        if (transcript) {
            setQuery(transcript);
        }
    }, [transcript]);

    // Search products while typing or after voice input
    useEffect(() => {
        if (query.trim().length < 2) {
            setResults(latestproducts);
            return;
        }

        const timeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 300);

        return () => clearTimeout(timeout);
    }, [query, latestproducts]);

    const fetchSuggestions = async (value) => {
        if (cancelSource.current) {
            cancelSource.current.cancel();
        }

        cancelSource.current = axios.CancelToken.source();

        setLoading(true);

        try {
            const res = await axios.get(route("front.search.products"), {
                params: {
                    q: value,
                },
                cancelToken: cancelSource.current.token,
            });

            // Support both response formats:
            // 1. Direct array
            // 2. { status: true, data: [...] }
            const searchData = Array.isArray(res.data)
                ? res.data
                : res.data?.data || [];

            setResults(searchData);
        } catch (error) {
            if (!axios.isCancel(error)) {
                console.error("Search error:", error);
            }
        } finally {
            setLoading(false);
        }
    };

    const startVoiceSearch = () => {
        if (!browserSupportsSpeechRecognition) {
            alert("Your browser does not support voice search. Please use Google Chrome or Microsoft Edge.");
            return;
        }

        resetTranscript();

        SpeechRecognition.startListening({
            continuous: false,
            language: "en-US",
        });
    };

    const stopVoiceSearch = () => {
        SpeechRecognition.stopListening();
    };

    const clearSearch = () => {
        setQuery("");
        resetTranscript();
        setResults(latestproducts);
    };

    return (
        <>
            {/* Search Bar */}
            <div className="search-panel w-back pt-3 px-15">
                <Link href={route("front.home")} className="back-btn">
                    <i className="iconly-Arrow-Left icli"></i>
                </Link>

                <div
                    className="search-bar"
                    style={{
                        display: "flex",
                        alignItems: "center",
                        gap: "8px",
                    }}
                >
                    <input
                        className="form-control form-theme"
                        placeholder="Search products by name, brand, SKU, or price..."
                        value={query}
                        onChange={(e) => setQuery(e.target.value)}
                        autoFocus
                    />

                    {/* Search Icon */}
                    <i className="iconly-Search icli search-icon"></i>

                    {/* Voice Search Button */}
                    <button
                        type="button"
                        onClick={listening ? stopVoiceSearch : startVoiceSearch}
                        title="Voice Search"
                        style={{
                            border: "1px solid #d9d9d9",
                            width: "48px",
                            height: "48px",
                            borderRadius: "4px",
                            background: listening ? "#dcdcdc" : "#efefef",
                            cursor: "pointer",
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "center",
                            flexShrink: 0,
                            padding: 0,
                        }}
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#222"
                            strokeWidth="2"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                        >
                            <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                            <line x1="12" y1="19" x2="12" y2="23"></line>
                            <line x1="8" y1="23" x2="16" y2="23"></line>
                        </svg>
                    </button>

                    {/* Clear Button */}
                    {query && (
                        <button
                            type="button"
                            onClick={clearSearch}
                            title="Clear Search"
                            style={{
                                border: "none",
                                width: "34px",
                                height: "34px",
                                borderRadius: "50%",
                                background: "#eee",
                                color: "#333",
                                fontSize: "18px",
                                cursor: "pointer",
                                display: "flex",
                                alignItems: "center",
                                justifyContent: "center",
                                flexShrink: 0,
                            }}
                        >
                            ×
                        </button>
                    )}
                </div>

                {/* Listening Message */}
                {listening && (
                    <p
                        style={{
                            color: "#dc3545",
                            fontSize: "13px",
                            marginTop: "8px",
                            marginLeft: "45px",
                            fontWeight: "600",
                        }}
                    >
                        Listening... please speak product name
                    </p>
                )}
            </div>

            {/* Product Grid */}
            <section className="px-15 lg-t-space">
                <div className="container-fluid">
                    {query && (
                        <h6 style={{ marginBottom: "15px" }}>
                            Searching: <b>{query}</b>
                        </h6>
                    )}

                    {loading && <p>{translations["Searching..."] || "Searching..."}</p>}

                    {!loading && results.length === 0 && (
                        <p>{translations["No products found"] || "No products found"}</p>
                    )}

                    <div className="row g-3">
                        {results.map((prod) => (
                            <div className="col-6" key={prod.id}>
                                <div className="product-box ratio_square shadow-sm rounded-3">
                                    <div className="img-part position-relative">
                                        <Link
                                            href={route("front.product", {
                                                slug: prod.slug,
                                            })}
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
                                                {translations["New"] || "New"}
                                            </label>
                                        )}
                                    </div>

                                    <div className="product-content mt-2 text-center">
                                        <ul className="ratings d-flex justify-content-center mb-1">
                                            {[1, 2, 3, 4, 5].map((i) => (
                                                <li key={i}>
                                                    <i
                                                        className={`iconly-Star icbo ${
                                                            i <=
                                                            Math.round(prod.avg_rating || 0)
                                                                ? ""
                                                                : "empty"
                                                        }`}
                                                    ></i>
                                                </li>
                                            ))}
                                        </ul>

                                        <Link
                                            href={route("front.product", {
                                                slug: prod.slug,
                                            })}
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
                                                        {convertPrice(
                                                            prod.discounted_price
                                                        )}

                                                        <del className="text-muted small ms-1">
                                                            {symbol}
                                                            {convertPrice(
                                                                prod.actual_price
                                                            )}
                                                        </del>

                                                        <span className="text-danger ms-1">
                                                            {prod.discount_value}%
                                                        </span>
                                                    </>
                                                ) : (
                                                    <>
                                                        {symbol}
                                                        {convertPrice(
                                                            prod.actual_price
                                                        )}
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