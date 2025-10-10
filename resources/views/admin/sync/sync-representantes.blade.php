@extends('layouts.admin-layout')

@section('page_title', 'Under Armour - Sincronização Google Sheets')
<style>
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

    .sync-section {
        margin-bottom: 40px;
        border: 1px solid #e1e5e9;
        border-radius: 12px;
        padding: 25px;
        background: #fafbfc;
    }

    .section-title {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 700;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
    }

    .btn-sync {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-sync:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-sync:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .btn-users {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        margin-right: 15px;
    }

    .btn-users:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    }

    .btn-users:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .btn-export {
        background: linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(253, 126, 20, 0.3);
        text-decoration: none;
        display: inline-block;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(253, 126, 20, 0.4);
        text-decoration: none;
        color: white;
    }

    .btn-async {
        background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);
        margin-right: 15px;
    }

    .btn-async:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(111, 66, 193, 0.4);
    }

    .btn-async:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
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
@section('content-wrapper')

    <div class="container">
        <h1>🔄 Sincronização Google Sheets</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif


        <!-- Sincronização de Usuários -->
        <!--<div class="sync-section">
                            <h2 class="section-title">👥 Sincronização de Representantes</h2>
                            <div class="info-box">
                                <h3>📋 Sobre a Sincronização de Representantes</h3>
                                <p>Este processo irá sincronizar os dados da aba <strong>REPRESENTANTES</strong> da planilha Google
                                    Sheets com o banco de dados do sistema, incluindo:</p>
                                <ul>
                                    <li><strong>Usuários:</strong> Nome do representante, email, empresa</li>
                                    <li><strong>Códigos de Liderança:</strong> Código do líder comercial EBM</li>
                                    <li><strong>Segmentações de Cliente:</strong> Vinculação automática às segmentações</li>
                                    <li><strong>Senhas:</strong> Geração automática para novos usuários</li>
                                    <li><strong>Arquivo de Senhas:</strong> Exportação automática dos dados de acesso</li>
                                </ul>
                            </div>

                            <div class="process-info">
                                <h4>⚠️ Importante:</h4>
                                <ul>
                                    <li>Usuários existentes serão atualizados com base no email</li>
                                    <li>Senhas são geradas apenas para novos usuários</li>
                                    <li>Um arquivo CSV será gerado com os dados de acesso dos novos usuários</li>
                                    <li>As segmentações de cliente serão criadas automaticamente se não existirem</li>
                                    <li><strong>Sincronização Normal:</strong> Recomendada para até 1000 registros (processamento
                                        direto)</li>
                                    <li><strong>Sincronização Assíncrona:</strong> Recomendada para grandes volumes (processamento em
                                        background)</li>
                                    <li>O processamento assíncrono divide os dados em lotes menores para evitar timeouts</li>
                                </ul>
                            </div>

                            <div class="sync-form">
                                <form action="{{ route('admin.sync-users') }}" method="get"
                                    style="display: inline; margin-right: 10px;">
                                    <button type="submit" class="btn-users"
                                        onclick="this.disabled=true; this.innerHTML='🔄 Sincronizando...'; this.form.submit();">
                                        👥 Sincronizar Representantes (Até 1000 registros)
                                    </button>
                                </form>

                                <form action="{{ route('admin.sync-users-async') }}" method="get"
                                    style="display: inline; margin-right: 10px;">
                                    <button type="submit" class="btn-async"
                                        onclick="this.disabled=true; this.innerHTML='🔄 Processando...'; this.form.submit();">
                                        ⚡ Sincronização Assíncrona (Grandes volumes)
                                    </button>
                                </form>

                                <a href="{{ route('admin.export-users-passwords') }}" class="btn-export">
                                    📊 Exportar Lista de Representantes
                                </a>
                            </div>
                        </div>-->

        <!-- Gerenciamento de Lotes -->
        <div class="sync-section">
            <h2 class="section-title">📦 Sincronização por Lotes (1000 registros cada)</h2>
            <div class="info-box">
                <h3>📋 Sobre a Sincronização por Lotes</h3>
                <p>Esta funcionalidade permite dividir a sincronização em lotes de 1000 registros e executar cada lote
                    individualmente:</p>
                <ul>
                    <li><strong>Controle Manual:</strong> Execute cada lote quando desejar</li>
                    <li><strong>Processamento Seguro:</strong> Evita timeouts e problemas de memória</li>
                    <li><strong>Arquivos Individuais:</strong> Cada lote gera seu próprio arquivo de senhas</li>
                    <li><strong>Rastreamento:</strong> Acompanhe o status de cada lote em tempo real</li>
                </ul>
            </div>

            <div class="batch-controls">
                <form action="{{ route('admin.prepare-batches') }}" method="get"
                    style="display: inline; margin-right: 10px;">
                    <button type="submit" class="btn-prepare"
                        onclick="this.disabled=true; this.innerHTML='🔄 Preparando...'; this.form.submit();">
                        📦 Preparar Lotes de Sincronização
                    </button>
                </form>

                @if (session('total_batches'))
                    <a href="{{ route('admin.clear-batches') }}" class="btn-clear">
                        🗑️ Limpar Lotes
                    </a>
                @endif
            </div>

            @if (session('total_batches'))
                <div class="batch-info">
                    <h4>📊 Informações dos Lotes:</h4>
                    <p><strong>Total de Lotes:</strong> {{ session('total_batches') }}</p>
                    <p><strong>Total de Registros:</strong> {{ session('total_records') }}</p>
                </div>

                <div class="batch-list" id="batchList">
                    <h4>🎯 Executar Lotes:</h4>
                    @for ($i = 0; $i < session('total_batches'); $i++)
                        @php
                            $status = session('batch_status')[$i] ?? 'pending';
                            $statusClass = '';
                            $statusIcon = '';
                            $statusText = '';
                            $disabled = '';

                            switch ($status) {
                                case 'pending':
                                    $statusClass = 'status-pending';
                                    $statusIcon = '⏳';
                                    $statusText = 'Pendente';
                                    break;
                                case 'processing':
                                    $statusClass = 'status-processing';
                                    $statusIcon = '🔄';
                                    $statusText = 'Processando';
                                    $disabled = 'disabled';
                                    break;
                                case 'completed':
                                    $statusClass = 'status-completed';
                                    $statusIcon = '✅';
                                    $statusText = 'Concluído';
                                    $disabled = 'disabled';
                                    break;
                                case 'error':
                                    $statusClass = 'status-error';
                                    $statusIcon = '❌';
                                    $statusText = 'Erro';
                                    break;
                            }
                        @endphp

                        <div class="batch-item {{ $statusClass }}" id="batch-{{ $i }}">
                            <div class="batch-info-inline">
                                <span class="batch-number">Lote {{ $i + 1 }}</span>
                                <span class="batch-status">{{ $statusIcon }} {{ $statusText }}</span>
                            </div>
                            <button class="btn-execute" onclick="executeBatch({{ $i }})" {{ $disabled }}
                                id="btn-{{ $i }}">
                                🚀 Executar Lote {{ $i + 1 }}
                            </button>
                            @php
                                $result = session('batch_results')[$i] ?? null;
                            @endphp
                            <div class="batch-result {{ $status === 'completed' ? 'result-success' : '' }}"
                                id="result-{{ $i }}"
                                style="display: {{ $status === 'completed' && $result ? 'block' : 'none' }};">
                                @if ($status === 'completed' && $result)
                                    <strong>{{ $result['message'] }}</strong><br>
                                    Sucessos: {{ $result['success'] }} | Erros: {{ $result['errors'] }}<br>
                                    @if (!empty($result['filename']))
                                        <a href="/storage/export-users/{{ $result['filename'] }}" download target="_blank"
                                            rel="noopener">📥 Arquivo gerado: {{ $result['filename'] }}</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .batch-controls {
            margin: 20px 0;
        }

        .btn-prepare,
        .btn-clear {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .btn-clear {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        }

        .batch-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .batch-list {
            margin-top: 20px;
        }

        .batch-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            background: white;
            transition: all 0.3s ease;
        }

        .batch-info-inline {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .batch-number {
            font-weight: bold;
            font-size: 16px;
        }

        .batch-status {
            font-size: 14px;
            margin-top: 5px;
        }

        .status-pending {
            border-color: #ffc107;
            background-color: #fff3cd;
        }

        .status-processing {
            border-color: #17a2b8;
            background-color: #d1ecf1;
        }

        .status-completed {
            border-color: #28a745;
            background-color: #d4edda;
        }

        .status-error {
            border-color: #dc3545;
            background-color: #f8d7da;
        }

        .btn-execute {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-execute:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .batch-result {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .result-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .result-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

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

        // Função para executar lote específico
        async function executeBatch(batchIndex) {
            const btn = document.getElementById(`btn-${batchIndex}`);
            const batchItem = document.getElementById(`batch-${batchIndex}`);
            const resultDiv = document.getElementById(`result-${batchIndex}`);

            // Atualiza interface
            btn.disabled = true;
            btn.innerHTML = '🔄 Executando...';
            batchItem.className = 'batch-item status-processing';
            batchItem.querySelector('.batch-status').innerHTML = '🔄 Processando';
            resultDiv.style.display = 'none';

            try {
                const response = await fetch(`/admin/execute-batch/${batchIndex}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Sucesso
                    batchItem.className = 'batch-item status-completed';
                    batchItem.querySelector('.batch-status').innerHTML = '✅ Concluído';
                    btn.innerHTML = '✅ Concluído';

                    resultDiv.className = 'batch-result result-success';
                    resultDiv.innerHTML = `
                        <strong>${data.message}</strong><br>
                        Sucessos: ${data.stats.success} | Erros: ${data.stats.errors}<br>
                        ${data.stats.filename ? `<a href="/storage/export-users/${data.stats.filename}" download target="_blank" rel="noopener">📥 Arquivo gerado: ${data.stats.filename}</a>` : ''}
                    `;
                    resultDiv.style.display = 'block';
                } else {
                    throw new Error(data.error || 'Erro desconhecido');
                }
            } catch (error) {
                // Erro
                batchItem.className = 'batch-item status-error';
                batchItem.querySelector('.batch-status').innerHTML = '❌ Erro';
                btn.innerHTML = '🔄 Tentar Novamente';
                btn.disabled = false;

                resultDiv.className = 'batch-result result-error';
                resultDiv.innerHTML = `<strong>Erro:</strong> ${error.message}`;
                resultDiv.style.display = 'block';
            }
        }

        // Atualiza status dos lotes periodicamente
        @if (session('total_batches'))
            setInterval(async function() {
                try {
                    const response = await fetch('/admin/batch-status');
                    const data = await response.json();

                    // Atualiza interface com novos status se necessário
                    // (implementação opcional para sincronização em tempo real)
                } catch (error) {
                    console.log('Erro ao atualizar status:', error);
                }
            }, 5000);
        @endif
    </script>
@endpush
