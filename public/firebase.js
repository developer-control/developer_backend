// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-messaging.js";

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
getToken(messaging, { vapidKey })
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


if (Notification.permission === "granted") {
    // console.log("Izin notifikasi sudah diberikan.");
    firebaseInit();
} else if (Notification.permission === "denied") {
    // console.log("Izin notifikasi telah ditolak.");
} else {
    $("#notificationPermission").modal("show");
}

$("#btn-request-notification-permission").on("click", function () {
    // Pengguna belum memberikan izin, atau izin belum diketahui
    // Anda dapat meminta izin notifikasi dengan menggunakan requestPermission
    Notification.requestPermission().then(async function (permission) {
        if (permission === "granted") {
            // console.log("Izin notifikasi diberikan.");
            await firebaseInit();
            location.reload();
        } else {
            $("#notificationPermission").modal("hide");
            // console.log("Izin notifikasi ditolak.");
        }
    });
});