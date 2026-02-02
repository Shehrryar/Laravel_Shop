import React from "react";

import { Link } from "@inertiajs/react";
import BottomNav from "./Components/BottomNav";
import ThemeButton from "./Components/ThemeButton";
import RtlButton from "./Components/RtlButton";

const SettingsPage = () => {
    return (
        <div>
            {/* header start */}
            <header>
                <div className="back-links">
                    <Link href={route("front.home")}>
                        <i className="iconly-Arrow-Left icli"></i>
                        <div className="content">
                            <h2>settings</h2>
                        </div>
                    </Link>
                </div>
            </header>
            {/* header end */}

            {/* section start */}
            <section className="px-15 top-space pt-0 ratio_40">
                <div className="help-img rounded-1">
                    <img
                        src="/front-assets/images/setting.jpg"
                        className="img-fluid bg-img bg-top"
                        alt=""
                    />
                </div>
            </section>
            {/* section end */}

            {/* setting section start */}
            <section className="px-15 pt-3">
                <h2 className="mb-2">Settings</h2>
                <div className="row">
                    <div className="form-group toggle-sec col-12 mb-3">
                        <label>
                            Dark <span>Lorem ipsum dolor sit amet</span>
                        </label>
                        <div className="button toggle-btn">
                            <ThemeButton />
                        </div>
                    </div>

                    <div className="form-group toggle-sec col-12 mb-3">
                        <label>
                            RTL <span>Lorem ipsum dolor sit amet</span>
                        </label>
                        <div className="button toggle-btn">
                            <RtlButton />
                        </div>
                    </div>

                    {/* <div className="form-group toggle-sec col-12">
                        <label>
                            Notification <span>Lorem ipsum dolor sit amet</span>
                        </label>
                        <div className="button toggle-btn">
                            <input type="checkbox" className="checkbox" />
                            <div className="knobs">
                                <span></span>
                            </div>
                            <div className="layer"></div>
                        </div>
                    </div> */}
                </div>
            </section>
            {/* setting section end */}

            {/* panel space start */}
            <section className="panel-space"></section>
            {/* panel space end */}

            {/* bottom panel start */}
            <BottomNav />
            {/* bottom panel end */}
        </div>
    );
};

export default SettingsPage;
