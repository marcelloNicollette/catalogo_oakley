<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug de Fontes - Neue Plak</title>
    <style>
        /* Registrar fontes direto pelo navegador para debug */
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 400;
            src: url('{{ asset('fonts/Neue-Plak-Regular.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 600;
            src: url('{{ asset('fonts/Neue-Plak-SemiBold.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 700;
            src: url('{{ asset('fonts/Neue-Plak-Bold.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 900;
            src: url('{{ asset('fonts/Neue-Plak-Black.ttf') }}') format('truetype');
        }

        body { font-family: 'Neue-Plak', sans-serif; padding: 24px; }
        .row { margin-bottom: 16px; }
        .w400 { font-weight: 400; }
        .w600 { font-weight: 600; }
        .w700 { font-weight: 700; }
        .w900 { font-weight: 900; }
        code { background: #f5f5f5; padding: 2px 6px; border-radius: 4px; }
        .check { color: #555; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Debug de Fontes: Neue Plak</h1>
    <p class="check">Verifique no DevTools (Network) se os arquivos de fonte são baixados de <code>/fonts</code>.</p>

    <div class="row w400">Peso 400 (Regular) – A rápida raposa marrom pula sobre o cão preguiçoso 1234567890</div>
    <div class="row w600">Peso 600 (SemiBold) – A rápida raposa marrom pula sobre o cão preguiçoso 1234567890</div>
    <div class="row w700">Peso 700 (Bold) – A rápida raposa marrom pula sobre o cão preguiçoso 1234567890</div>
    <div class="row w900">Peso 900 (Black) – A rápida raposa marrom pula sobre o cão preguiçoso 1234567890</div>

    <hr>
    <p>Se alguma linha acima renderizar com uma fonte diferente, significa que a fonte correspondente não foi carregada corretamente.</p>
</body>
</html>