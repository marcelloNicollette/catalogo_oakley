<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // Comentando ou removendo o factory de teste
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Executando todos os seeders gerados
        $this->call([
            // Seeders básicos/configuração
            CategoriesTableSeeder::class,
            ColorsTableSeeder::class,
            SizesTableSeeder::class,
            NumeracaoTableSeeder::class,

            // Seeders de usuários e segmentação
            UsersTableSeeder::class,
            SegmentacaoTableSeeder::class,
            ColorSegmentacaoClienteTableSeeder::class,
            SegmentacaoClienteTableSeeder::class,
            UserSegmentacaoClienteTableSeeder::class,

            // Seeders de produtos e características
            ProductsTableSeeder::class,
            CaracteristicasProductTableSeeder::class,
            FlagProductTableSeeder::class,
            LinksProductTableSeeder::class,
            ProductNumeracaoTableSeeder::class,
            ProductSizesTableSeeder::class,

            // Seeders de coleções e banners
            CollectionsTableSeeder::class,
            BannersTableSeeder::class,

            // Seeders de conteúdo
            ConteudoCategoriesTableSeeder::class,
            ConteudoTableSeeder::class,

            // Seeders de tecnologia
            TechnologyCategoriesTableSeeder::class,
            TechnologyItemsTableSeeder::class,

            // Seeders de usuário
            UserWishlistsTableSeeder::class,
            SuggestionsTableSeeder::class,

            // Seeders de sistema/cache
            CalendarioTableSeeder::class,
            SessionsTableSeeder::class,
            CacheTableSeeder::class,
            //ExportUsersTableSeeder::class,
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
    }
}
