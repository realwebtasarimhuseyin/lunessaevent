<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İşlem Sonucu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
        }

        .sonuc-container {
            text-align: center;
            padding: 40px;
            border-radius: 16px;
            background-color: white;
            box-shadow: 0 0 16px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
        }

        .icon {
            font-size: 64px;
            margin-bottom: 16px;
        }

        .icon.success {
            color: #28a745;
        }

        .icon.fail {
            color: #dc3545;
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            color: #555;
        }

        .loader {
            margin: 20px auto 0;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        window.onload = function () {
            window.parent.postMessage({
                type: 'odemeSonucu',
                status: '{{ $status }}',
                redirectUrl: '{{ $redirectUrl }}'
            }, '*');
        };
    </script>
</head>
<body>
    <div class="sonuc-container">
        <div class="icon {{ $status === 'basarili' ? 'success' : 'fail' }}">
            {{ $status === 'basarili' ? '✅' : '❌' }}
        </div>
        <h2>{{ $status === 'basarili' ? 'Ödeme Başarılı!' : 'Ödeme Başarısız' }}</h2>
        <p>{{ $status === 'basarili' ? 'Siparişiniz alınmıştır, yönlendiriliyorsunuz...' : 'Ödeme işlemi tamamlanamadı, yönlendiriliyorsunuz...' }}</p>
        <div class="loader"></div>
    </div>
</body>
</html>
