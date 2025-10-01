<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Color;
use App\Models\CaracteristicaProduct;
use App\Models\Numeracao;
use App\Models\LinksProduct;
use App\Models\Calendario;
use App\Models\Category;
use App\Models\Collection;
use App\Models\FlagProduct;
use App\Models\Segmentacao;
use App\Models\Subcategory;
use App\Models\TechnologyCategory;
use App\Models\TechnologyItem;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GoogleSheetController extends Controller
{
    protected $sheetService;

    public function __construct(GoogleSheetsService $sheetService)
    {
        $this->sheetService = $sheetService;
    }

    /**
     * Exibe a página de sincronização
     */
    public function index()
    {
        return view('admin.sync.sync');
    }

    public function sync()
    {
        $spreadsheetId = "1skMcMlapMDLis7oZCz2dyRzFPMBfEmDoMLzYqqIInkU";
        $syncResults = [
            'success' => 0,
            'errors' => 0,
            'skipped' => 0,
            'messages' => []
        ];

        try {
            DB::beginTransaction();

            // Lê os cabeçalhos das colunas
            $headerRange = "UA-Catalogo!A2:AM";
            $headerRows = $this->sheetService->readSheet($spreadsheetId, $headerRange);

            if (empty($headerRows) || empty($headerRows[0])) {
                throw new \Exception('Não foi possível ler os cabeçalhos da planilha.');
            }

            $headers = $headerRows[0];

            // Lê os dados da planilha
            $dataRange = "UA-Catalogo!A4:AM";
            $rows = $this->sheetService->readSheet($spreadsheetId, $dataRange);

            if (empty($rows)) {
                throw new \Exception('Nenhum dado encontrado na planilha.');
            }

            // Agrupa dados por SKU/CÓDIGO para coletar todas as cores
            $groupedProducts = [];

            foreach ($rows as $rowIndex => $row) {
                $productData = [];

                // Mapeia cada valor da linha com o nome da coluna correspondente
                for ($i = 0; $i < count($headers); $i++) {
                    $columnName = $headers[$i] != "" ? $headers[$i] : "coluna_" . ($i + 1);
                    $productData[$columnName] = $row[$i] ?? '';
                }

                // Pula linhas vazias ou sem dados essenciais
                if (empty($productData['NOME']) || empty($productData['CÓDIGO'])) {
                    $syncResults['skipped']++;
                    $syncResults['messages'][] = "Linha " . ($rowIndex + 4) . " ignorada: Nome do produto ou código vazio";
                    continue;
                }

                $sku = $productData['CÓDIGO'];

                // Se é a primeira vez que vemos este SKU, inicializa
                if (!isset($groupedProducts[$sku])) {
                    $groupedProducts[$sku] = [
                        'data' => $productData,
                        'colors' => [],
                        'row_indexes' => []
                    ];
                }

                // Adiciona a cor desta linha se existir
                if (!empty($productData['COR_COD'])) {
                    $groupedProducts[$sku]['colors'][] = [
                        'code' => $productData['COR_COD'],
                        'description' => $productData['COR_DESCRIÇÃO'] ?? $productData['COR_COD']
                    ];
                }

                $groupedProducts[$sku]['row_indexes'][] = $rowIndex + 4;
            }

            // Processa cada produto único com todas suas cores
            foreach ($groupedProducts as $sku => $productGroup) {
                try {
                    // Sincroniza o produto com todas as cores coletadas
                    $this->syncProductWithColors($productGroup['data'], $productGroup['colors']);
                    $syncResults['success']++;
                } catch (\Exception $e) {
                    $syncResults['errors']++;
                    $rowIndexes = implode(', ', $productGroup['row_indexes']);
                    $syncResults['messages'][] = "Erro no produto SKU {$sku} (linhas {$rowIndexes}): " . $e->getMessage();
                    Log::error("Erro ao sincronizar produto SKU {$sku}", [
                        'error' => $e->getMessage(),
                        'data' => $productGroup['data'],
                        'colors' => $productGroup['colors']
                    ]);
                }
            }
            //dd($productData);
            DB::commit();

            $message = "Sincronização concluída! Sucessos: {$syncResults['success']}, Erros: {$syncResults['errors']}, Ignorados: {$syncResults['skipped']}";

            if (!empty($syncResults['messages'])) {
                $message .= "\n\nDetalhes dos erros:\n" . implode("\n", $syncResults['messages']);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erro geral na sincronização', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro na sincronização: ' . $e->getMessage());
        }
    }

    /**
     * Sincroniza um produto individual com base nos dados da planilha
     */
    private function syncProduct($data)
    {
        return $this->syncProductWithColors($data, []);
    }

    /**
     * Sincroniza um produto com suas cores agrupadas
     */
    private function syncProductWithColors($data, $colors)
    {
        $segmentacao = $this->findOrCreateSegmentacao($data['PRODUTOS_SEGMENTO'] ?? '');

        // Busca ou cria categoria
        $category = $this->findOrCreateCategory($data['CATEGORIA'] ?? '', $segmentacao);
        $collection = $this->findOrCreateCollection($data['COLEÇÃO'] ?? '');
        $flag = $this->findOrCreateFlag($data['COR_CLASSIFICAÇÃO'] ?? '');
        $tecnologia = $this->findOrCreateTecnologia($data['TECNOLOGIAS'] ?? '');

        // Prepara dados do produto
        $productData = [
            'name' => $data['NOME'],
            'description' => $data['DESCRIÇÃO'] ?? '',
            'code' => $data['CÓDIGO'],
            'sku' => $data['CÓDIGO'], // Usando CÓDIGO como SKU
            'price' =>  str_replace('.', ',', $data['PDV']) ?? 0, // Preço não está na planilha atual
            'slug' => Str::slug($data['NOME']) . '-' . $data['CÓDIGO'],
            'category_id' => $category->id ?? null,
            'active' => true,
            'technologies' => json_encode($tecnologia),
            'flag_calendario' => !empty($data['LANÇAMENTO']) || !empty($data['LANÇAMENTO_DTC']) || !empty($data['LANÇAMENTO_TRADE']) || !empty($data['LANÇAMENTO_CLIENTE']),
            'data_mkt' => $this->parseDate($data['LANÇAMENTO'] ?? ''),
            'data_trade' => $this->parseDate($data['LANÇAMENTO_TRADE'] ?? ''),
            'data_cliente' => $this->parseDate($data['LANÇAMENTO_CLIENTE'] ?? ''),
            'data_dtc' => $this->parseDate($data['LANÇAMENTO_DTC'] ?? ''),
        ];

        // Cria ou atualiza o produto
        $product = Product::updateOrCreate(
            ['sku' => $data['CÓDIGO']],
            $productData
        );

        // Sincroniza cores agrupadas
        $this->syncColorsGrouped($product, $colors, $collection, $flag);

        // Sincroniza tecnologias
        //$this->syncTecnologias($product, $tecnologia);

        // Sincroniza características
        $this->syncCharacteristics($product, $data);

        // Sincroniza numerações
        $this->syncNumeracoes($product, $data);

        // Sincroniza links
        $this->syncLinks($product, $data);

        // Sincroniza calendário
        $this->syncCalendar($product, $data);

        return $product;
    }

    /**
     * Busca ou cria uma categoria
     */
    private function findOrCreateCategory($categoryName, $segmentacao)
    {
        if (empty($categoryName)) {
            return null;
        }

        return Category::firstOrCreate(
            [
                'name' => $categoryName,
                'segmento_id' => $segmentacao->id ?? null
            ],
            [
                'slug' => Str::slug($categoryName),
                'active' => true
            ]
        );
    }

    /**
     * Busca ou cria uma categoria
     */
    private function findOrCreateSegmentacao($segmentoName)
    {
        if (empty($segmentoName)) {
            return null;
        }

        return Segmentacao::firstOrCreate(
            ['segmento' => $segmentoName],
            [
                'slug' => Str::slug($segmentoName),
                'active' => true
            ]
        );
    }

    /**
     * Busca ou cria uma categoria
     */
    private function findOrCreateTecnologia($tecnologias)
    {
        if (empty($tecnologias)) {
            return null;
        }
        // Antes da linha 137
        //Log::info('Debug - Dados recebidos:', ['$tecnologias' => $tecnologias]);

        $tec = explode(',', $tecnologias);

        $array_id_tec = [];
        foreach ($tec as $item) {
            $array_id_tec[] = TechnologyItem::firstOrCreate(
                [
                    'name' => trim($item),
                    'technology_category_id' => 1,
                    'description' => trim($item)
                ]
            )->id;
        }
        return $array_id_tec;
    }



    /**
     * Busca ou cria uma coleção
     */
    private function findOrCreateCollection($collectionName)
    {
        if (empty($collectionName)) {
            return null;
        }

        return Collection::firstOrCreate(
            ['name' => $collectionName],
            [
                'slug' => Str::slug($collectionName),
                'active' => true
            ]
        );
    }

    /**
     * Busca ou cria uma flag
     */
    private function findOrCreateFlag($flagName)
    {
        if (empty($flagName)) {
            return null;
        }

        return FlagProduct::firstOrCreate(
            [
                'flag_title' => $flagName,
                'flag_description' => $flagName,
                'flag_bg' => '#000000',
                'flag_color_text_bg' => '#ffffff'
            ],
            [
                'slug' => Str::slug($flagName),
                'alinhamento' => 'left',
                'status' => true
            ]
        );
    }

    /**
     * Converte string de preço para float
     */
    private function parsePrice($priceString)
    {
        $price = preg_replace('/[^0-9,.]/', '', $priceString);
        $price = str_replace(',', '.', $price);
        return floatval($price);
    }

    /**
     * Converte string de data para Carbon ou null
     */
    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d/m/Y', $dateString);
        } catch (\Exception $e) {
            try {
                return Carbon::parse($dateString);
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    /**
     * Sincroniza cores do produto usando findOrCreate (método legado)
     */
    private function syncColors($product, $data, $collection, $flag)
    {
        // Fallback para compatibilidade - converte dados de uma linha para array
        $colors = [];
        if (!empty($data['COR_COD'])) {
            $colors[] = [
                'code' => $data['COR_COD'],
                'description' => $data['COR_DESCRIÇÃO'] ?? $data['COR_COD']
            ];
        }

        $this->syncColorsGrouped($product, $colors, $collection, $flag);
    }

    /**
     * Sincroniza cores agrupadas do produto
     */
    private function syncColorsGrouped($product, $colors, $collection, $flag)
    {
        // Remove cores existentes (hasMany relationship)
        Color::where('product_id', $product->id)->delete();

        // Se não há cores, não faz nada
        if (empty($colors)) {
            return;
        }

        // Remove duplicatas baseadas no código da cor
        $uniqueColors = [];
        foreach ($colors as $color) {
            $uniqueColors[$color['code']] = $color;
        }

        // Cria as cores encontradas no banco de dados usando findOrCreate
        foreach ($uniqueColors as $cor) {
            $this->findOrCreateColor($product, $cor, $collection, $flag);
        }

        // Log para debug das cores sincronizadas
        Log::info("Cores sincronizadas para produto {$product->sku}", [
            'product_id' => $product->id,
            'cores_count' => count($uniqueColors),
            'cores' => array_values($uniqueColors)
        ]);
    }

    /**
     * Busca ou cria uma cor para o produto
     */
    private function findOrCreateColor($product, $corData, $collection, $flag)
    {
        return Color::firstOrCreate(
            [
                'color_code' => $corData['code'],
                'product_id' => $product->id
            ],
            [
                'color_name' => $corData['code'],
                'color_description' => $corData['description'],
                'collection_id' => $collection->id ?? null,
                'flag_product_id' => $flag->id ?? null,
                'active' => true
            ]
        );
    }

    private function syncTecnologias($tecnologia)
    {
        // Remove tecnologias existentes
        TechnologyItem::where('name', $tecnologia->name)->delete();

        // Adiciona novas tecnologias baseadas nos dados da planilha
        TechnologyItem::create([
            'technology_category_id' => 1,
            'name' => $tecnologia->name ?? null,
            'active' => true
        ]);
    }

    /**
     * Sincroniza características do produto
     */
    private function syncCharacteristics($product, $data)
    {
        // Remove características existentes
        CaracteristicaProduct::where('product_id', $product->id)->delete();

        // Adiciona novas características baseadas nos dados da planilha
        $characteristics = [
            'peso_1' => $data['PESO_1'] ?? '',
            'peso_1_ref' => $data['PESO_1_REF'] ?? '',
            'peso_2' => $data['PESO_2'] ?? '',
            'drop' => $data['DROP'] ?? '',
            'origem' => $data['ORIGEM'] ?? '',
            'indicacao' => $data['INDICAÇÃO'] ?? '',
            'linha' => $data['LINHA'] ?? '',
            'composicao' => $data['COMPOSIÇÃO'] ?? '',
            //'medidas' => $data['MEDIDAS'] ?? '',
            //'tecnologias' => $data['TECNOLOGIAS'] ?? '',
            //'descricao' => $data['DESCRIÇÃO'] ?? '',
            //'informacoes' => $data['INFORMACÕES DO PRODUTO'] ?? '',
        ];

        foreach ($characteristics as $key => $value) {
            if (!empty($value)) {
                CaracteristicaProduct::create([
                    'product_id' => $product->id,
                    'title' => ucfirst(str_replace('_', ' ', $key)),
                    'description' => $value,
                    'destaque' => 0
                ]);
            }
        }
    }

    /**
     * Sincroniza numerações do produto
     */
    private function syncNumeracoes($product, $data)
    {
        // Remove numerações existentes
        $product->numeracoes()->detach();

        // Adiciona novas numerações baseadas nos dados da planilha
        $numeracaoData = $data['NUMERAÇÃO'] ?? '';
        $tamanhosData = $data['TAMANHOS'] ?? '';

        // Combina dados de numeração e tamanhos
        $allSizes = array_merge(
            explode(',', $numeracaoData),
            explode(',', $tamanhosData)
        );

        foreach ($allSizes as $numero) {
            $numero = trim($numero);
            if (!empty($numero)) {
                $numeracao = Numeracao::firstOrCreate(
                    ['numero' => $numero],
                    ['active' => true]
                );
                $product->numeracoes()->attach($numeracao->id);
            }
        }
    }

    /**
     * Sincroniza links do produto
     */
    private function syncLinks($product, $data)
    {
        // Remove links existentes
        LinksProduct::where('product_id', $product->id)->delete();

        // Adiciona novos links baseados nos dados da planilha
        $links = [
            [
                'url' => $data['LINK 1'] ?? '',
                'description' => $data['LINK 1_DESCRICAO'] ?? ''
            ],
            [
                'url' => $data['LINK 2'] ?? '',
                'description' => 'Link 2'
            ]
        ];

        foreach ($links as $linkData) {
            if (!empty($linkData['url'])) {
                LinksProduct::create([
                    'product_id' => $product->id,
                    'link_url' => $linkData['url'],
                    'link_title' => $linkData['description']
                ]);
            }
        }
    }

    /**
     * Sincroniza entrada no calendário
     */
    private function syncCalendar($product, $data)
    {
        // Remove entrada existente no calendário
        Calendario::where('product_id', $product->id)->delete();

        // Cria nova entrada se houver datas
        if ($product->flag_calendario) {
            // Trunca a descrição para evitar erro de dados muito longos
            $info2 = $product->description;
            if (strlen($info2) > 255) {
                $info2 = substr($info2, 0, 252) . '...';
            }

            Calendario::create([
                'title' => $product->name,
                'img' => '',
                'ano' => $product->data_mkt ? $product->data_mkt->year : date('Y'),
                'mes' => $product->data_mkt ? $product->data_mkt->month : date('n'),
                'info_1' => 'Lançamento',
                'info_2' => $info2,
                'data' => $product->data_mkt,
                'data_mkt' => $product->data_mkt,
                'data_trade' => $product->data_trade,
                'data_cliente' => $product->data_cliente,
                'data_dtc' => $product->data_dtc,
                'product_id' => $product->id
            ]);
        }
    }
}
