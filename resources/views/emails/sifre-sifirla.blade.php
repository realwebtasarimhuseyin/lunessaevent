<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Sıfırlama - NORTHERN</title>
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

        .btn {
            display: inline-block;
            text-decoration: none;
            color: #ffffff;
            background-color: #2c2c2c;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #1a1a1a;
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
            <h1>Şifre Sıfırlama İsteği</h1>
            <p>Güvenliğiniz bizim için önemli</p>
        </div>
        <div class="email-body">
            <h2>Merhaba,</h2>
            <p>Şifre sıfırlama talebinde bulundunuz. Şifrenizi sıfırlamak için aşağıdaki butona tıklayabilirsiniz.</p>
            <a href="{{ route('sifre-sifirla-form', ['token' => $token]) . '?eposta=' . $kullaniciEposta }}"
                class="btn">Şifremi Sıfırla</a>
            <p>Bu işlemi siz başlatmadıysanız lütfen bu e-postayı dikkate almayın ve hesabınızın güvende olduğundan emin
                olun.</p>
            <p>Şifre sıfırlama bağlantısı, güvenliğiniz için 24 saat içinde geçerliliğini kaybedecektir.</p>
        </div>
        <div class="email-footer">
            © 2025 NORTHERN. Tüm Hakları Saklıdır. <br>
            <a href="https://www.gulercasual.com">www.gulercasual.com</a>
        </div>
    </div>
</body>

</html>
