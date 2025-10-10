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

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
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
        'active'
    ];

    protected $casts = [
        'data_mkt' => 'date',
        'data_trade' => 'date',
        'data_cliente' => 'date',
        'data_dtc' => 'date',
        'flag_calendario' => 'boolean',
        'active' => 'boolean'
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
            $color = $this->colors()->create([
                'color_name' => $name,
                'color_description' => $colorData['descriptions'][$index] ?? null,
                'color_code' => $colorData['codes'][$index] ?? null,
                'collection_id' => $colorData['collections'][$index] ?? null,
                'flag_product_id' => $colorData['flags'][$index] ?? null,
                'numeracao_id' => $colorData['numeracao_ids'][$index] ?? null,
                'is_new' => false,
                'active' => true,
            ]);

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
                'link_url' => $caracteristicaData['link_url'][$index] ?? null,
                'product_id' => $this->id,
            ]);
        }
    }

    public function syncColors(array $colorData): void
    {
        $this->colors()->delete();

        foreach ($colorData['names'] as $index => $name) {
            $color = $this->colors()->create([
                'color_name' => $name,
                'color_description' => $colorData['descriptions'][$index] ?? null,
                'color_code' => $colorData['codes'][$index] ?? null,
                'collection_id' => $colorData['collections'][$index] ?? null,
                'flag_product_id' => $colorData['flags'][$index] ?? null,
                'numeracao_id' => $colorData['numeracao_ids'][$index] ?? null,
                'is_new' => false,
                'active' => true,
            ]);

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
}
