<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Onayı - NORTHERN</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: #ffffff;
        }

        .email-header {
            text-align: center;
            padding: 30px 20px;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .email-header img {
            max-height: 100px !important;
            max-width: 120px !important;
            object-fit: contain;
        }

        .email-header h1 {
            margin: 15px 0 5px;
            font-size: 28px;
            color: #ffffff;
        }

        .email-body {
            background-color: #ffffff;
            border-radius: 12px 12px 0 0;
            padding: 20px;
            color: #333333;
            text-align: left;
            line-height: 1.6;
        }

        .email-body h2 {
            font-size: 22px;
            color: #2c2c2c;
            margin-bottom: 15px;
        }

        .email-footer {
            text-align: center;
            background-color: #1a1a1a;
            padding: 15px 20px;
            color: #ffffff;
            font-size: 14px;
            border-radius: 0 0 12px 12px;
        }

        .email-footer a {
            color: #ffffff;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .email-body,
            .email-footer,
            .email-header {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ Storage::url(ayar('altLogo')) }}" alt="NORTHERN Logosu">
            <h1>Sipariş Onayı</h1>
            <p>Teşekkür ederiz!</p>
        </div>
        <div class="email-body">
            <h2>Merhaba {{ $siparis->siparisBilgi->isim }},</h2>
            <p>Siparişiniz başarıyla alındı. Siparişinizin detaylarını aşağıda bulabilirsiniz:</p>
            <p><strong>Sipariş No:</strong> {{ $siparis->kod }}</p>
            <p><strong>Sipariş Tutarı:</strong> {{ formatPara($siparis->butun_tutarlar['genel_toplam']) }} TL</p>
            <p><strong>Tarih:</strong> {{ formatZaman($siparis->created_at) }}</p>
            <br>
            <p>Siparişiniz kısa süre içerisinde işleme alınacaktır. Herhangi bir sorunuz olursa bizimle iletişime geçmekten çekinmeyin.</p>
            <p>Teşekkürler!</p>
        </div>
        <div class="email-footer">
            © 2025 NORTHERN. Tüm Hakları Saklıdır. <br>
            <a href="https://www.gulercasual.com">www.gulercasual.com</a>
        </div>
    </div>
</body>

</html>
