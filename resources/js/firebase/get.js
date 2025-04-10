import { database } from "./config";
import { ref, onValue } from "firebase/database";

export const getLocationData = (serialNumber, callback) => {
    console.log(serialNumber);
    if (!serialNumber) {
        console.error("❌ Serial Number tidak valid!");
        return;
    }

    const locationRef = ref(database, serialNumber); // Tanpa "devices/"

    onValue(
        locationRef,
        (snapshot) => {
            if (snapshot.exists()) {
                console.log(
                    `✅ Data ditemukan untuk ${serialNumber}:`,
                    snapshot.val()
                );
                callback(snapshot.val());
            } else {
                console.log(`❌ Data tidak ditemukan untuk ${serialNumber}`);
                callback(null);
            }
        },
        (error) => {
            console.error("🔥 Error mengambil data dari Firebase:", error);
        }
    );
};
