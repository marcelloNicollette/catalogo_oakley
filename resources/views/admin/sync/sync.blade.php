<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sincronização Google Sheets - Oakley</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            white-space: pre-line;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .info-box {
            background-color: #e7f3ff;
            border: 1px solid #b8daff;
            color: #004085;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .sync-form {
            text-align: center;
            margin-top: 30px;
        }

        .btn-sync {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-sync:hover {
            background-color: #0056b3;
        }

        .btn-sync:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .process-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
        }

        ul {
            text-align: left;
            margin: 10px 0;
        }

        li {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🔄 Sincronização Google Sheets</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="info-box">
            <h3>📋 Sobre a Sincronização</h3>
            <p>Este processo irá sincronizar os dados da planilha Google Sheets com o banco de dados do sistema,
                incluindo:</p>
            <ul>
                <li><strong>Produtos:</strong> Nome, descrição, código, SKU, preço</li>
                <li><strong>Categorias e Subcategorias:</strong> Criação automática se não existirem</li>
                <li><strong>Cores:</strong> Até 10 cores por produto com códigos</li>
                <li><strong>Características:</strong> Peso, drop, origem, tecnologia, gênero, modalidade</li>
                <li><strong>Numerações:</strong> Tamanhos disponíveis com controle de estoque</li>
                <li><strong>Links:</strong> URLs relacionadas aos produtos</li>
                <li><strong>Calendário:</strong> Datas de lançamento (MKT, Trade, Cliente, DTC)</li>
            </ul>
        </div>

        <div class="process-info">
            <h4>⚠️ Importante:</h4>
            <ul>
                <li>O processo pode demorar alguns minutos dependendo da quantidade de dados</li>
                <li>Produtos existentes serão atualizados com base no SKU</li>
                <li>Dados relacionados (cores, características, etc.) serão substituídos</li>
                <li>Mantenha a página aberta durante o processo</li>
            </ul>
        </div>

        <form action="{{ route('admin.sync-sheet') }}" method="get" class="sync-form">
            <button type="submit" class="btn-sync"
                onclick="this.disabled=true; this.innerHTML='🔄 Sincronizando...'; this.form.submit();">
                🚀 Iniciar Sincronização
            </button>
        </form>
    </div>

    <script>
        // Auto-refresh se houver mensagem de sucesso ou erro
        @if (session('success') || session('error'))
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.opacity = '0.7';
                });
            }, 5000);
        @endif
    </script>
</body>

</html>
