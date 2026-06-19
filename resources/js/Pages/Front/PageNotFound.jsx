import React from "react";


import { Link, usePage } from "@inertiajs/react";

import { route } from "ziggy-js";
import BottomNav from "./Components/BottomNav";
const PageNotFound = () => {
    const { translations } = usePage().props;

    return (
        <div>
            {/* Header */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>{translations["404"]}</h2>
                        </div>
                    </Link>
                </div>
            </header>
            {/* Image */}
            <section className="px-15 top-space pt-0 ratio_40">
                <div className="help-img rounded-1">
                    <img
                        src="/front-assets/images/404page.png"
                        className="img-fluid bg-img bg-top"
                        alt="404 Not Found"
                    />
                </div>
            </section>
            {/* Content */}
            <section className="px-15 pt-3 text-center">
                <h2 className="mb-2">{translations["Page Not Found"]}</h2>
                <p className="text-muted mb-3">
                    {translations["The page you are trying to access does not exist."]}
                </p>
                <Link
                    href={route("front.home")}
                    className="btn btn-solid w-100"
                >
                    {translations["Back to Home"]}
                </Link>
            </section>
            {/* Bottom Space */}
            <section className="panel-space"></section>
            {/* Bottom Navigation */}
            <BottomNav />
        </div>
    );
};
export default PageNotFound;
