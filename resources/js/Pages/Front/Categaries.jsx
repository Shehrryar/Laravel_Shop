import React from "react";
import { route } from "ziggy-js";
import { Link, usePage } from "@inertiajs/react";
import BottomNav from "./Components/BottomNav";

const CategoryPage = () => {
    const { translations, categories = [], cartquantity } = usePage().props;

    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>{translations["Categories"] || "Categories"}</h2>
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
                                <span>{cartquantity?.totalQuantity || 0}</span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </header>

            {/* Category Section */}
            <section className="category-listing px-15 top-space pt-0">
                {categories.map((category) => (
                    <Link
                        key={category.id}
                        href={route("product.getInnerCategory", {
                            categoryid: category.id,
                        })}
                        className="category-wrap"
                    >
                        <div className="content-part">
                            <h2>{category.translated_name || category.name || category.title}</h2>
                            <h4>View products</h4>
                        </div>

                        <div className="img-part">
                            <img
                                src={
                                    category.image
                                        ? `/upload/category/${category.image}`
                                        : "/admin-assets/img/default-150x150.png"
                                }
                                alt={category.name || "Category"}
                            />
                        </div>
                    </Link>
                ))}
            </section>

            <section className="panel-space"></section>

            <BottomNav />
        </>
    );
};

export default CategoryPage;