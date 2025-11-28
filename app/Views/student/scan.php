<!DOCTYPE html>
<html>
<head>
    <title>Scan QR | AbsenQ</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        #reader {
            width: 330px;
            margin: auto;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;margin-top:20px;">Scan QR Mahasiswa</h2>

<div id="reader"></div>

<script>
function onScanSuccess(decodedText, decodedResult) {
    console.log("QR hasil:", decodedText);

    fetch("/scan/submit", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ qr: decodedText })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
);

html5QrcodeScanner.render(onScanSuccess);
</script>

</body>
</html>
