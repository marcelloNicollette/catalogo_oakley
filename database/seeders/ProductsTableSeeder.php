<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('products')->truncate();
        
        // Insert new data
        DB::table('products')->insert([
            [
                'id' => 27,
                'name' => 'CORRE SUPRA2',
                'description' => 'A segunda edição do Olympikus Corre Supra chega para entregar ainda mais desempenho nas ruas. Tecnologia Oxitec 4.0, que permite maior respirabilidade, 
resistência e leveza. Lingueta macia e leve ao toque feita em Eco Suede com perfuros. Atacador aprimorado para garantir um ajuste mais preciso e seguro na 
amarração. Forro interno confeccionado em mescla de poliéster e elastano, trazendo mais conforto, durabilidade e flexibilidade. Puxador traseiro em fita para 
facilitar o calce. Palmilha NT-X 2mm, gerando leveza e mais energia a cada passada. Solado NT-X 2 PRO, que proporciona maior amortecimento e alto nível 
de resiliência e leveza, além de um baixo nível de deformação. Tecnologia CARBON-G para aumentar a eficiência na impulsão e na estabilização. Borracha 
antiderrapante Michelin, que proporciona maior resistência. Com drop de 6mm, o modelo equilibra conforto e desempenho, ideal para corridas de alta 
performance.',
                'code' => '43777397',
                'sku' => '43777397',
                'price' => '1299.99',
                'slug' => 'corre-supra2',
                'category_id' => 1,
                'technologies' => '[\"1\",\"2\",\"3\",\"10\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-08-01 00:00:00',
                'data_trade' => '2025-08-01 00:00:00',
                'data_cliente' => '2025-08-01 00:00:00',
                'data_dtc' => '2025-08-01 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 17:59:44',
                'updated_at' => '2025-09-10 17:59:44',
                'deleted_at' => null,
            ],
            [
                'id' => 28,
                'name' => 'PRIDE 4',
                'description' => 'Projetado para corridas intensas, o Olympikus PRIDE chega em sua quarta edição com diversas novidades. Entressola com tecnologia Eleva Pro 2.0, garantindo
maior resiliência, conforto e responsividade. Solado com tecnologia Gripper, altamente durável, resistente e antiderrapante. Palmilha em EVA que oferece maior
respirabilidade e um encaixe perfeito para os pés. Atacador em poliéster texturizado. Puxador traseiro em fita para auxiliar no calce. Gáspea produzida com
tecido giro inglês, uma tecnologia inovadora e flexível, que conta com fios de TPU e TPE para oferecer maior resistência, leveza e um toque macio. Logo em TPU
com detalhes de pintura e laminado feitos com a tecnologia high frequency, um material diferenciado de espessura mínima. Lingueta em tecido duplo frontura +
espuma e interior produzido em poliéster, oferecendo conforto ao caminhar.',
                'code' => '43561394',
                'sku' => '43561394',
                'price' => '399.99',
                'slug' => 'pride-4',
                'category_id' => 1,
                'technologies' => '[\"1\",\"2\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-06-16 00:00:00',
                'data_trade' => '2025-06-16 00:00:00',
                'data_cliente' => '2025-06-16 00:00:00',
                'data_dtc' => '2025-06-16 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 18:22:05',
                'updated_at' => '2025-09-10 18:22:05',
                'deleted_at' => null,
            ],
            [
                'id' => 29,
                'name' => 'QUADRA BR1',
                'description' => 'Co-criado junto com um dos maiores jogadores da história do vôlei mundial, Bruno Rezende, o Olympikus QU4DRA BR1 é uma expressão de excelência, paixão
e legado para quem vive as 4 linhas. Possui tecnologia Eleva Pro 2.0, que proporciona leveza e amortecimento, trazendo maior conforto e efeito trampolim.
Conta também com borracha antiderrapante Gripper, que mantém aderência firme ao solo. O solado apresenta design em curvas e linhas orgânicas, evitando
o desgaste e garantindo maior segurança nas mudanças de direções em quadra. Já o cabedal confeccionado em poliéster envolve o tornozelo com mais
segurança e suporte. As tramas mais espaçadas permitem maior respirabilidade dos pés para maior conforto. Sua palmilha anatômica moldada é composta por
tecido poliéster e EVA com 4mm de espessura, adaptando-se ao pé para evitar o deslizamento. O forro possui tecido respirável que se molda ao pé como uma
meia, pois é unido a lingueta, o que resulta num alto ajuste e maior sensação de conforto. Apresenta puxador traseiro que auxilia no calce e puxador frontal
que ajuda na disposição dos atacadores. Além disso, seu atacador em tecido poliéster e com textura diferenciada, proporciona uma amarração superior e mais
segura.',
                'code' => '43391327',
                'sku' => '43391327',
                'price' => '499.99',
                'slug' => 'quadra-br1',
                'category_id' => 2,
                'technologies' => '[\"1\",\"2\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-07-08 00:00:00',
                'data_trade' => '2025-07-08 00:00:00',
                'data_cliente' => '2025-07-08 00:00:00',
                'data_dtc' => '2025-07-08 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 18:28:45',
                'updated_at' => '2025-09-10 18:28:45',
                'deleted_at' => null,
            ],
            [
                'id' => 30,
                'name' => 'TREINO',
                'description' => 'Ideal para quem busca estilo e leveza nos treinos. Conta com a tecnologia de amortecimento EVASENSE, que proporciona mais leveza, maciez e flexibilidade 
nas passadas. Cabedal em poliéster com impressão digital e tecnologia HIGH FREQUENCY, logo em TPU, além de pintura e detalhes em laminado. Lingueta 
confortável, produzida em poliéster e espuma. Puxador em fita com arte gráfica e atacador em poliéster texturizado. Puxador traseiro em fita com arte gráfica 
para facilitar o calce. Forro em tecido Poliéster com espuma, para maior conforto ao caminhar. Palmilha em poliéster e EVA com aplicação gráfica. Solado em 
borracha antiderrapante com tecnologia GRIPPER, que oferece maior durabilidade e resistência.',
                'code' => '43210417',
                'sku' => '43210417',
                'price' => '399.99',
                'slug' => 'treino',
                'category_id' => 2,
                'technologies' => '[\"1\",\"2\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-04-29 00:00:00',
                'data_trade' => '2025-04-29 00:00:00',
                'data_cliente' => '2025-04-29 00:00:00',
                'data_dtc' => '2025-04-29 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:02:38',
                'updated_at' => '2025-09-10 20:02:38',
                'deleted_at' => null,
            ],
            [
                'id' => 31,
                'name' => 'PASSO',
                'description' => 'Ideal para quem busca estilo e conforto nas corridas. Cabedal com tecnologia HYPERSOX, que facilita o calce e oferece melhor caimento, conforto e maciez. 
Vistas em laminado e TPU com pintura e detalhes em tecnologia HIGH FREQUENCY. Lingueta em tecido dupla frontura com alta capacidade de transpiração, 
além de etiqueta em fita gráfica. Atacador em poliéster chato texturizado. Forro em poliéster canelado com espuma, garantindo maior conforto ao caminhar. 
Puxador traseiro em fita texturizada para facilitar o calce. Palmilha em poliéster e EVA com aplicação gráfica. Solado com design exclusivo e tecnologia ELEVA+, 
que aprimora a resiliência, leveza e conforto do modelo.',
                'code' => '43242437',
                'sku' => '43242437',
                'price' => '279.99',
                'slug' => 'passo',
                'category_id' => 9,
                'technologies' => '[\"1\",\"2\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-08-13 00:00:00',
                'data_trade' => '2025-08-13 00:00:00',
                'data_cliente' => '2025-08-13 00:00:00',
                'data_dtc' => '2025-08-13 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:09:27',
                'updated_at' => '2025-09-10 20:30:39',
                'deleted_at' => null,
            ],
            [
                'id' => 32,
                'name' => 'NIVEL',
                'description' => 'A combinação perfeita entre leveza e flexibilidade. Tecnologia HYPERSOX, com estrutura que facilita o calce e oferece melhor caimento, conforto e maciez. 
Vistas em laminado e TPU com pinturas que levam a tecnologia HIGH FREQUENCY. Lingueta em dupla frontura e etiqueta com arte gráfica em high frequency. 
Atacador em poliéster redondo bicolor texturizado. Forro em poliéster com espuma, que proporciona maior conforto ao caminhar. Puxador traseiro em fita 
texturizada para melhor auxílio no calce. Palmilha composta por poliéster e EVA, com aplicação gráfica. Tecnologia de amortecimento EVASENSE, em um único 
bloco de EVA, que proporciona maior leveza, maciez e flexibilidade nas passadas.',
                'code' => '43211421',
                'sku' => '43211421',
                'price' => '249.99',
                'slug' => 'nivel',
                'category_id' => 9,
                'technologies' => '[\"1\",\"2\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-06-05 00:00:00',
                'data_trade' => '2025-06-05 00:00:00',
                'data_cliente' => '2025-06-05 00:00:00',
                'data_dtc' => '2025-06-05 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:15:23',
                'updated_at' => '2025-09-10 20:30:46',
                'deleted_at' => null,
            ],
            [
                'id' => 33,
                'name' => 'EASY 3',
                'description' => 'Em sua terceira edição, o Olympikus EASY é a escolha ideal para quem busca leveza a cada passada. Cabedal com mescla de tecido bicolor e parte traseira em 
poliéster texturizado. Elástico no cabedal que ressalta a marca. Etiqueta em laminado com arte gráfica. Forro em poliéster com espuma, para maior conforto 
ao caminhar. Puxador traseiro em fita texturizada para melhor auxílio no calce. Palmilha composta por poliéster e espuma, com aplicação gráfica. Tecnologia 
EVASENSE de amortecimento, em um único bloco de EVA, que proporciona maior leveza, maciez e flexibilidade nas passadas.',
                'code' => '43609415',
                'sku' => '43609415',
                'price' => '229.99',
                'slug' => 'easy-3',
                'category_id' => 3,
                'technologies' => '[\"1\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-05-10 00:00:00',
                'data_trade' => '2025-05-10 00:00:00',
                'data_cliente' => '2025-05-10 00:00:00',
                'data_dtc' => '2025-05-10 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:29:23',
                'updated_at' => '2025-09-10 20:29:23',
                'deleted_at' => null,
            ],
            [
                'id' => 34,
                'name' => 'VERSA',
                'description' => 'O Olympikus Versa é um tênis clássico que nunca sai de moda, perfeito para quem busca mais estilo e conforto para o dia a dia. O seu solado tem o tradicional
visual de sola caixa e possui a Tecnologia Evasense, que proporciona conforto e amortecimento. Conta também com a tecnologia Gripper, uma borracha
antiderrapante que aumenta a resistência à abrasão e proporciona maior aderência e segurança. Já o cabedal é feito em laminado sintético texturizado e conta
com detalhes como a costura dupla, costura zigue e perfuros laterais distribuídos na gáspea. Possui ainda forro em poliéster com espuma, e palmilha plana
composta por tecido poliéster e EVA, com aplicação gráfica.',
                'code' => '43752263',
                'sku' => '43752263',
                'price' => '259.99',
                'slug' => 'versa',
                'category_id' => 8,
                'technologies' => '[\"1\",\"10\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-03-20 00:00:00',
                'data_trade' => '2025-03-20 00:00:00',
                'data_cliente' => '2025-03-20 00:00:00',
                'data_dtc' => '2025-03-20 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:35:10',
                'updated_at' => '2025-09-10 20:39:53',
                'deleted_at' => null,
            ],
            [
                'id' => 35,
                'name' => 'ACQUA INFANTIL',
                'description' => 'Cabedal em tecido jacquard com detalhes que combinam resistência e versatilidade. Vistas em laminado e TPU com tecnologia HIGH FREQUENCY. Lingueta 
confortável, com combinação de poliéster e espuma. Atacador em poliéster oval texturizado. Forro em poliéster com espuma, para maior conforto ao caminhar. 
Puxador traseiro em fita, para auxiliar no calce. Palmilha composta por poliéster e EVA, com aplicação gráfica. Tecnologia ELEVA+, que melhora a resiliência, 
leveza e conforto do modelo.',
                'code' => '43306412',
                'sku' => '43306412',
                'price' => '199.99',
                'slug' => 'acqua-infantil',
                'category_id' => 9,
                'technologies' => '[\"1\",\"2\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-08-28 00:00:00',
                'data_trade' => '2025-08-28 00:00:00',
                'data_cliente' => '2025-08-28 00:00:00',
                'data_dtc' => '2025-08-28 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:39:28',
                'updated_at' => '2025-09-10 20:39:28',
                'deleted_at' => null,
            ],
            [
                'id' => 36,
                'name' => 'VENUM 2 INFANTIL',
                'description' => 'Em sua segunda edição, o Olympikus VENUM INFANTIL se destaca pela tecnologia COVERGRID no cabedal, que proporciona maior proteção, resistência e durabilidade. 
Logo com pintura que dá destaque ao conjunto, criando efeito visual em 3D que muda conforme o movimento da passada. Lingueta em dupla frontura, com alta 
capacidade de transpiração, e etiqueta minimalista em high frequency. Atacador em poliéster texturizado com efeito pontilhado. Puxador traseiro em fita para facilitar 
o calce. Forro em tecido Poliéster com espuma, para maior conforto ao caminhar. Palmilha composta por poliéster e EVA, com aplicação gráfica. Tecnologia EVASENSE 
de amortecimento, em um único bloco de EVA, que proporciona maior leveza, maciez e flexibilidade nas passadas. Visual com cavidades nas laterais oferece aspecto 
contemporâneo e estrutura funcional ao modelo. Superfície plantar com componentes distribuídos, que garantem máxima flexão e aderência ao solo.',
                'code' => '43284434',
                'sku' => '43284434',
                'price' => '199.99',
                'slug' => 'venum-2-infantil',
                'category_id' => 9,
                'technologies' => '[\"1\",\"2\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-07-17 00:00:00',
                'data_trade' => '2025-07-17 00:00:00',
                'data_cliente' => '2025-07-17 00:00:00',
                'data_dtc' => '2025-07-17 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:47:26',
                'updated_at' => '2025-09-10 20:47:26',
                'deleted_at' => null,
            ],
            [
                'id' => 37,
                'name' => 'LIVRE',
                'description' => '\"O LIVRE é a escolha ideal para quem busca conforto e descanso para os pés. Tiras em PVC com aplicação do logotipo. Palmilha e solado em EVA. Borracha 
antiderrapante com tecnologia GRIPPER, que proporciona maior durabilidade e resistência.',
                'code' => '54110438',
                'sku' => '54110438',
                'price' => '99.99',
                'slug' => 'livre',
                'category_id' => 4,
                'technologies' => '[\"1\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-07-10 00:00:00',
                'data_trade' => '2025-07-10 00:00:00',
                'data_cliente' => '2025-07-10 00:00:00',
                'data_dtc' => '2025-07-10 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 20:53:40',
                'updated_at' => '2025-09-10 20:53:40',
                'deleted_at' => null,
            ],
            [
                'id' => 38,
                'name' => 'CORRE MAX',
                'description' => 'Graças à extrema leveza resultante de nossa mais recente tecnologia, o Olympikus Corre Max oferece um desempenho superior e um conforto incomparável 
durante as corridas. Sua entressola possui a tecnologia Eleva Pro Max, que melhora os índices de resiliência, leveza, conforto e responsividade. Conta também 
com a tecnologia Gripper, que garante contato firme com o chão. Seu desenho curvilíneo com pontos de contato distribuídos em seções favorecem a flexão e 
aderência. Apresenta cabedal e lingueta confeccionados em dupla frontura Jacquard, utilizando fio de poliéster texturizado no enchimento para proporcionar 
conforto, mobilidade e respirabilidade. Além disso, seu logo é aplicado em high frequency e seu atacador é composto por tecido de poliéster texturizado, 
garantindo uma amarração precisa e confortável. Já o forro é confeccionado com uma mistura de poliéster, elastano e espuma, oferecendo alta permeabilidade. 
Conta ainda com palmilha de Ortholite 6mm conformada, complementada por tecido de poliéster, proporcionando ótimo ajuste.',
                'code' => '43758365',
                'sku' => '43758365',
                'price' => '549.99',
                'slug' => 'corre-max',
                'category_id' => 1,
                'technologies' => '[\"1\",\"2\",\"3\",\"10\",\"4\",\"5\",\"6\",\"7\",\"8\"]',
                'flag_calendario' => '1',
                'data_mkt' => '2025-09-16 00:00:00',
                'data_trade' => '2025-09-16 00:00:00',
                'data_cliente' => '2025-09-16 00:00:00',
                'data_dtc' => '2025-09-16 00:00:00',
                'active' => 1,
                'created_at' => '2025-09-10 21:00:26',
                'updated_at' => '2025-09-16 21:36:03',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('ProductsTableSeeder completed successfully.');
    }
}