import "./bootstrap";
import React from "react";
import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import { initGlobalSettings } from "./Pages/utils/initTheme";
import ChatbotWidget from "./Pages/Front/Components/ChatbotWidget";
import CustomerAdminChatWidget from "./Pages/Front/Components/CustomerAdminChatWidget";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.jsx", { eager: true });
        let page = pages[`./Pages/${name}.jsx`];
        return page;
    },
    setup({ el, App, props }) {
        createRoot(el).render(
            <>
                <App {...props} />
                <ChatbotWidget />
                <CustomerAdminChatWidget />
            </>
        );
    },
});
initGlobalSettings();