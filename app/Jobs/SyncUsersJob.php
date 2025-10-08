<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Admin\GoogleSheetController;
use Illuminate\Support\Facades\Log;
use App\Services\GoogleSheetsService;

class SyncUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batchData;
    protected $batchNumber;
    protected $totalBatches;

    /**
     * Timeout do job em segundos (20 minutos)
     */
    public $timeout = 1200;

    /**
     * Número máximo de tentativas
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct($batchData, $batchNumber, $totalBatches)
    {
        $this->batchData = $batchData;
        $this->batchNumber = $batchNumber;
        $this->totalBatches = $totalBatches;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Log::info("Iniciando processamento do lote {$this->batchNumber}/{$this->totalBatches}");
            
            $sheetService = new GoogleSheetsService();
            $controller = new GoogleSheetController($sheetService);
            $results = $controller->processBatchUsers($this->batchData, $this->batchNumber);
            
            Log::info("Lote {$this->batchNumber}/{$this->totalBatches} processado com sucesso", $results);
            
        } catch (\Exception $e) {
            Log::error("Erro no processamento do lote {$this->batchNumber}/{$this->totalBatches}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error("Job de sincronização falhou para o lote {$this->batchNumber}/{$this->totalBatches}: " . $exception->getMessage());
    }
}