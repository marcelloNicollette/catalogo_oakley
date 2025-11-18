<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Bem-vindo ao Sistema</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .content {
            padding: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 14px;
            color: #666;
        }

        .center {
            text-align: center
        }
    </style>
</head>

<body>
    <div class="header center">
        <h1>Bem-vindo ao Sistema!</h1>
        <img src="http://127.0.0.1:8000/images/logo-Olympikus.png" alt="Logo Under Armour" style="width: 100px;">
    </div>

    <div class="content">
        <p>Olá <strong>{{ $name }}</strong>,</p>

        <p>É com grande prazer que damos as boas-vindas ao nosso sistema!</p>

        <p>Sua conta foi criada com sucesso. Abaixo estão suas informações de acesso:</p>

        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Email:</strong> {{ $email }}</p>
            @if ($password)
                <p><strong>Senha:</strong> {{ $password }}</p>
            @endif
            <p><strong>Tipo de usuário:</strong> {{ ucfirst($type) }}</p>
        </div>

        <p>Agora você pode começar a utilizar todas as funcionalidades da nossa plataforma. Estamos aqui para ajudá-lo
            em sua jornada.</p>

        <p><strong>Importante:</strong> Por segurança, recomendamos que você altere sua senha no primeiro acesso.</p>

        <p>Se tiver alguma dúvida ou precisar de suporte, não hesite em entrar em contato conosco.</p>

        <p>Mais uma vez, seja bem-vindo!</p>
    </div>

    <div class="footer">
        <p>Atenciosamente,<br>Equipe Olympikus</p>
    </div>
</body>

</html>
