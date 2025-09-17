<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Services\GoogleSheetsService;

class GoogleSheetController extends Controller
{
    protected $sheetService;

    public function __construct(GoogleSheetsService $sheetService)
    {
        $this->sheetService = $sheetService;
    }

    public function sync()
    {
        $spreadsheetId = "1skMcMlapMDLis7oZCz2dyRzFPMBfEmDoMLzYqqIInkU";

        // Primeiro, lê os cabeçalhos das colunas (linha 1)
        $headerRange = "Página2!A2:AL";
        $headerRows = $this->sheetService->readSheet($spreadsheetId, $headerRange);
        //dd($headerRows);
        if (empty($headerRows) || empty($headerRows[0])) {
            return back()->with('error', 'Não foi possível ler os cabeçalhos da planilha.');
        }

        $headers = $headerRows[0]; // Primeira linha com os nomes das colunas

        // Agora lê os dados (a partir da linha 2)
        $dataRange = "Página2!A4:AL";
        $rows = $this->sheetService->readSheet($spreadsheetId, $dataRange);

        if (empty($rows)) {
            return back()->with('error', 'Nenhum dado encontrado na planilha.');
        }

        $products = array();
        foreach ($rows as $row) {
            $product = [];
            // Mapeia cada valor da linha com o nome da coluna correspondente
            for ($i = 0; $i < count($headers); $i++) {
                $columnName = $headers[$i] != "" ? $headers[$i] : "coluna_" . ($i + 1);
                $product[$columnName] = $row[$i] ?? '';
            }
            $products[] = $product;
        }

        dd($products);
        return back()->with('success', 'Dados sincronizados com sucesso!');
    }
}
