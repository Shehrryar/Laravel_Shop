import React from "react";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";

export default function Sidebar() {
  return (
    <div className="col-md-3">
      <ul id="account-panel" className="nav nav-pills flex-column">
        <li className="nav-item">
          <Link
            href={route("account.profile")}
            className="nav-link font-weight-bold"
          >
            <i className="fas fa-user-alt"></i> My Profile
          </Link>
        </li>
        <li className="nav-item">
          <Link
            href={route("account.address")}
            className="nav-link font-weight-bold"
          >
            <i className="fas fa-address-book"></i> Address
          </Link>
        </li>
        <li className="nav-item">
          <Link
            href={route("account.orders")}
            className="nav-link font-weight-bold"
          >
            <i className="fas fa-shopping-bag"></i> My Orders
          </Link>
        </li>
        <li className="nav-item">
          <Link
            href={route("account.wishlist")}
            className="nav-link font-weight-bold"
          >
            <i className="fas fa-heart"></i> Wishlist
          </Link>
        </li>
        <li className="nav-item">
          <Link
            // href={route("account.changePassword")}
            className="nav-link font-weight-bold"
          >
            <i className="fas fa-lock"></i> Change Password
          </Link>
        </li>
        <li className="nav-item">
          <Link
            href={route("account.logout")}
            className="nav-link font-weight-bold"
          >
            <i className="fas fa-sign-out-alt"></i> Logout
          </Link>
        </li>
      </ul>
    </div>
  );
}
