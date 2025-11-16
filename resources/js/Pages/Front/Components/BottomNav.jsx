import React, { useEffect, useState } from 'react';
import { route } from "ziggy-js";
import { Link, } from "@inertiajs/react";

const BottomNav = () => {
  const navItems = [
    { to: route("front.home"), label: "Home", icon: "Home" },
    { to: route("product.getCategories"), label: "Category", icon: "Category" },
    { to: route("front.cart"), label: "Cart", icon: "Buy" },
    { to: route("account.wishlist"), label: "Wishlist", icon: "Heart" },
    { to: route("account.profile"), label: "Profile", icon: "Profile" },
  ];

  return (
    <>
      {/* Bottom Panel Start */}
      <div className="bottom-panel">
        <ul>
          {navItems.map((item, index) => (
            <li key={item.label} className={index === 0 ? "active" : ""}>
              <Link href={item.to}>
                <div className="icon">
                  <i className={`iconly-${item.icon.toLowerCase()} icli`} />
                  <i className={`iconly-${item.icon.toLowerCase()} icbo`} />
                </div>
                <span>{item.label}</span>
              </Link>
            </li>
          ))}
        </ul>
      </div>
      {/* Bottom Panel End */}
    </>
  );
};

export default BottomNav;
