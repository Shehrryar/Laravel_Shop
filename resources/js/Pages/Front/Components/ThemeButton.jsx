import React, { useEffect, useState } from "react";

const ThemeButton = () => {
    const [darkMode, setDarkMode] = useState(
        localStorage.getItem("body") === "dark"
    );

    useEffect(() => {
        const body = document.body;
        const linkTag = document.getElementById("change-link");

        if (!linkTag) return;

        if (darkMode) {
            body.classList.add("dark");
            linkTag.href = "front-assets/css/dark.css";

            localStorage.setItem("body", "dark");
            localStorage.setItem("layoutcss", "front-assets/css/dark.css");
        } else {
            body.classList.remove("dark");
            linkTag.href = "front-assets/css/style.css";

            localStorage.setItem("body", "");
            localStorage.setItem("layoutcss", "front-assets/css/style.css");
        }
    }, [darkMode]);

    return (
        <>
            <input
                id="darkButton"
                type="checkbox"
                className="checkbox"
                checked={darkMode}
                onChange={(e) => setDarkMode(e.target.checked)}
            />
            <div className="knobs">
                <span />
            </div>
            <div className="layer" />
        </>
    );
};

export default ThemeButton;
