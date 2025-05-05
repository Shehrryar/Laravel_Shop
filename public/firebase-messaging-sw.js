import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-analytics.js";
import {
    getMessaging,
    getToken,
} from "https://www.gstatic.com/firebasejs/11.6.1/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyByRxHs3ymietU3OwnHqWwhW9zOguk2YR8",
    authDomain: "laravelecommerenceproject.firebaseapp.com",
    projectId: "laravelecommerenceproject",
    storageBucket: "laravelecommerenceproject.appspot.com",
    messagingSenderId: "349713004767",
    appId: "1:349713004767:web:d474590c465b9990a7116a",
    measurementId: "G-09PYT8H8FK",
};

const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const messaging = getMessaging(app);





