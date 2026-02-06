import React, { useState } from "react";
import ProductSlider from "./ProductSlider";
const HomeProductTabs = ({
    homelables = [],
    productsByLabel = {},
    wishlistitems = {},
    translations = {},
}) => {

    // Pick first active label or fallback
    const defaultLabel = homelables.find((l) => l.is_active) || homelables[0];
    const [activeLabel, setActiveLabel] = useState(defaultLabel);
    if (!activeLabel) return null;
    return (
        <section className="pt-0 tab-section">
            {/* Section Header */}
            <div className="title-section px-15">
                <h2>{translations["Find your Style"]}</h2>
                <h3>{translations["Super Summer Sale"]}</h3>
            </div>
            {/* Tabs */}
            <ul className="nav nav-tabs theme-tab pl-15">
                {homelables.map((label) => (
                    <li key={label.id} className="nav-item">
                        <button
                            type="button"
                            className={`nav-link ${
                                activeLabel.id === label.id ? "active" : ""
                            }`}
                            onClick={() => setActiveLabel(label)}
                        >
                            {label.translated_name}
                        </button>
                    </li>
                ))}
            </ul>
            {/* Products Slider */}
            <ProductSlider
                title=""
                products={productsByLabel[activeLabel.label_key] || []}
                wishlist={wishlistitems}
            />
        </section>
    );
};
export default HomeProductTabs;