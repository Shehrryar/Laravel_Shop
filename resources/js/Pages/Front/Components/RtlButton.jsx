import React, { useEffect, useState } from "react";
import { applyRtlFromStorage } from "../../utils/initTheme";

const RtlButton = () => {
    const [rtl, setRtl] = useState(localStorage.getItem("dir") === "rtl");

    useEffect(() => {
        if (rtl) {
            localStorage.setItem("dir", "rtl");
            localStorage.setItem(
                "rtlcss",
                "front-assets/css/vendors/bootstrap.rtl.css",
            );
        } else {
            localStorage.setItem("dir", "");
            localStorage.setItem(
                "rtlcss",
                "front-assets/css/vendors/bootstrap.css",
            );
        }
        applyRtlFromStorage();
    }, [rtl]);

    return (
        <div className="button toggle-btn">
            <input
                id="rtlButton"
                type="checkbox"
                className="checkbox"
                checked={rtl}
                onChange={(e) => setRtl(e.target.checked)}
            />
            <div className="knobs">
                <span></span>
            </div>
            <div className="layer"></div>
        </div>
    );
};

export default RtlButton;
