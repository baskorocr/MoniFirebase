import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { getFirestore } from "firebase/firestore";
import { getDatabase } from "firebase/database";

// Konfigurasi Firebase
const firebaseConfig = {
    apiKey: "AIzaSyBBBnYdf0RHgc9w3-K95FOtPmBVzwaVl40",
    authDomain: "coldstorage-21a26.firebaseapp.com",
    databaseURL:
        "https://coldstorage-21a26-default-rtdb.asia-southeast1.firebasedatabase.app", // Pastikan URL ini sesuai
    projectId: "coldstorage-21a26",
    storageBucket: "coldstorage-21a26.appspot.com",
    messagingSenderId: "396436945590",
    appId: "1:396436945590:web:20d188c839f6fd3ee4c417",
};

// Inisialisasi Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);
const database = getDatabase(app); // Tambahkan Realtime Database

export { auth, db, database };
