import React from "react";
import { Link, usePage, router } from "@inertiajs/react";
import { route } from "ziggy-js";
import BottomNav from "./Components/BottomNav";
const Currency = () => {
    const { translations, currency , cartquantity} =
        usePage().props;
    const changeCurrency = (code) => {
        router.post(route("currency.change"), {
            currency: code,
        });
    };
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli" />
                        <div className="content">
                            <h2>{translations["Currency"]}</h2>
                        </div>
                    </Link>
                </div>
                <div className="header-option">
                    <ul>
                        <li>
                            <Link href={route("account.wishlist")}>
                                <i className="iconly-Heart icli" />
                            </Link>
                        </li>
                        <li>
                            <Link href={route("front.cart")}>
                                <i className="iconly-Buy icli" />
                                <span>{cartquantity.totalQuantity}</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>
            {/* Currency List */}
            <section className="language-listing px-15 top-space pt-0">
                <ul className="language-list">
                    {currency.map((cur) => (
                        <li
                            key={cur.id}
                            className="d-flex justify-content-between align-items-center p-3 border-bottom"
                            onClick={() => changeCurrency(cur.code)}
                            style={{ cursor: "pointer" }}
                        >
                            {/* Left: Currency Info */}
                            <div className="d-flex align-items-center">
                                <span
                                    style={{
                                        fontSize: "18px",
                                        marginRight: "10px",
                                        fontWeight: "600",
                                    }}
                                >
                                    {cur.symbol}
                                </span>
                                <span>
                                    {cur.name} ({cur.code})
                                </span>
                            </div>
                            {/* Right: Radio */}
                            <input
                                type="radio"
                                name="currency"
                                checked={currency.code === cur.code}
                                onChange={() => changeCurrency(cur.code)}
                            />
                        </li>
                    ))}
                </ul>
            </section>
            {/* Panel Space */}
            <section className="panel-space"></section>
            {/* Bottom Panel */}
            <BottomNav />
        </>
    );
};
export default Currency;