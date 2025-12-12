import React, { useEffect, useState } from "react";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import ThemeButton from "./ThemeButton";
import RtlButton from "./RtlButton";
const Sidebar = () => {
    return (
        <>
            {/* Overlay */}
            <a className="overlay-sidebar" />
            {/* Sidebar */}
            <div className="header-sidebar">
                {/* User Panel */}
                <Link
                    // href={route("front.profile.settings")}
                    className="user-panel"
                >
                    <img
                        src="/front-assets/images/user/1.png"
                        className="img-fluid user-img"
                        alt="user"
                    />
                    <span>Hello, Paige Turner</span>
                    <i className="iconly-Arrow-Right-2 icli" />
                </Link>
                {/* Sidebar Links */}
                <div className="sidebar-content">
                    <ul className="link-section">
                        {/* Dark Mode */}
                        <li>
                            <div>
                                <i className="iconly-Setting icli" />
                                <div className="content toggle-sec w-100">
                                    <div>
                                        <h4 className="mb-0">Dark Mode</h4>
                                    </div>
                                    <div className="button toggle-btn ms-auto">
                                        <ThemeButton />
                                        <div className="knobs">
                                            <span />
                                        </div>
                                        <div className="layer" />
                                    </div>
                                </div>
                            </div>
                        </li>

                        {/* RTL */}
                        <li>
                            <div>
                                <i className="iconly-Setting icli" />
                                <div className="content toggle-sec w-100">
                                    <div>
                                        <h4 className="mb-0">RTL</h4>
                                    </div>

                                    <div className="button toggle-btn ms-auto">
                                        <RtlButton />
                                        <div className="knobs">
                                            <span />
                                        </div>
                                        <div className="layer" />
                                    </div>
                                </div>
                            </div>
                        </li>

                        {/* Links */}
                        <li>
                            <a href="pages.html">
                                <i className="iconly-Paper icli" />
                                <div className="content">
                                    <h4>Pages</h4>
                                    <h6>Elements & Other Pages</h6>
                                </div>
                            </a>
                        </li>
                        <li>
                            <Link href={route("front.home")}>
                                <i className="iconly-Home icli" />
                                <div className="content">
                                    <h4>Home</h4>
                                    <h6>Offers, Top Deals, Top Brands</h6>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link href={route("product.getCategories")}>
                                <i className="iconly-Category icli" />
                                <div className="content">
                                    <h4>Shop by Category</h4>
                                    <h6>Men, Women, Kids, Beauty..</h6>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link href={route("account.orders")}>
                                <i className="iconly-Document icli" />
                                <div className="content">
                                    <h4>Orders</h4>
                                    <h6>Ongoing Orders, Recent Orders..</h6>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link href={route("account.wishlist")}>
                                <i className="iconly-Heart icli" />
                                <div className="content">
                                    <h4>Your Wishlist</h4>
                                    <h6>Your Saved Products</h6>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link href={route("account.profile")}>
                                <i className="iconly-Profile icli" />
                                <div className="content">
                                    <h4>Your Account</h4>
                                    <h6>Profile, Settings, Saved Cards...</h6>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <a href="#">
                                <img
                                    src="/front-assets/images/flag.png"
                                    className="img-fluid"
                                    alt="flag"
                                />
                                <div className="content">
                                    <h4>Language</h4>
                                    <h6>Select your Language here..</h6>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="notification.html">
                                <i className="iconly-Notification icli" />
                                <div className="content">
                                    <h4>Notification</h4>
                                    <h6>Offers, Order tracking messages..</h6>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="settings.html">
                                <i className="iconly-Setting icli" />
                                <div className="content">
                                    <h4>Settings</h4>
                                    <h6>Dark mode, RTL, Notification</h6>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div className="divider" />
                    <ul className="link-section">
                        <li>
                            <a href="about-us.html">
                                <i className="iconly-Info-Square icli" />
                                <div className="content">
                                    <h4>About us</h4>
                                    <h6>About Multikart</h6>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="help.html">
                                <i className="iconly-Call icli" />
                                <div className="content">
                                    <h4>Help/Customer Care</h4>
                                    <h6>Customer Support, FAQs</h6>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </>
    );
};
export default Sidebar;
