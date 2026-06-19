import React from "react";
import { Link, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import ThemeButton from "./ThemeButton";
import RtlButton from "./RtlButton";
const Sidebar = ({ open, onClose, user }) => {
    const { translations } = usePage().props;
    return (
        <>
            {/* Overlay */}
            <div
                className={`overlay-sidebar ${open ? "show" : ""}`}
                onClick={onClose}
            />
            {/* Sidebar */}
            <div className={`header-sidebar ${open ? "show" : ""}`}>
                {/* User Panel */}
                <Link href={route("account.profile")} className="user-panel">
                    <img
                        src="/front-assets/images/user/1.png"
                        className="img-fluid user-img"
                        alt="user"
                    />
                    <span>{user?.name || "Guest"}</span>
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
                                        <h4 className="mb-0">
                                            {translations["Dark Mode"]}
                                        </h4>
                                    </div>
                                    <div className="button toggle-btn ms-auto">
                                        <ThemeButton />
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
                                        <h4 className="mb-0">
                                            {translations["RTL"]}
                                        </h4>
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
                        {/* Currency */}
                        <li>
                            <Link href={route("front.currency")}>
                                <i className="iconly-Paper icli" />
                                <div className="content">
                                    <h4>{translations["Currency"]}</h4>
                                    <h6>
                                        {translations["Elements & Other Pages"]}
                                    </h6>
                                </div>
                            </Link>
                        </li>
                        {/*  pages */}
                        {/* <li>
                            <a href="pages.html">
                                <i className="iconly-Paper icli" />
                                <div className="content">
                                    <h4>{translations["Pages"]}</h4>
                                    <h6>
                                        {translations["Elements & Other Pages"]}
                                    </h6>
                                </div>
                            </a>
                        </li> */}
                        {/* Home */}
                        <li>
                            <Link href={route("front.home")}>
                                <i className="iconly-Home icli" />
                                <div className="content">
                                    <h4>{translations["Home"]}</h4>
                                    <h6>
                                        {
                                            translations[
                                                "Offers, Top Deals, Top Brands"
                                            ]
                                        }
                                    </h6>
                                </div>
                            </Link>
                        </li>
                        {/* Categories */}
                        <li>
                            <Link href={route("product.getCategories")}>
                                <i className="iconly-Category icli" />
                                <div className="content">
                                    <h4>{translations["Shop by Category"]}</h4>
                                    <h6>
                                        {
                                            translations[
                                                "Men, Women, Kids, Beauty.."
                                            ]
                                        }
                                    </h6>
                                </div>
                            </Link>
                        </li>
                        {/* Orders */}
                        <li>
                            <Link href={route("account.orders")}>
                                <i className="iconly-Document icli" />
                                <div className="content">
                                    <h4>{translations["Orders"]}</h4>
                                    <h6>
                                        {
                                            translations[
                                                "Ongoing Orders, Recent Orders.."
                                            ]
                                        }
                                    </h6>
                                </div>
                            </Link>
                        </li>
                        {/* Wishlist */}
                        <li>
                            <Link href={route("account.wishlist")}>
                                <i className="iconly-Heart icli" />
                                <div className="content">
                                    <h4>{translations["Your Wishlist"]}</h4>
                                    <h6>
                                        {translations["Your Saved Products"]}
                                    </h6>
                                </div>
                            </Link>
                        </li>
                        {/* Account */}
                        <li>
                            <Link href={route("account.profile")}>
                                <i className="iconly-Profile icli" />
                                <div className="content">
                                    <h4>{translations["Your Account"]}</h4>
                                    <h6>
                                        {
                                            translations[
                                                "Profile, Settings, Saved Cards..."
                                            ]
                                        }
                                    </h6>
                                </div>
                            </Link>
                        </li>
                        {/* Language */}
                        <li>
                            <Link href={route("account.languages")}>
                                <img
                                    src="/front-assets/images/flag.png"
                                    className="img-fluid"
                                    alt="flag"
                                />
                                <div className="content">
                                    <h4>{translations["Language"]}</h4>
                                    <h6>
                                        {
                                            translations[
                                                "Select your Language here.."
                                            ]
                                        }
                                    </h6>
                                </div>
                            </Link>
                        </li>
                        {/* Notification */}
                        {/* <li>
                            <a href="notification.html">
                                <i className="iconly-Notification icli" />
                                <div className="content">
                                    <h4>{translations["Notification"]}</h4>
                                    <h6>
                                        {
                                            translations[
                                                "Offers, Order tracking messages.."
                                            ]
                                        }
                                    </h6>
                                </div>
                            </a>
                        </li> */}
                        {/* Settings */}
                        <li>
                            <Link href={route("front.settings")}>
                                <i className="iconly-Setting icli" />
                                <div className="content">
                                    <h4>{translations["Settings"]}</h4>
                                    <h6>
                                        {
                                            translations[
                                                "Dark mode, RTL, Notification"
                                            ]
                                        }
                                    </h6>
                                </div>
                            </Link>
                        </li>
                    </ul>
                    <div className="divider" />
                    <ul className="link-section">
                        {/* About */}
                        <li>
                            <a href="about-us.html">
                                <i className="iconly-Info-Square icli" />
                                <div className="content">
                                    <h4>{translations["About us"]}</h4>
                                    <h6>{translations["About Multikart"]}</h6>
                                </div>
                            </a>
                        </li>
                        {/* Help */}
                        <li>
                            <a href="help.html">
                                <i className="iconly-Call icli" />
                                <div className="content">
                                    <h4>
                                        {translations["Help/Customer Care"]}
                                    </h4>
                                    <h6>
                                        {translations["Customer Support, FAQs"]}
                                    </h6>
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