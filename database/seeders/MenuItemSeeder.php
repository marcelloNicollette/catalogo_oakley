<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'label' => 'Início',
                'route' => 'user.slug',
                'icon' => '/images/icones/house.svg',
                'order' => 1,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Coleções',
                'route' => 'user.slug.colecoes',
                'icon' => '/images/icones/collection.svg',
                'order' => 2,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Compartilhar',
                'route' => 'user.compartilhar',
                'icon' => '/images/icones/share.svg',
                'order' => 3,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Download',
                'route' => 'user.gerar-arquivo',
                'icon' => '/images/icones/download.svg',
                'order' => 4,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Favoritos',
                'route' => 'user.wishlist',
                'icon' => '/images/icones/bookmark-heart.svg',
                'order' => 5,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Tecnologias',
                'route' => 'user.tecnologias',
                'icon' => '/images/icones/boxes.svg',
                'order' => 6,
                'active' => false,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Conteúdos',
                'route' => 'user.conteudos',
                'icon' => '/images/icones/bounding-box.svg',
                'order' => 7,
                'active' => false,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Calendário',
                'route' => 'user.calendario',
                'icon' => '/images/icones/calendar.svg',
                'order' => 8,
                'active' => false,
                'allowed_classifications' => null,
            ],
        ];

        foreach ($items as $item) {
            MenuItem::updateOrCreate(
                ['route' => $item['route']],
                $item
            );
        }
    }
}
