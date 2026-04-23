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
use App\Models\SegmentacaoCliente;
use App\Models\Subcategory;
use App\Models\TechnologyCategory;
use App\Models\TechnologyItem;
use App\Models\User;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.sync.sync-produtos');
    }
    /**
     * Exibe a página de sincronização
     */
    public function indexRepresentantes()
    {
        return view('admin.sync.sync-representantes');
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
            $headerRange = "UA-Catalogo!A2:AN";
            $headerRows = $this->sheetService->readSheet($spreadsheetId, $headerRange);

            if (empty($headerRows) || empty($headerRows[0])) {
                throw new \Exception('Não foi possível ler os cabeçalhos da planilha.');
            }

            $headers = $headerRows[0];

            // Lê os dados da planilha
            $dataRange = "UA-Catalogo!A4:AN";
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
                        'description' => $productData['COR_DESCRIÇÃO'] ?? $productData['COR_COD'],
                        'genero' => $productData['GENERO'],
                        'flag' => $productData['COR_CLASSIFICAÇÃO'],
                        'collection' => $this->findOrCreateCollection($productData['COLEÇÃO'] ?? '', $productData['COLEÇÃO_SECUNDÁRIA'] ?? ''),
                        // Tenta obter numeração da cor a partir de possíveis cabeçalhos
                        'numeracao' => $this->extractColorNumeracao($productData)
                    ];
                }

                $groupedProducts[$sku]['row_indexes'][] = $rowIndex + 4;
            }

            // Processa cada produto único com todas suas cores
            $orderIndex = 1;
            foreach ($groupedProducts as $sku => $productGroup) {
                try {
                    // Sincroniza o produto com todas as cores coletadas e define ordem sequencial
                    $this->syncProductWithColors($productGroup['data'], $productGroup['colors'], $orderIndex);
                    $orderIndex++;
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
        return $this->syncProductWithColors($data, [], null);
    }

    /**
     * Sincroniza um produto com suas cores agrupadas
     */
    private function syncProductWithColors($data, $colors, $desiredOrder = null)
    {

        $segmentacao = $this->findOrCreateSegmentacao($data['PRODUTOS_SEGMENTO'] ?? '');

        // Busca ou cria categoria
        $category = $this->findOrCreateCategory($data['CATEGORIA'] ?? '', $segmentacao);
        $subcategory = $this->findOrCreateSubcategory($data['FAIXA GTM'] ?? '', $category->id ?? null);
        $collection = $this->findOrCreateCollection($data['COLEÇÃO'] ?? '', $data['COLEÇÃO_SECUNDÁRIA'] ?? '');
        $flag = $this->findOrCreateFlag($data['COR_CLASSIFICAÇÃO'] ?? '');
        $tecnologia = $this->findOrCreateTecnologia($data['TECNOLOGIAS'] ?? '');

        // Prepara dados do produto
        $productData = [
            'name' => $data['NOME'],
            'description' => $data['DESCRIÇÃO'] ?? '',
            'linha' => ($data['LINHA'] != '-' && $data['LINHA'] !== '') ? $data['LINHA'] : null,
            'silhueta' => (isset($data['SILHUETA']) && $data['SILHUETA'] != '-' && $data['SILHUETA'] !== '') ? $data['SILHUETA'] : null,
            'code' => $data['CÓDIGO'],
            'sku' => $data['CÓDIGO'], // Usando CÓDIGO como SKU
            'price' =>  (float) str_replace(',', '.', $data['PDV']) ?? 0, // Preço não está na planilha atual
            'slug' => Str::slug($data['NOME']) . '-' . $data['CÓDIGO'],
            'category_id' => $category->id ?? null,
            'subcategory_id' => $subcategory->id ?? null,
            'genero' => $data['GENERO'],
            'active' => true,
            'technologies' => json_encode($tecnologia),
            'flag_calendario' => !empty($data['LANÇAMENTO']) || !empty($data['LANÇAMENTO_DTC']) || !empty($data['LANÇAMENTO_TRADE']) || !empty($data['LANÇAMENTO_CLIENTE']),
            'data_mkt' => $this->parseDate($data['LANÇAMENTO'] ?? ''),
            'data_trade' => $this->parseDate($data['LANÇAMENTO_TRADE'] ?? ''),
            'data_cliente' => $this->parseDate($data['LANÇAMENTO_CLIENTE'] ?? ''),
            'data_dtc' => $this->parseDate($data['LANÇAMENTO_DTC'] ?? ''),
        ];
        //dd($productData);
        // Cria ou atualiza o produto
        $product = Product::updateOrCreate(
            ['sku' => $data['CÓDIGO']],
            $productData
        );

        // Define ordem do produto conforme a posição na planilha, resolvendo conflitos
        if (!is_null($desiredOrder)) {
            $newOrder = (int) $desiredOrder;

            DB::transaction(function () use ($product, $newOrder) {
                $hasConflict = Product::whereNull('deleted_at')
                    ->where('id', '!=', $product->id)
                    ->where('order', $newOrder)
                    ->exists();

                if ($hasConflict) {
                    Product::whereNull('deleted_at')
                        ->where('id', '!=', $product->id)
                        ->where('order', '>=', $newOrder)
                        ->increment('order');
                }

                $product->order = $newOrder;
                $product->save();
            });
        }

        // Sincroniza cores agrupadas
        $this->syncColorsGrouped($product, $colors, $collection, $flag, $data);

        // Sincroniza tecnologias
        //$this->syncTecnologias($product, $tecnologia);

        // Sincroniza características
        $this->syncCharacteristics($product, $data);

        // Sincroniza numerações
        //$this->syncNumeracoes($product, $data);

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
        // Ícone padrão para tecnologias sem imagem
        $defaultIcon = 'images/technology/1759344921.png';

        // Normaliza e separa os nomes das tecnologias (remove entradas vazias)
        $tec = array_filter(array_map(function ($t) {
            return trim($t);
        }, explode(',', $tecnologias)), function ($t) {
            return $t !== '';
        });

        $array_id_tec = [];
        foreach ($tec as $name) {
            // Busca por tecnologia existente apenas pelo nome, para evitar duplicidade
            // Busca todos os itens com o mesmo nome para tratar duplicidades
            $itemsSameName = TechnologyItem::where('name', $name)
                ->orderBy('created_at', 'asc')
                ->get();

            if ($itemsSameName->isNotEmpty()) {
                // Prioriza manter o mais antigo que possua ícone diferente do padrão
                $nonDefaultItems = $itemsSameName->filter(function ($ti) use ($defaultIcon) {
                    return !empty($ti->icon) && $ti->icon !== $defaultIcon;
                })->values();

                $keeper = $nonDefaultItems->first() ?: $itemsSameName->first();

                // Se o item escolhido não tiver ícone, define o padrão
                if (empty($keeper->icon)) {
                    $keeper->icon = $defaultIcon;
                    $keeper->save();
                }

                // Exclui (soft delete) os demais itens duplicados
                foreach ($itemsSameName as $ti) {
                    if ($ti->id !== $keeper->id) {
                        $ti->delete();
                    }
                }

                $array_id_tec[] = $keeper->id;
            } else {
                // Não existe: cria com categoria padrão, descrição igual ao nome e ícone padrão
                $created = TechnologyItem::create([
                    'technology_category_id' => 1,
                    'name' => $name,
                    'description' => $name,
                    'icon' => $defaultIcon,
                    'active' => true,
                ]);
                $array_id_tec[] = $created->id;
            }
        }

        // Evita IDs duplicados caso a lista tenha tecnologias repetidas
        return array_values(array_unique($array_id_tec));
    }

    /**
     * Busca ou cria uma subcategoria
     */
    private function findOrCreateSubcategory($subcategoryName, $categoryId)
    {
        if (empty($subcategoryName) || empty($categoryId)) {
            return null;
        }

        return Subcategory::firstOrCreate(
            ['faixa' => $subcategoryName, 'category_id' => $categoryId],
            [
                'slug' => Str::slug($subcategoryName),
                'active' => true
            ]
        );
    }

    /**
     * Busca ou cria uma coleção
     */
    private function findOrCreateCollection($collectionName, $collectionSecondaryName)
    {
        // Normaliza strings
        $collectionName = trim((string) $collectionName);
        $collectionSecondaryName = trim((string) $collectionSecondaryName);

        if ($collectionName === '') {
            return null;
        }

        // Monta o slug considerando nome + secundária quando existir
        if ($collectionSecondaryName === '') {
            // Coleção sem secundária → sempre mesmo slug
            $slug = Str::slug($collectionName);
        } else {
            // Coleção com secundária → par (nome, secundária) diferencia
            $slug = Str::slug($collectionName . '-' . $collectionSecondaryName);
        }

        $codigoColecao = $collectionSecondaryName === ''
            ? $collectionName
            : ($collectionName . '-' . $collectionSecondaryName);

        $collection = Collection::withTrashed()->firstOrNew(['slug' => $slug]);

        if ($collection->exists && $collection->trashed()) {
            $collection->restore();
        }

        $collection->fill([
            'name' => $collectionName,
            'description' => $collectionSecondaryName,
            'codigo_colecao' => $codigoColecao,
            'active' => true,
        ]);

        $collection->save();

        return $collection;
    }

    /**
     * Busca ou cria uma flag
     */
    private function findOrCreateFlag($flagName)
    {
        if (empty($flagName)) {
            return null;
        }
        // Busca todos os itens com o mesmo título de flag
        $flagsSameTitle = FlagProduct::where('flag_title', $flagName)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($flagsSameTitle->isEmpty()) {
            // Nenhum existente: cria novo e retorna
            return FlagProduct::create([
                'flag_title' => $flagName,
                'flag_description' => $flagName,
                'flag_bg' => '#000000',
                'flag_color_text_bg' => '#ffffff',
                'alinhamento' => 'left',
                'status' => true,
            ]);
        }

        if ($flagsSameTitle->count() === 1) {
            // Apenas um: garante os campos e retorna
            $flag = $flagsSameTitle->first();
            $flag->update([
                'flag_description' => $flagName,
                'flag_bg' => '#000000',
                'flag_color_text_bg' => '#ffffff',
                'alinhamento' => 'left',
                'status' => true,
            ]);
            return $flag;
        }

        // Mais de um: cria um novo com os valores desejados e exclui os duplicados
        $created = FlagProduct::create([
            'flag_title' => $flagName,
            'flag_description' => $flagName,
            'flag_bg' => '#000000',
            'flag_color_text_bg' => '#ffffff',
            'alinhamento' => 'left',
            'status' => true,
        ]);

        foreach ($flagsSameTitle as $flag) {
            // Exclui (soft delete) todos os anteriores
            $flag->delete();
        }

        // Usa o item criado
        return $created;
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

        $this->syncColorsGrouped($product, $colors, $collection, $flag, $data);
    }

    /**
     * Sincroniza cores agrupadas do produto
     */
    private function syncColorsGrouped($product, $colors, $collection, $flag, $data)
    {

        // Remove cores existentes (hasMany relationship)
        //Color::where('product_id', $product->id)->delete();

        // Se não há cores, não faz nada
        if (empty($colors)) {
            return;
        }

        // Remove duplicatas baseadas no código da cor
        $uniqueColors = [];
        foreach ($colors as $color) {
            $uniqueColors[$color['code']] = $color;
        }

        // Processa segmentações de cliente da coluna CLIENTE_SEGMENTO
        $segmentacoesCliente = $this->processClienteSegmento($data['CLIENTE_SEGMENTO'] ?? '');

        // Log para debug das cores sincronizadas
        Log::info("Cores sincronizadas para produto {$product->sku}", [
            'product_id' => $product->id,
            'cores_count' => count($uniqueColors),
            'cores' => array_values($uniqueColors),
            'segmentacoes_cliente' => $segmentacoesCliente,
            'flag' => $flag
        ]);
        // Cria as cores encontradas no banco de dados usando findOrCreate
        foreach ($uniqueColors as $cor) {
            $flag_id = $this->findOrCreateFlag($cor['flag']);

            // Mapeia numeração por cor, se fornecida na planilha
            $numeracaoId = null;
            if (!empty($cor['numeracao'])) {
                $numeracaoId = $this->findOrCreateNumeracaoId($cor['numeracao']);
                // Passa o numeracao_id para a criação/atualização da cor
                $cor['numeracao_id'] = $numeracaoId;
            }

            $colorModel = $this->findOrCreateColor($product, $cor, $collection, $flag_id->id);

            // Sincroniza segmentações de cliente para esta cor
            if (!empty($segmentacoesCliente)) {
                $colorModel->segmentacoesCliente()->sync($segmentacoesCliente);
            } else {
                // Se não há segmentações informadas, remove quaisquer vínculos existentes
                $colorModel->segmentacoesCliente()->detach();
            }
        }
    }

    /**
     * Busca ou cria uma cor para o produto
     */
    private function findOrCreateColor($product, $corData, $collection, $flag)
    {

        return Color::updateOrCreate(
            [
                'color_code' => $corData['code'],
                'product_id' => $product->id
            ],
            [
                'color_name' => $corData['code'],
                'color_description' => $corData['description'],
                'genero' => ($corData['genero'] != '') ? $corData['genero'] : 'UNISSEX',
                'collection_id' => $collection->id ?? null,
                'flag_product_id' => $flag ?? null,
                'numeracao_id' => $corData['numeracao_id'] ?? null,
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
            'peso_2_ref' => $data['PESO_2_REF'] ?? '',
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
            preg_split('/,\s*/', $numeracaoData),
            preg_split('/,\s*/', $tamanhosData)
        );

        foreach ($allSizes as $numero) {
            $numero = trim($numero);
            if (!empty($numero) && $numero !== '-') {
                $numeracao = Numeracao::updateOrCreate(
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
            if (!empty($linkData['url']) && $linkData['url'] !== '-') {
                LinksProduct::create([
                    'product_id' => $product->id,
                    'link_url' => $linkData['url'],
                    'link_title' => $linkData['description'],
                    'access_levels' => null,
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
        if ($product->flag_calendario && $product->flag_calendario != '-') {
            // Trunca a descrição para evitar erro de dados muito longos
            $info2 = (string) ($product->description ?? '');
            if (mb_strlen($info2, 'UTF-8') > 255) {
                $info2 = mb_substr($info2, 0, 252, 'UTF-8') . '...';
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

    /**
     * Processa a coluna CLIENTE_SEGMENTO e retorna array de IDs das segmentações
     */
    private function processClienteSegmento($clienteSegmentoString)
    {
        if (empty($clienteSegmentoString)) {
            return [];
        }

        // Separa os valores por vírgula
        $segmentos = explode(',', $clienteSegmentoString);
        $segmentacaoIds = [];

        foreach ($segmentos as $segmento) {
            $segmento = trim($segmento);

            if (!empty($segmento) && $segmento !== '-') {
                // Usa o slug como chave única para evitar duplicidades
                $slug = Str::slug($segmento);
                $segmentacaoCliente = SegmentacaoCliente::withTrashed()->updateOrCreate(
                    ['slug' => $slug],
                    [
                        'nome' => $segmento,
                        'descricao' => 'Segmentação criada automaticamente via sincronização',
                        'active' => true,
                        'deleted_at' => null
                    ]
                );
                // Restaura explicitamente se estava deletado
                if ($segmentacaoCliente->trashed()) {
                    $segmentacaoCliente->restore();
                }
                $segmentacaoIds[] = $segmentacaoCliente->id;
            }
        }

        return $segmentacaoIds;
    }

    /**
     * Extrai o valor de numeração por cor a partir de possíveis cabeçalhos da linha da planilha
     */
    private function extractColorNumeracao(array $row): ?string
    {
        // Lista de chaves possíveis que podem representar numeração por cor
        $possibleKeys = [
            'NUMERAÇÃO',
            'TAMANHOS'
        ];

        foreach ($possibleKeys as $key) {
            if (array_key_exists($key, $row)) {
                $value = trim((string)($row[$key] ?? ''));
                if ($value !== '' && $value !== '-') {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * Busca ou cria uma numeração e retorna seu ID
     */
    private function findOrCreateNumeracaoId(?string $numeracaoString): ?int
    {
        if ($numeracaoString === null) {
            return null;
        }

        $numero = trim($numeracaoString);
        if ($numero === '' || $numero === '-') {
            return null;
        }

        $numeracao = Numeracao::updateOrCreate(
            ['numero' => $numero],
            ['active' => true]
        );

        return $numeracao->id;
    }

    /**
     * Sincroniza usuários/representantes da planilha
     */
    public function syncUsers()
    {
        // Aumentar o tempo limite de execução para 10 minutos
        set_time_limit(600);

        // Aumentar o limite de memória
        ini_set('memory_limit', '512M');

        $spreadsheetId = "1skMcMlapMDLis7oZCz2dyRzFPMBfEmDoMLzYqqIInkU";
        $syncResults = [
            'success' => 0,
            'errors' => 0,
            'skipped' => 0,
            'messages' => [],
            'created_users' => [] // Para armazenar usuários criados com senhas
        ];

        try {
            // Lê os dados da aba REPRESENTANTES
            $dataRange = "REPRESENTANTES!A2:F";
            $rows = $this->sheetService->readSheet($spreadsheetId, $dataRange);

            if (empty($rows)) {
                throw new \Exception('Nenhum dado encontrado na aba REPRESENTANTES.');
            }

            $batchSize = 100; // Processar em lotes de 100
            $totalRows = count($rows);
            $processedRows = 0;

            // Processar em lotes para evitar timeout
            for ($batch = 0; $batch < $totalRows; $batch += $batchSize) {
                $endBatch = min($batch + $batchSize - 1, $totalRows - 1);

                DB::beginTransaction();

                try {
                    for ($rowIndex = $batch; $rowIndex <= $endBatch; $rowIndex++) {
                        $row = $rows[$rowIndex];

                        // Mapeia os dados conforme especificado
                        $userData = [
                            'representante_nome' => $row[0] ?? '', // Coluna A
                            'lider_ebm_comercial' => $row[1] ?? '', // Coluna B
                            'nome_fantasia_ebm' => $row[2] ?? '', // Coluna C
                            'email' => $row[4] ?? '', // Coluna E
                            'segmentacao_cliente' => $row[5] ?? '' // Coluna F
                        ];

                        // Pula linhas vazias ou sem dados essenciais
                        if (empty($userData['representante_nome']) || empty($userData['email'])) {
                            $syncResults['skipped']++;
                            $syncResults['messages'][] = "Linha " . ($rowIndex + 2) . " ignorada: Nome do representante ou email vazio";
                            continue;
                        }

                        try {
                            $result = $this->syncUserWithSegmentacao($userData);
                            if ($result['created']) {
                                $syncResults['created_users'][] = [
                                    'name' => $result['user']->name,
                                    'email' => $result['user']->email,
                                    'password' => $result['password']
                                ];
                            }
                            $syncResults['success']++;
                            $processedRows++;
                        } catch (\Exception $e) {
                            $syncResults['errors']++;
                            $syncResults['messages'][] = "Erro no usuário {$userData['representante_nome']} (linha " . ($rowIndex + 2) . "): " . $e->getMessage();
                            Log::error("Erro ao sincronizar usuário {$userData['representante_nome']}", [
                                'error' => $e->getMessage(),
                                'data' => $userData
                            ]);
                        }
                    }

                    DB::commit();

                    // Log do progresso
                    Log::info("Lote processado: {$processedRows}/{$totalRows} usuários");
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }

            // Gera arquivo Excel com usuários criados e suas senhas
            if (!empty($syncResults['created_users'])) {
                $this->generateUsersPasswordsFile($syncResults['created_users']);
            }

            $message = "Sincronização de usuários concluída! Sucessos: {$syncResults['success']}, Erros: {$syncResults['errors']}, Ignorados: {$syncResults['skipped']}";

            if (!empty($syncResults['created_users'])) {
                $message .= "\n\nForam criados " . count($syncResults['created_users']) . " novos usuários. Arquivo com senhas gerado em storage/app/users_passwords.xlsx";
            }

            if (!empty($syncResults['messages'])) {
                $message .= "\n\nDetalhes dos erros:\n" . implode("\n", $syncResults['messages']);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollback();
            }
            Log::error('Erro geral na sincronização de usuários', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro na sincronização de usuários: ' . $e->getMessage());
        }
    }

    /**
     * Sincroniza um usuário individual com suas segmentações
     */
    private function syncUserWithSegmentacao($data)
    {
        $password = null;
        $created = false;

        // Verifica se o usuário já existe
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            // Gera senha aleatória para novos usuários
            $password = $this->generateRandomPassword();

            // Cria novo usuário com hash mais rápido
            $user = User::create([
                'name' => $data['representante_nome'],
                'email' => $data['email'],
                'password' => Hash::make($password, ['rounds' => 4]), // Reduz custo do hash
                'type' => 'user', // Tipo padrão para representantes
                'company' => $data['nome_fantasia_ebm'],
                'codigo_lider_comercial' => $data['lider_ebm_comercial']
            ]);

            $created = true;
        } else {
            // Atualiza dados do usuário existente
            $user->update([
                'name' => $data['representante_nome'],
                'company' => $data['nome_fantasia_ebm'],
                'codigo_lider_comercial' => $data['lider_ebm_comercial']
            ]);
        }

        // Processa segmentações de cliente
        $segmentacaoIds = $this->processClienteSegmentoForUser($data['segmentacao_cliente']);

        // Sincroniza segmentações de cliente
        if (!empty($segmentacaoIds)) {
            $user->segmentacoesCliente()->sync($segmentacaoIds);
        }

        return [
            'user' => $user,
            'password' => $password,
            'created' => $created
        ];
    }

    /**
     * Processa segmentações de cliente para usuários
     */
    private function processClienteSegmentoForUser($segmentacaoString)
    {
        if (empty($segmentacaoString)) {
            return [];
        }

        // Separa os valores por vírgula
        $segmentos = explode(',', $segmentacaoString);
        $segmentacaoIds = [];

        foreach ($segmentos as $segmento) {
            $segmento = trim($segmento);

            if (!empty($segmento)) {
                // Busca ou cria a segmentação de cliente
                $segmentacaoCliente = SegmentacaoCliente::firstOrCreate(
                    ['nome' => $segmento],
                    [
                        'descricao' => 'Segmentação criada automaticamente via sincronização de usuários',
                        'slug' => Str::slug($segmento),
                        'active' => true
                    ]
                );

                $segmentacaoIds[] = $segmentacaoCliente->id;
            }
        }

        return $segmentacaoIds;
    }

    /**
     * Gera uma senha aleatória de forma mais eficiente
     */
    private function generateRandomPassword($length = 8)
    {
        // Usar método mais eficiente para gerar senhas
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    /**
     * Processa um lote de usuários (usado pelos jobs assíncronos)
     */
    public function processBatchUsers($batchData, $batchNumber)
    {
        $results = [
            'success' => 0,
            'errors' => 0,
            'created_users' => [],
            'batch_number' => $batchNumber
        ];

        DB::beginTransaction();

        try {
            foreach ($batchData as $rowIndex => $userData) {
                try {
                    $result = $this->syncUserWithSegmentacao($userData);

                    if ($result['created']) {
                        $results['created_users'][] = [
                            'name' => $result['user']->name,
                            'email' => $result['user']->email,
                            'password' => $result['password']
                        ];
                    }

                    $results['success']++;
                } catch (\Exception $e) {
                    $results['errors']++;
                    Log::error("Erro ao processar usuário no lote {$batchNumber}", [
                        'error' => $e->getMessage(),
                        'data' => $userData
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $results;
    }

    /**
     * Sincronização assíncrona para grandes volumes (via jobs)
     */
    public function syncUsersAsync()
    {
        try {
            $spreadsheetId = "1skMcMlapMDLis7oZCz2dyRzFPMBfEmDoMLzYqqIInkU";
            $dataRange = "REPRESENTANTES!A2:F";
            $rows = $this->sheetService->readSheet($spreadsheetId, $dataRange);

            if (empty($rows)) {
                return redirect()->route('admin.sync')->with('error', 'Nenhum dado encontrado na aba REPRESENTANTES.');
            }

            $batchSize = 50; // Lotes menores para jobs
            $totalRows = count($rows);
            $totalBatches = ceil($totalRows / $batchSize);

            // Preparar dados em lotes
            for ($batch = 0; $batch < $totalRows; $batch += $batchSize) {
                $endBatch = min($batch + $batchSize - 1, $totalRows - 1);
                $batchData = [];

                for ($i = $batch; $i <= $endBatch; $i++) {
                    $row = $rows[$i];

                    if (count($row) < 5) continue;

                    $userData = [
                        'representante_nome' => $row[0] ?? '',
                        'lider_ebm_comercial' => $row[1] ?? '',
                        'nome_fantasia_ebm' => $row[2] ?? '',
                        'email' => $row[4] ?? '',
                        'segmentacao_cliente' => $row[5] ?? ''
                    ];

                    if (!empty($userData['email']) && filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                        $batchData[] = $userData;
                    }
                }

                if (!empty($batchData)) {
                    $batchNumber = ($batch / $batchSize) + 1;
                    \App\Jobs\SyncUsersJob::dispatch($batchData, $batchNumber, $totalBatches);
                }
            }

            $message = "Sincronização assíncrona iniciada! {$totalBatches} lotes foram enviados para processamento. ";
            $message .= "Verifique os logs para acompanhar o progresso.";

            return redirect()->route('admin.sync')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Erro na sincronização assíncrona de usuários: ' . $e->getMessage());
            return redirect()->route('admin.sync')->with('error', 'Erro na sincronização assíncrona: ' . $e->getMessage());
        }
    }

    /**
     * Gera arquivo Excel com usuários e senhas
     */
    private function generateUsersPasswordsFile($users)
    {
        $data = [];
        $data[] = ['Nome', 'Email', 'Senha']; // Cabeçalho

        foreach ($users as $user) {
            $data[] = [
                $user['name'],
                $user['email'],
                $user['password']
            ];
        }

        // Cria arquivo CSV simples (compatível com Excel)
        $filename = 'users_passwords_' . date('Y-m-d_H-i-s') . '.csv';
        $filepath = storage_path('app/' . $filename);

        $file = fopen($filepath, 'w');

        // Adiciona BOM para UTF-8
        fwrite($file, "\xEF\xBB\xBF");

        foreach ($data as $row) {
            fputcsv($file, $row, ';'); // Usa ponto e vírgula como separador
        }

        fclose($file);

        Log::info("Arquivo de senhas gerado: {$filename}");

        return $filename;
    }

    /**
     * Exporta lista de usuários com senhas (para download)
     */
    public function exportUsersWithPasswords()
    {
        // Busca todos os usuários do tipo 'user' (representantes)
        $users = User::where('type', 'user')
            ->with('segmentacoesCliente')
            ->orderBy('name')
            ->get();

        $data = [];
        $data[] = ['Nome', 'Email', 'Empresa', 'Código Líder Comercial', 'Segmentações']; // Cabeçalho

        foreach ($users as $user) {
            $segmentacoes = $user->segmentacoesCliente->pluck('nome')->implode(', ');

            $data[] = [
                $user->name,
                $user->email,
                $user->company,
                $user->codigo_lider_comercial,
                $segmentacoes
            ];
        }

        // Cria arquivo CSV
        $filename = 'representantes_' . date('Y-m-d_H-i-s') . '.csv';
        $filepath = storage_path('app/' . $filename);

        $file = fopen($filepath, 'w');

        // Adiciona BOM para UTF-8
        fwrite($file, "\xEF\xBB\xBF");

        foreach ($data as $row) {
            fputcsv($file, $row, ';');
        }

        fclose($file);

        // Retorna o arquivo para download
        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    /**
     * Prepara lotes de sincronização de usuários
     */
    public function prepareBatches()
    {
        try {
            $spreadsheetId = "1skMcMlapMDLis7oZCz2dyRzFPMBfEmDoMLzYqqIInkU";
            $representantesData = $this->sheetService->readSheet($spreadsheetId, 'REPRESENTANTES!A:Z');

            if (empty($representantesData)) {
                return redirect()->route('admin.sync')->with('error', 'Nenhum dado encontrado na aba REPRESENTANTES.');
            }

            // Remove cabeçalho
            array_shift($representantesData);

            // Divide em lotes de 1000
            $batches = array_chunk($representantesData, 1000);
            $totalBatches = count($batches);
            $totalRecords = count($representantesData);

            // Armazena informações dos lotes na sessão
            session([
                'sync_batches' => $batches,
                'total_batches' => $totalBatches,
                'total_records' => $totalRecords,
                'batch_status' => array_fill(0, $totalBatches, 'pending') // pending, processing, completed, error
            ]);

            return redirect()->route('admin.sync-representantes')->with('success', "Preparados {$totalBatches} lotes com {$totalRecords} registros. Use os botões abaixo para executar cada lote.");
        } catch (\Exception $e) {
            Log::error('Erro ao preparar lotes: ' . $e->getMessage());
            return redirect()->route('admin.sync-representantes')->with('error', 'Erro ao preparar lotes: ' . $e->getMessage());
        }
    }

    /**
     * Executa um lote específico
     */
    public function executeBatch($batchIndex)
    {
        try {
            $batches = session('sync_batches');
            $batchStatus = session('batch_status', []);
            $batchResults = session('batch_results', []);

            if (!$batches || !isset($batches[$batchIndex])) {
                return response()->json(['error' => 'Lote não encontrado'], 404);
            }

            // Marca lote como processando
            $batchStatus[$batchIndex] = 'processing';
            session(['batch_status' => $batchStatus]);

            $batchData = $batches[$batchIndex];
            $processedUsers = [];
            $errors = 0;
            $success = 0;

            // Configurações de performance
            ini_set('max_execution_time', 300); // 5 minutos
            ini_set('memory_limit', '512M');

            foreach ($batchData as $row) {
                try {
                    // Mapeia os dados conforme especificado
                    $userData = [
                        'representante_nome' => $row[0] ?? '', // Coluna A
                        'lider_ebm_comercial' => $row[1] ?? '', // Coluna B
                        'nome_fantasia_ebm' => $row[2] ?? '', // Coluna C
                        'email' => $row[4] ?? '', // Coluna E
                        'segmentacao_cliente' => $row[5] ?? '' // Coluna F
                    ];

                    // Pula linhas vazias ou sem dados essenciais
                    if (empty($userData['representante_nome']) || empty($userData['email'])) {
                        continue;
                    }

                    $result = $this->syncUserWithSegmentacao($userData);
                    if ($result) {
                        $processedUsers[] = [
                            'name' => $result['user']->name,
                            'email' => $result['user']->email,
                            'password' => $result['password']
                        ];
                        $success++;
                    }
                } catch (\Exception $e) {
                    $errors++;
                    Log::error('Erro ao processar usuário no lote ' . ($batchIndex + 1) . ': ' . $e->getMessage());
                }
            }

            // Gera arquivo de senhas para este lote
            $filename = null;
            if (!empty($processedUsers)) {
                $filename = $this->generateBatchPasswordsFile($processedUsers, $batchIndex + 1);
            }

            // Marca lote como concluído
            $batchStatus[$batchIndex] = 'completed';
            session(['batch_status' => $batchStatus]);

            // Persiste resultados do lote para exibir após recarregar a página
            $batchResults[$batchIndex] = [
                'success' => $success,
                'errors' => $errors,
                'filename' => $filename,
                'message' => "Lote " . ($batchIndex + 1) . " processado com sucesso!",
            ];
            session(['batch_results' => $batchResults]);

            Log::info("Lote " . ($batchIndex + 1) . " processado com sucesso", [
                'success' => $success,
                'errors' => $errors,
                'filename' => $filename
            ]);

            return response()->json([
                'success' => true,
                'message' => "Lote " . ($batchIndex + 1) . " processado com sucesso!",
                'stats' => [
                    'success' => $success,
                    'errors' => $errors,
                    'filename' => $filename
                ]
            ]);
        } catch (\Exception $e) {
            // Marca lote como erro
            $batchStatus = session('batch_status', []);
            $batchStatus[$batchIndex] = 'error';
            session(['batch_status' => $batchStatus]);

            Log::error('Erro ao executar lote ' . ($batchIndex + 1) . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Erro ao executar lote: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gera arquivo de senhas para um lote específico
     */
    private function generateBatchPasswordsFile($users, $batchNumber)
    {
        $data = [];
        $data[] = ['Nome', 'Email', 'Senha']; // Cabeçalho

        foreach ($users as $user) {
            $data[] = [
                $user['name'],
                $user['email'],
                $user['password']
            ];
        }

        $filename = 'lote_' . $batchNumber . '_senhas_' . date('Y-m-d_H-i-s') . '.csv';
        $dir = storage_path('app/public/export-users');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $filepath = $dir . '/' . $filename;

        $file = fopen($filepath, 'w');

        // Adiciona BOM para UTF-8
        fwrite($file, "\xEF\xBB\xBF");

        foreach ($data as $row) {
            fputcsv($file, $row, ';');
        }

        fclose($file);

        @chmod($filepath, 0644);

        return $filename;
    }

    /**
     * Limpa dados dos lotes da sessão
     */
    public function clearBatches()
    {
        session()->forget(['sync_batches', 'total_batches', 'total_records', 'batch_status', 'batch_results']);
        return redirect()->route('admin.sync-representantes')->with('success', 'Dados dos lotes limpos com sucesso.');
    }

    /**
     * Retorna status dos lotes via AJAX
     */
    public function getBatchStatus()
    {
        return response()->json([
            'total_batches' => session('total_batches', 0),
            'total_records' => session('total_records', 0),
            'batch_status' => session('batch_status', [])
        ]);
    }
}
