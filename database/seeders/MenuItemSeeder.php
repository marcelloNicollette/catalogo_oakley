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
                'icon' => '/images/icones/inicio.svg',
                'order' => 10,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Coleções',
                'route' => 'user.slug.colecoes',
                'icon' => '/images/icones/colecoes.svg',
                'order' => 20,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Compartilhar',
                'route' => 'user.compartilhar',
                'icon' => '/images/icones/compartilhar.svg',
                'order' => 30,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Baixar',
                'route' => 'user.gerar-arquivo',
                'icon' => '/images/icones/baixar.svg',
                'order' => 40,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Favoritos',
                'route' => 'user.wishlist',
                'icon' => '/images/icones/favoritos.svg',
                'order' => 50,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Tecnologias',
                'route' => 'user.tecnologias',
                'icon' => '/images/icones/tecnologia.svg',
                'order' => 60,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Conteúdos',
                'route' => 'user.conteudos',
                'icon' => '/images/icones/conteudo.svg',
                'order' => 70,
                'active' => true,
                'allowed_classifications' => null,
            ],
            [
                'label' => 'Calendário',
                'route' => 'user.calendario',
                'icon' => '/images/icones/calendario.svg',
                'order' => 80,
                'active' => true,
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
