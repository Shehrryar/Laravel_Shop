import React, { useEffect, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import CustomerAddresses from "../Components/CustomerAddresses";
import BottomNav from "../Components/BottomNav";
export default function SavedAddress() {
    const { customeraddresses } = usePage().props;

    return (
        <>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("account.profile")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>Saved Address</h2>
                        </div>
                    </Link>
                </div>
            </header>
            <CustomerAddresses customerAddresses={customeraddresses} />
            <section className="panel-space"></section>
            <BottomNav />
        </>
    );
}
