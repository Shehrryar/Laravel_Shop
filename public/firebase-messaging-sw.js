// No import/export allowed in service worker
importScripts(
    "https://www.gstatic.com/firebasejs/11.6.1/firebase-app-compat.js"
);
importScripts(
    "https://www.gstatic.com/firebasejs/11.6.1/firebase-messaging-compat.js"
);
firebase.initializeApp({
    apiKey: "AIzaSyByRxHs3ymietU3OwnHqWwhW9zOguk2YR8",
    authDomain: "laravelecommerenceproject.firebaseapp.com",
    projectId: "laravelecommerenceproject",
    storageBucket: "laravelecommerenceproject.appspot.com",
    messagingSenderId: "349713004767",
    appId: "1:349713004767:web:d474590c465b9990a7116a",
    measurementId: "G-09PYT8H8FK",
});
const messaging = firebase.messaging();
messaging.onBackgroundMessage(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: "/icon.png",
    };
    self.registration.showNotification(notificationTitle, notificationOptions);
});
