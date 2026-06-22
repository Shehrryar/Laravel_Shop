import axios from "axios";
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const token = document.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.getAttribute("content");
}

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY || "local",
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || "mt1",

    wsHost: import.meta.env.VITE_PUSHER_HOST || "127.0.0.1",
    wsPort: Number(import.meta.env.VITE_PUSHER_PORT || 6001),
    wssPort: Number(import.meta.env.VITE_PUSHER_PORT || 6001),

    forceTLS: false,
    encrypted: false,
    enabledTransports: ["ws"],

    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": token ? token.getAttribute("content") : "",
            "X-Requested-With": "XMLHttpRequest",
        },
    },
});