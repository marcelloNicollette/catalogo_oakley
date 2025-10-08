<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\ProductImage;

class SyncProductImages extends Command
{
    protected $signature = 'product-images:sync-folder {--chunk=500 : Processar em lotes de N arquivos}';
    protected $description = 'Normaliza nome (MAIÚSCULAS) e extensão (minúsculas) e sincroniza imagens de public/images/produtos para a tabela product_images';

    public function handle(): int
    {
        $diskPath = public_path('images/produtos');
        if (!File::exists($diskPath)) {
            $this->error('Pasta public/images/produtos não encontrada.');
            return Command::FAILURE;
        }

        $files = File::files($diskPath);
        $total = count($files);
        if ($total === 0) {
            $this->info('Nenhum arquivo encontrado. Nada a sincronizar.');
            return Command::SUCCESS;
        }

        $chunkSize = (int) $this->option('chunk') ?: 500;
        $chunks = array_chunk($files, $chunkSize);
        $processed = 0;

        foreach ($chunks as $i => $chunk) {
            foreach ($chunk as $f) {
                $originalName = $f->getFilename();
                $namePart = pathinfo($originalName, PATHINFO_FILENAME);
                $extPart = pathinfo($originalName, PATHINFO_EXTENSION);
                $upperNamePart = strtoupper($namePart);
                $lowerExtPart = $extPart !== '' ? strtolower($extPart) : '';
                $normalizedName = $upperNamePart . ($lowerExtPart !== '' ? ('.' . $lowerExtPart) : '');

                $originalPathAbs = public_path('images/produtos/' . $originalName);
                $targetPathAbs = public_path('images/produtos/' . $normalizedName);

                // Renomeia fisicamente para Nome MAIÚSCULO + Extensão minúscula quando necessário
                if ($normalizedName !== $originalName) {
                    try {
                        if (!File::exists($targetPathAbs)) {
                            // Tenta mover diretamente
                            if (File::exists($originalPathAbs)) {
                                File::move($originalPathAbs, $targetPathAbs);
                                $this->line("Renomeado: {$originalName} -> {$normalizedName}");
                            }
                        } else {
                            // Se já existe o arquivo normalizado, removemos o duplicado (diferença só de case)
                            if ($originalPathAbs !== $targetPathAbs && File::exists($originalPathAbs)) {
                                File::delete($originalPathAbs);
                                $this->warn("Arquivo duplicado por case removido: {$originalName}; mantido: {$normalizedName}");
                            }
                        }
                    } catch (\Exception $e) {
                        // Tentativa em duas etapas para sistemas case-insensitive
                        try {
                            $tempName = uniqid('TMP_', true) . '_' . $normalizedName;
                            $tempPathAbs = public_path('images/produtos/' . $tempName);
                            if (File::exists($originalPathAbs)) {
                                File::move($originalPathAbs, $tempPathAbs);
                                File::move($tempPathAbs, $targetPathAbs);
                                $this->line("Renomeado (2 passos): {$originalName} -> {$normalizedName}");
                            }
                        } catch (\Exception $e2) {
                            $this->error("Falha ao renomear {$originalName} para {$normalizedName}: " . $e2->getMessage());
                        }
                    }
                }

                // Determina caminho final existente no disco
                $finalPathAbs = null;
                if (File::exists($targetPathAbs)) {
                    $finalPathAbs = $targetPathAbs;
                } elseif (File::exists($originalPathAbs)) {
                    $finalPathAbs = $originalPathAbs;
                }

                // Se não há arquivo disponível, avisa e pula
                if (!$finalPathAbs) {
                    $this->warn("Arquivo não encontrado após normalização: {$originalName}. Pulando registro.");
                    continue;
                }

                // Usa o nome final normalizado para persistência
                $finalName = basename($finalPathAbs);
                $finalPathRel = 'images/produtos/' . $finalName;

                // Coleta metadados do arquivo final
                $size = File::size($finalPathAbs);
                $mime = File::mimeType($finalPathAbs);

                ProductImage::updateOrCreate(
                    ['filename' => $finalName],
                    [
                        'path' => $finalPathRel,
                        'size' => $size,
                        'mime' => $mime,
                    ]
                );
                $processed++;
            }
            $this->info("Lote " . ($i + 1) . "/" . count($chunks) . " processado. Total até agora: $processed");
        }

        $this->info("Sincronização concluída. Total de arquivos processados: $processed");
        return Command::SUCCESS;
    }
}