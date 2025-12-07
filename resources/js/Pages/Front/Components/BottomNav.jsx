import React, { useEffect } from "react";
import { route } from "ziggy-js";
import { Link, usePage } from "@inertiajs/react";

const BottomNav = () => {
    const { url } = usePage(); // current full URL

    const navItems = [
        { to: "/", label: "Home", icon: "Home" },
        { to: "/Categories", label: "Category", icon: "Category" },
        { to: "/account/cart", label: "Cart", icon: "Buy" },
        { to: "/account/mywishlist", label: "Wishlist", icon: "Heart" },
        { to: "/account/profile", label: "Profile", icon: "Profile" },
    ];

    const currentPath = new URL(url, window.location.origin).pathname.toLowerCase();

    // Debug: log current path whenever it changes
    useEffect(() => {
        console.log("Current URL:", currentPath);
    }, [currentPath]);

    return (
        <div className="bottom-panel">
            <ul>
                {navItems.map((item) => {
                    const itemPath = new URL(item.to, window.location.origin).pathname.toLowerCase();
                    const isActive = currentPath === itemPath;

                    return (
                        <li key={item.label} className={isActive ? "active" : ""}>
                            <Link href={item.to}>
                                <div className="icon">
                                    <i className={`iconly-${item.icon} icli`} />
                                    <i className={`iconly-${item.icon} icbo`} />
                                </div>
                                <span>{item.label}</span>
                            </Link>
                        </li>
                    );
                })}
            </ul>
        </div>
    );
};

export default BottomNav;
