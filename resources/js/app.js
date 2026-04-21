import './bootstrap';
import { Html5QrcodeScanner, Html5QrcodeScanType } from "html5-qrcode";

document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("reader");
    if (!el) return;
    const resultEl = document.getElementById('result')
    const rawToken = document.getElementById('tokenAbsen')

    const scanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbox: 200,
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
    });

    scanner.render((decodedText) => {
        if(decodedText){
            scanner.pause()
            rawToken.value = `${decodedText}${rawToken.value}`
            document.querySelector('#formAbsen').submit()
        }
    });
});
