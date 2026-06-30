<?php

namespace App\Models;

use App\Events\ProductCaracteristicasSynced;
use App\Events\ProductColorsSynced;
use App\Events\ProductLinksSynced;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Size;
use App\Models\Numeracao;
use App\Models\MeasureCategory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'linha',
        'slug',
        'code',
        'sku',
        'price',
        'category_id',
        'subcategory_id',
        'technologies',
        'flag_calendario',
        'data_mkt',
        'data_trade',
        'data_cliente',
        'data_dtc',
        'active',
        'order'
    ];

    protected $casts = [
        'data_mkt' => 'date',
        'data_trade' => 'date',
        'data_cliente' => 'date',
        'data_dtc' => 'date',
        'flag_calendario' => 'boolean',
        'active' => 'boolean',
        'order' => 'integer'
    ];


    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->with('segmentacao');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function colors()
    {
        return $this->hasMany(Color::class, 'product_id')->with(['collection', 'flagProduct', 'segmentacoesCliente']);
    }

    public function caracteristicas()
    {
        return $this->hasMany(CaracteristicaProduct::class, 'product_id')->where('destaque', 0);
    }

    public function caracteristicasDestaque()
    {
        return $this->hasMany(CaracteristicaProduct::class, 'product_id')->where('destaque', 1);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')->withPivot('stock')->withTimestamps();
    }

    public function numeracoes()
    {
        return $this->belongsToMany(Numeracao::class, 'product_numeracao')->withPivot('stock')->withTimestamps();
    }

    public function measureCategories()
    {
        return $this->belongsToMany(MeasureCategory::class, 'product_measure_categories')->withTimestamps();
    }

    public function calendario()
    {
        return $this->hasOne(Calendario::class);
    }

    public function links()
    {
        return $this->hasMany(LinksProduct::class, 'product_id');
    }

    public function getTechnologyItemsAttribute()
    {
        $ids = json_decode($this->technologies, true);

        // Verificar se $ids é um array válido e não está vazio
        if (!is_array($ids) || empty($ids)) {
            return collect(); // Retorna uma coleção vazia
        }

        return TechnologyItem::whereIn('id', $ids)->get();
    }


    public function addColors(array $colorData): void
    {
        foreach ($colorData['names'] as $index => $name) {
            $flagIdsRaw = $colorData['flag_ids'][$index] ?? null;
            if ($flagIdsRaw === null) {
                $flagIdsRaw = $colorData['flags'][$index] ?? null;
            }

            if (is_array($flagIdsRaw)) {
                $flagIds = array_values(array_filter($flagIdsRaw, function ($id) {
                    return !empty($id);
                }));
            } else {
                $flagIds = !empty($flagIdsRaw) ? [$flagIdsRaw] : [];
            }

            $primaryFlagId = $flagIds[0] ?? null;

            $periodoVendas = $colorData['periodo_vendas'][$index] ?? [];
            if (!is_array($periodoVendas)) {
                $periodoVendas = !empty($periodoVendas) ? [$periodoVendas] : [];
            }
            $periodoVendas = array_values(array_unique(array_filter(array_map(function ($mes) {
                $mesInt = (int) $mes;
                return ($mesInt >= 1 && $mesInt <= 12) ? $mesInt : null;
            }, $periodoVendas))));
            sort($periodoVendas);

            $color = $this->colors()->create([
                'color_name' => $name,
                'color_description' => $colorData['descriptions'][$index] ?? null,
                'color_code' => $colorData['codes'][$index] ?? null,
                'genero' => $colorData['generos'][$index] ?? 'Masculino',
                'collection_id' => $colorData['collections'][$index] ?? null,
                'flag_product_id' => $primaryFlagId,
                'numeracao_id' => $colorData['numeracao_ids'][$index] ?? null,
                'periodo_vendas' => $periodoVendas,
                'data_mkt' => $this->normalizeColorLaunchDate($colorData['data_mkt'][$index] ?? null),
                'data_trade' => $this->normalizeColorLaunchDate($colorData['data_trade'][$index] ?? null),
                'data_cliente' => $this->normalizeColorLaunchDate($colorData['data_cliente'][$index] ?? null),
                'data_dtc' => $this->normalizeColorLaunchDate($colorData['data_dtc'][$index] ?? null),
                'is_new' => false,
                'active' => true,
            ]);

            if (!empty($flagIds) && method_exists($color, 'flagProducts')) {
                $color->flagProducts()->sync($flagIds);
            }

            $shoeGridIds = $colorData['shoe_grid_ids'][$index] ?? [];
            if (!is_array($shoeGridIds)) {
                $shoeGridIds = !empty($shoeGridIds) ? [$shoeGridIds] : [];
            }
            if (method_exists($color, 'shoeGrids')) {
                $color->shoeGrids()->sync($shoeGridIds);
            }

            // Sincronizar segmentações de cliente se fornecidas
            if (isset($colorData['segmentacoes_cliente'][$index]) && is_array($colorData['segmentacoes_cliente'][$index])) {
                $color->segmentacoesCliente()->sync($colorData['segmentacoes_cliente'][$index]);
            }
        }
    }

    public function addCaracteristicas(array $caracteristicaData): void
    {
        foreach ($caracteristicaData['titles'] as $index => $title) {
            CaracteristicaProduct::create([
                'title' => $title,
                'description' => $caracteristicaData['descriptions'][$index] ?? null,
                'destaque' => $caracteristicaData['destaques'][$index] ?? 0,
                'product_id' => $this->id,
            ]);
        }
    }

    public function addLinks(array $LinkData): void
    {
        foreach ($LinkData['link_title'] as $index => $title) {
            LinksProduct::create([
                'link_title' => $title,
                'link_url' => $LinkData['link_url'][$index] ?? null,
                'product_id' => $this->id,
                'access_levels' => $LinkData['access_levels'][$index] ?? null,
            ]);
        }
    }

    public function syncColors(array $colorData): void
    {
        $this->colors()->delete();

        foreach ($colorData['names'] as $index => $name) {
            $flagIdsRaw = $colorData['flag_ids'][$index] ?? null;
            if ($flagIdsRaw === null) {
                $flagIdsRaw = $colorData['flags'][$index] ?? null;
            }

            if (is_array($flagIdsRaw)) {
                $flagIds = array_values(array_filter($flagIdsRaw, function ($id) {
                    return !empty($id);
                }));
            } else {
                $flagIds = !empty($flagIdsRaw) ? [$flagIdsRaw] : [];
            }

            $primaryFlagId = $flagIds[0] ?? null;

            $periodoVendas = $colorData['periodo_vendas'][$index] ?? [];
            if (!is_array($periodoVendas)) {
                $periodoVendas = !empty($periodoVendas) ? [$periodoVendas] : [];
            }
            $periodoVendas = array_values(array_unique(array_filter(array_map(function ($mes) {
                $mesInt = (int) $mes;
                return ($mesInt >= 1 && $mesInt <= 12) ? $mesInt : null;
            }, $periodoVendas))));
            sort($periodoVendas);

            $color = $this->colors()->create([
                'color_name' => $name,
                'color_description' => $colorData['descriptions'][$index] ?? null,
                'color_code' => $colorData['codes'][$index] ?? null,
                'genero' => $colorData['generos'][$index] ?? 'Masculino',
                'collection_id' => $colorData['collections'][$index] ?? null,
                'flag_product_id' => $primaryFlagId,
                'numeracao_id' => $colorData['numeracao_ids'][$index] ?? null,
                'periodo_vendas' => $periodoVendas,
                'data_mkt' => $this->normalizeColorLaunchDate($colorData['data_mkt'][$index] ?? null),
                'data_trade' => $this->normalizeColorLaunchDate($colorData['data_trade'][$index] ?? null),
                'data_cliente' => $this->normalizeColorLaunchDate($colorData['data_cliente'][$index] ?? null),
                'data_dtc' => $this->normalizeColorLaunchDate($colorData['data_dtc'][$index] ?? null),
                'is_new' => false,
                'active' => true,
            ]);

            if (!empty($flagIds) && method_exists($color, 'flagProducts')) {
                $color->flagProducts()->sync($flagIds);
            }

            $shoeGridIds = $colorData['shoe_grid_ids'][$index] ?? [];
            if (!is_array($shoeGridIds)) {
                $shoeGridIds = !empty($shoeGridIds) ? [$shoeGridIds] : [];
            }
            if (method_exists($color, 'shoeGrids')) {
                $color->shoeGrids()->sync($shoeGridIds);
            }

            // Sincronizar segmentações de cliente se fornecidas
            if (isset($colorData['segmentacoes_cliente'][$index]) && is_array($colorData['segmentacoes_cliente'][$index])) {
                $color->segmentacoesCliente()->sync($colorData['segmentacoes_cliente'][$index]);
            }
        }

        ProductColorsSynced::dispatch($this);
    }

    public function syncCaracteristicas(array $caracteristicaData): void
    {
        CaracteristicaProduct::where('product_id', $this->id)->delete();

        foreach ($caracteristicaData['titles'] as $index => $title) {
            CaracteristicaProduct::create([
                'title' => $title,
                'description' => $caracteristicaData['descriptions'][$index] ?? null,
                'destaque' => $caracteristicaData['destaques'][$index] ?? 0,
                'product_id' => $this->id,
            ]);
        }

        ProductCaracteristicasSynced::dispatch($this);
    }

    public function syncLinks(array $linksData): void
    {
        LinksProduct::where('product_id', $this->id)->delete();

        foreach ($linksData['link_title'] as $index => $title) {
            LinksProduct::create([
                'link_title' => $title,
                'link_url' => $linksData['link_url'][$index] ?? null,
                'product_id' => $this->id,
                'access_levels' => $linksData['access_levels'][$index] ?? null,
            ]);
        }

        ProductLinksSynced::dispatch($this);
    }

    public function addSizes(array $sizeData): void
    {
        $sizesToSync = [];

        foreach ($sizeData['size_ids'] as $index => $sizeId) {
            $sizesToSync[$sizeId] = ['stock' => $sizeData['stocks'][$index] ?? 0];
        }

        $this->sizes()->attach($sizesToSync);
    }

    public function syncSizes(array $sizeData): void
    {
        $sizesToSync = [];

        foreach ($sizeData['size_ids'] as $index => $sizeId) {
            $sizesToSync[$sizeId] = ['stock' => $sizeData['stocks'][$index] ?? 0];
        }

        $this->sizes()->sync($sizesToSync);
    }

    public function addNumeracoes(array $numeracaoData): void
    {
        $numeracoesToSync = [];

        foreach ($numeracaoData['numeracao_ids'] as $index => $numeracaoId) {
            $numeracoesToSync[$numeracaoId] = ['stock' => $numeracaoData['stocks'][$index] ?? 0];
        }

        $this->numeracoes()->attach($numeracoesToSync);
    }

    public function syncNumeracoes(array $numeracaoData): void
    {
        $numeracoesToSync = [];

        foreach ($numeracaoData['numeracao_ids'] as $index => $numeracaoId) {
            $numeracoesToSync[$numeracaoId] = ['stock' => $numeracaoData['stocks'][$index] ?? 0];
        }

        $this->numeracoes()->sync($numeracoesToSync);
    }

    private function normalizeColorLaunchDate($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $text = trim((string) $value);

        return $text === '' ? null : $text;
    }
}
