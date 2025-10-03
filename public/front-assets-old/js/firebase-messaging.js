import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
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
const messaging = getMessaging(app);
console.log(messaging);
getToken(messaging, {
    vapidKey:
        "BAI8wULNl0SYJMYgLNNXzRFagB1b_Bf47HDQi7-tXTqKRobU7xyU58JyD-dd47010bhonA908mjSS8ocatfV1og",
})
    .then((currentToken) => {
        if (currentToken) {
            document.getElementById("fcm_token").value = currentToken;
            console.log("Token: ", currentToken);
            // Send the token to your server and update the UI if necessary
            // ...
        } else {
            // Show permission request UI
            console.log(
                "No registration token available. Request permission to generate one."
            );
            // ...
        }
    })
    .catch((err) => {
        console.log("An error occurred while retrieving token. ", err);
        // ...
    });