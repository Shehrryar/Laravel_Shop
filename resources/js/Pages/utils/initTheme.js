// utils.js

// ----------------------------
// THEME HANDLING
// ----------------------------
export function applyThemeFromStorage() {
    const savedTheme = localStorage.getItem("body"); // your stored key
    const linkTag = document.getElementById("change-link");

    if (!linkTag) return;

    if (savedTheme === "dark") {
        $("body").addClass("dark");
        $("#change-link").attr("href", "/front-assets/css/dark.css");
        localStorage.setItem("body", "dark");
        localStorage.setItem("layoutcss", "/front-assets/css/dark.css");
    } else {
        $("body").removeClass("dark");
        $("#change-link").attr("href", "/front-assets/css/style.css");
        localStorage.setItem("body", "");
        localStorage.setItem("layoutcss", "/front-assets/css/style.css");
    }
}

// ----------------------------
// RTL HANDLING
// ----------------------------

export function applyRtlFromStorage() {
    const dir = localStorage.getItem("dir");
    const rtlCss = localStorage.getItem("rtlcss");

    // Set direction
    if (dir === "rtl") {
        document.documentElement.setAttribute("dir", "rtl");
    } 
    
    else {
        document.documentElement.removeAttribute("dir");
    }

    // Update RTL CSS
    // const rtlLink = document.getElementById("rtl-link");
    // if (rtlLink && rtlCss) {
    //     rtlLink.href = rtlCss;
    // }
}

// ----------------------------
// GLOBAL INIT
// ----------------------------
export function initGlobalSettings() {
    applyThemeFromStorage();
    applyRtlFromStorage();
}
