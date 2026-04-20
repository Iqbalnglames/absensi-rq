import './bootstrap';
import { Html5QrcodeScanner, Html5QrcodeScanType } from "html5-qrcode";

document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("reader");
    if (!el) return;
    const resultEl = document.getElementById('result')

    const scanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbox: 250,
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
    });

    scanner.render((decodedText) => {
        if(resultEl){
            resultEl.innerText = decodedText
        }
        scanner.pause()
    });
});