import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";
import { route } from "ziggy-js";
import BottomNav from "./Components/BottomNav";
import "flag-icons/css/flag-icons.min.css";

const LanguagePage = () => {
    const { translations, languages, cartquantity } = usePage().props;

    const flagMap = {
        en: "gb", // English
        ur: "pk", // Urdu
    };

    const [currentLocale, setCurrentLocale] = useState(
        sessionStorage.getItem("locale") || "en"
    );

    const changeLanguage = (locale) => {
        setCurrentLocale(locale);
        sessionStorage.setItem("locale", locale);
        router.get(route("front.localizationcontroller", locale));
    };

    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli" />
                        <div className="content">
                            <h2>{translations["Language"]}</h2>
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

            {/* Language List */}
            <section className="language-listing px-15 top-space pt-0">
                <ul className="language-list">
                    {languages.map((lang) => {
                        const nameTranslations = JSON.parse(
                            lang.name_translations
                        );

                        const displayName =
                            nameTranslations[currentLocale] || lang.name;

                        return (
                            <li
                                key={lang.id}
                                className="d-flex justify-content-between align-items-center p-3 border-bottom"
                                onClick={() =>
                                    changeLanguage(lang.Isocode)
                                }
                                style={{ cursor: "pointer" }}
                            >
                                {/* Left: Flag + Name */}
                                <div className="d-flex align-items-center">
                                    <span
                                        className={`fi fi-${flagMap[lang.Isocode] || "us"}`}
                                        style={{
                                            fontSize: "24px",
                                            marginRight: "10px",
                                        }}
                                    ></span>
                                    <span>{displayName}</span>
                                </div>

                                {/* Right: Radio Button */}
                                <input
                                    type="radio"
                                    name="language"
                                    checked={currentLocale === lang.Isocode}
                                    onChange={() =>
                                        changeLanguage(lang.Isocode)
                                    }
                                />
                            </li>
                        );
                    })}
                </ul>
            </section>

            {/* Panel Space */}
            <section className="panel-space"></section>

            {/* Bottom Panel */}
            <BottomNav />
        </>
    );
};

export default LanguagePage;
