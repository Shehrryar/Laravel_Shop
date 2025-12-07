import React, { useEffect, useState } from "react";
import BottomNav from "../Components/BottomNav";
import { route } from "ziggy-js";
import { Link, usePage } from "@inertiajs/react";
export default function Profile() {
    const { user } = usePage().props;
    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Profile</h2>
                        </div>
                    </Link>
                </div>
            </header>
            {/* Header end */}
            {/* Profile section start */}
            <section className="top-space pt-0">
                <div className="profile-detail">
                    <div className="media">
                        <img
                            src="/front-assets/images/user/1.png"
                            className="img-fluid"
                            alt="User"
                        />
                        <div className="media-body">
                            <h2>{user.name}</h2>
                            <h6>{user.email}</h6>
                            <Link
                                href={route("account.profileEdit")}
                                className="edit-btn"
                            >
                                Edit
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
            {/* Profile section end */}
            {/* Link section start */}
            <div className="sidebar-content">
                <ul className="link-section">
                    {/* Dark Mode toggle */}
                    <li>
                        <div>
                            <i className="iconly-Setting icli"></i>
                            <div className="content toggle-sec w-100">
                                <div>
                                    <h4>Dark Mode</h4>
                                </div>
                                <div className="button toggle-btn ms-auto">
                                    <input
                                        id="darkButton"
                                        type="checkbox"
                                        className="checkbox"
                                    />
                                    <div className="knobs">
                                        <span></span>
                                    </div>
                                    <div className="layer"></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    {/* RTL toggle */}
                    <li>
                        <div>
                            <i className="iconly-Setting icli"></i>
                            <div className="content toggle-sec w-100">
                                <div>
                                    <h4>RTL</h4>
                                </div>
                                <div className="button toggle-btn ms-auto">
                                    <input
                                        id="rtlButton"
                                        type="checkbox"
                                        className="checkbox"
                                    />
                                    <div className="knobs">
                                        <span></span>
                                    </div>
                                    <div className="layer"></div>
                                </div>
                            </div>
                        </div>
                    </li>
                    {/* Pages */}
                    <li>
                        <Link>
                            <i className="iconly-Paper icli"></i>
                            <div className="content">
                                <h4>Pages</h4>
                                <h6>Ongoing Orders, Recent Orders..</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Orders */}
                    <li>
                        <Link href={route("account.orders")}>
                            <i className="iconly-Document icli"></i>
                            <div className="content">
                                <h4>Orders</h4>
                                <h6>Ongoing Orders, Recent Orders..</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Wishlist */}
                    <li>
                        <Link href={route("account.wishlist")}>
                            <i className="iconly-Heart icli"></i>
                            <div className="content">
                                <h4>Your Wishlist</h4>
                                <h6>Your Saved Products</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Payment */}
                    <li>
                        <Link>
                            <i className="iconly-Wallet icli"></i>
                            <div className="content">
                                <h4>Payment</h4>
                                <h6>Saved Cards, Wallets</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Saved address */}
                    <li>
                        <Link href={route("account.savedAddress")}>
                            <i className="iconly-Location icli"></i>
                            <div className="content">
                                <h4>Saved Address</h4>
                                <h6>Home, office..</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Language */}
                    <li>
                        <a href="#">
                            <img
                                src="/front-assets/images/flag.png"
                                className="img-fluid"
                                alt="Language"
                            />
                            <div className="content">
                                <h4>Language</h4>
                                <h6>Select your Language here..</h6>
                            </div>
                        </a>
                    </li>
                    {/* Notifications */}
                    <li>
                        <Link>
                            <i className="iconly-Notification icli"></i>
                            <div className="content">
                                <h4>Notification</h4>
                                <h6>Offers, Order tracking messages..</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Settings */}
                    <li>
                        <Link>
                            <i className="iconly-Setting icli"></i>
                            <div className="content">
                                <h4>Settings</h4>
                                <h6>Dark mode, RTL, Notification</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Profile setting */}
                    <li>
                        <Link>
                            <i className="iconly-Password icli"></i>
                            <div className="content">
                                <h4>Profile Setting</h4>
                                <h6>Full Name, Password..</h6>
                            </div>
                        </Link>
                    </li>
                </ul>
                <div className="divider"></div>
                <ul className="link-section">
                    {/* Terms & Conditions */}
                    <li>
                        <Link>
                            <i className="iconly-Info-Square icli"></i>
                            <div className="content">
                                <h4>Terms & Conditions</h4>
                                <h6>T&C for use of Platform</h6>
                            </div>
                        </Link>
                    </li>
                    {/* Help */}
                    <li>
                        <Link>
                            <i className="iconly-Call icli"></i>
                            <div className="content">
                                <h4>Help / Customer Care</h4>
                                <h6>Customer Support, FAQs</h6>
                            </div>
                        </Link>
                    </li>
                </ul>
            </div>
            {/* Logout */}
            <div className="px-15">
                <Link
                    href={route("account.logout")}
                    method="get"
                    as="button"
                    className="btn btn-outline w-100 content-color"
                >
                    LOG OUT
                </Link>
            </div>
            {/* Link section end */}
            {/* Panel space */}
            <section className="panel-space"></section>
            <BottomNav />
        </>
    );
}
