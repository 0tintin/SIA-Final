<!DOCTYPE html>
<html>
<head>
    <title>QR Code Scanner</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ffc72c; /* McDonald's yellow */
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #wrapper {
            text-align: center;
            background-color: #da291c; /* McDonald's red */
            padding: 20px;
            border-radius: 10px;
        }

        #reader {
            width: 300px;
            height: 300px;
            border: 2px solid #ffc72c; /* McDonald's yellow */
            position: relative;
            overflow: hidden;
            margin: 0 auto;
        }

        #scan-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #ffc72c; /* McDonald's yellow */
            animation: scan 2s infinite linear;
        }

        @keyframes scan {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(100%);
            }
        }

        h1 {
            font-size: 36px;
            margin-bottom: 30px;
            color: #000000;
        }

        #message {
            margin-top: 20px;
            font-size: 24px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <h1>Scan QR Code</h1>
        <div id="reader">
            <div id="scan-line"></div>
        </div>
        <div id="message"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@latest/dist/html5-qrcode.min.js"></script>
    <script>
        const config = {
            fps: 30,
            qrbox: 200
        }

        const scanner = new Html5QrcodeScanner("reader", config);

        const success = (data) => {
            document.getElementById('message').innerText = 'Successfully scanned: ' + data;
            scanner.clear();
            setTimeout(() => {
                location.reload(); // Refresh the page after a delay
            }, 3000); // 3 seconds delay
        }

        const error = (err) => {
            console.error(err);
        }

        scanner.render(success, error);
    </script>
</body>
</html>
