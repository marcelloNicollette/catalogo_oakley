{{-- 
    EXEMPLO DE USO DO COMPONENTE HEADER
    
    Para usar o componente de header em qualquer página, simplesmente inclua:
    
    <x-header :user="auth()->user()" />
    
    O componente irá:
    - Exibir o logo da Olympikus
    - Mostrar o nome do usuário logado (se fornecido)
    - Incluir o ícone de usuário
    - Fornecer o botão de logout funcional
    
    Parâmetros:
    - user: Objeto do usuário logado (opcional)
      - Se não fornecido, apenas o nome não será exibido
      - Acesse através de auth()->user() para o usuário atual
    
    Exemplo completo em uma página:
--}}

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minha Página</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>
<body class="bg-[#F1F1F1] flex flex-col min-h-screen">
    <!-- Usar o componente header -->
    <x-header :user="auth()->user()" />
    
    <!-- Conteúdo da página -->
    <main class="flex-1">
        <h1>Conteúdo da página aqui</h1>
    </main>
</body>
</html>