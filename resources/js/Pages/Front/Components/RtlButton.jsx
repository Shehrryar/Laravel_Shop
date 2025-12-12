import React, { useEffect, useState } from "react";

const RtlButton = () => {
    const [rtl, setRtl] = useState(localStorage.getItem("dir") === "rtl");

    useEffect(() => {
        const rtlLink = document.getElementById("rtl-link");

        if (!rtlLink) return;

        if (rtl) {
            document.documentElement.setAttribute("dir", "rtl");
            rtlLink.href = "front-assets/css/vendors/bootstrap.rtl.css";

            localStorage.setItem("dir", "rtl");
            localStorage.setItem(
                "rtlcss",
                "front-assets/css/vendors/bootstrap.rtl.css"
            );
        } else {
            document.documentElement.removeAttribute("dir");
            rtlLink.href = "front-assets/css/vendors/bootstrap.css";

            localStorage.setItem("dir", "");
            localStorage.setItem(
                "rtlcss",
                "front-assets/css/vendors/bootstrap.css"
            );
        }
    }, [rtl]);

    return (
        <>
            {/* RTL */}

            <input
                id="rtlButton"
                type="checkbox"
                className="checkbox"
                checked={rtl}
                onChange={(e) => setRtl(e.target.checked)}
            />
        </>
    );
};

export default RtlButton;
