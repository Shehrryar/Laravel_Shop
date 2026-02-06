import React, { useState, useEffect } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import { route } from "ziggy-js";
import BottomNav from "./Components/BottomNav";

const Currency = () => {
    const { translations, currency, current_currency, cartquantity } = usePage().props;

    // Local state for instant radio feedback
    const [selectedCode, setSelectedCode] = useState(current_currency?.code ?? "");

    // Sync state if props change (e.g., after page refresh/redirect)
    useEffect(() => {
        setSelectedCode(current_currency?.code ?? "");
    }, [current_currency?.code]);

    const handleCurrencyChange = (code) => {
        // Instant UI update
        setSelectedCode(code);

        // Send request – preserve state/scroll for smoother feel
        router.post(
            route("currency.change"),
            { currency: code },
            {
                preserveState: true,
                preserveScroll: true,
                // Optional: onSuccess/onError callbacks if you want to handle flash/toast
            }
        );
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

            {/* Optional success message (uncomment if you enable flash in controller) */}
            {/* {usePage().props.flash?.success && (
                <div className="alert alert-success text-center">
                    {usePage().props.flash.success}
                </div>
            )} */}

            {/* Currency List */}
            <section className="language-listing px-15 top-space pt-0">
                <ul className="language-list">
                    {currency.map((cur) => (
                        <li
                            key={cur.id}
                            className="d-flex justify-content-between align-items-center p-3 border-bottom"
                            onClick={() => handleCurrencyChange(cur.code)}
                            style={{ cursor: "pointer" }}
                        >
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
                            <input
                                type="radio"
                                name="currency"
                                checked={selectedCode === cur.code}
                                readOnly
                            />
                        </li>
                    ))}
                </ul>
            </section>

            <section className="panel-space"></section>

            <BottomNav />
        </>
    );
};

export default Currency;