// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-messaging.js";

//   import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDCeMHKDn6mra3TwPeN4mZoi2PpsqMe7Kk",
    authDomain: "developer-control-c98e0.firebaseapp.com",
    projectId: "developer-control-c98e0",
    storageBucket: "developer-control-c98e0.firebasestorage.app",
    messagingSenderId: "717310348669",
    appId: "1:717310348669:web:013e322b118e6f36e11014",
    measurementId: "G-DD70ZNCKS3"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Tambahkan VAPID Key
const vapidKey = "BKvEzzB-zmoFpmbBZclwZX9yVQ049oo8kcxbTm2SoPJTMKK0OwEa1x6by6El1fXdyXMwl2EvNcy_whLY7yPA3d4";

// Meminta izin dan mendapatkan token perangkat
messaging
    .requestPermission()
    .then(() => getToken(messaging, { vapidKey }))
    .then((currentToken) => {
        if (currentToken) {
            console.log("Token perangkat:", currentToken);
            // Kirim token ke server Anda untuk disimpan
        } else {
            console.warn("Tidak ada token yang tersedia.");
        }
    })
    .catch((err) => {
        console.error("Error mendapatkan token:", err);
    });
