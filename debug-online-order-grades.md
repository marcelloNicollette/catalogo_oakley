# Debug Session: online-order-grades

- Status: OPEN
- Objetivo: entender por que as grades do pedido nao aparecem no servidor online, embora existam localmente.
- Escopo inicial: fluxo de montagem do pedido, persistencia de `grade_rows`, reidratacao do pedido salvo e renderizacao do modal/listagem no ambiente online.

## Sintoma

- No servidor online, o pedido abre sem mostrar as grades do item.
- Localmente, o fluxo de grades existe e foi implementado recentemente.

## Hipoteses Iniciais

1. O deploy no servidor online nao publicou corretamente a versao nova de `produtos.blade.php`, e o front em producao esta com JS/Blade antigo.
2. O payload salvo/retornado no servidor online nao contem `shoe_grids` ou `grade_rows`, entao a view reidrata o item sem dados de grade.
3. Existe diferenca de dados no banco online: os produtos do pedido nao possuem relacao/cadastro de `SHOES_GRIDs` para o item/cor esperado.
4. Algum cache do Laravel/OPcache/Blade no servidor esta servindo uma view antiga mesmo apos o `pull`.
5. Ha erro de permissao/cache no servidor que impede leitura correta de views ou execucao da versao atual do template.

## Evidencias Necessarias

- Confirmar o commit/arquivo ativo no servidor para `resources/views/user/produtos.blade.php`.
- Inspecionar o HTML renderizado e o payload JS de um item com grade no ambiente online.
- Verificar se o pedido salvo online contem `grade_rows` no banco.
- Verificar logs do Laravel e caches ativos apos o deploy.

## Evidencias Coletadas

- Servidor online esta no commit `a7a6748` e os trechos novos existem em:
  - `resources/views/user/produtos.blade.php`
  - `app/Http/Controllers/User/frontendController.php`
- `php artisan optimize:clear` foi executado com sucesso.
- No navegador online, o `localStorage` do pedido mostra:
  - `shoe_grids: []`
  - `grade_rows: []`
    para o item `1-01K`.
- No navegador online, `produtosData['1-01K']` tambem mostra `shoe_grids: []`.
- A tentativa de consultar `shoe_grids.color_id` no banco falhou com `Unknown column 'color_id'`, o que e compativel com o modelo atual: a relacao usa a pivot `color_shoe_grids`.
- No banco online, existem varias linhas em `colors` para `product_id = 1` e `color_code = 01K`.
- Apenas parte dessas linhas possui vinculo na pivot `color_shoe_grids` para a grade `8 / M38A`; varias outras linhas nao possuem qualquer vinculo.
- As migracoes `2026_05_12_000008` e `2026_05_12_000009` estao aplicadas no servidor online.

## Status Das Hipoteses

1. O deploy no servidor online nao publicou corretamente a versao nova de `produtos.blade.php`.
   - Rejeitada pelas evidencias coletadas.
2. O payload salvo/retornado no servidor online nao contem `shoe_grids` ou `grade_rows`.
   - Confirmada ate o `produtosData` renderizado; a origem esta no backend/dados da relacao.
3. Existe diferenca de dados no banco online: os produtos do pedido nao possuem relacao/cadastro de `SHOES_GRIDs` para o item/cor esperado.
   - Confirmada parcialmente: algumas linhas possuem grade e outras nao.
   - Precisamos descobrir qual linha de `colors` esta sendo usada na tela atual.
4. Existe colisao de chave/selecionamento no front porque o pedido usa apenas `product_id-color_code`, mas o banco possui varias linhas de `colors` para essa combinacao.
   - Nova hipotese e agora muito provavel.
5. Algum cache do Laravel/OPcache/Blade no servidor esta servindo uma view antiga mesmo apos o `pull`.
   - Rejeitada pelas evidencias coletadas.
6. Ha erro de permissao/cache no servidor que impede leitura correta de views ou execucao da versao atual do template.
   - Menos provavel no momento; sem evidencia atual sustentando essa hipotese.

## Causa Raiz Confirmada

- O mesmo `product_id + color_code` existe em mais de uma colecao no banco.
- O front do pedido estava usando apenas a chave `product_id-color_code`, sem considerar a colecao.
- Com isso, ao clicar em um item da colecao atual, o pedido podia reidratar outra linha de `colors` da mesma combinacao, mas sem `shoe_grids`.

## Correcao Aplicada

- A chave interna do pedido passou a considerar `collection_id`, no formato `product_id-color_code-collection_id`.
- `produtosData` agora serializa `collection_id`.
- A reidratacao do pedido (`hydratePedidoItem` e `carregarPedidoItens`) migra silenciosamente itens antigos do `localStorage`.
- A busca de produto por chave agora prioriza a colecao atual e so cai no legado quando necessario.
- Favoritos permanecem usando a chave legada `product_id-color_code`, para nao quebrar o fluxo existente.

## Proximos Passos

- Verificar no banco online se a cor `01K` do produto `1` possui registros na pivot `color_shoe_grids`.
- Verificar se os `shoe_grids` vinculados estao com `active = 1`.
- Verificar se as migracoes `2026_05_12_000008` e `2026_05_12_000009` foram aplicadas no online.
- Verificar se `produtosData` contem entradas duplicadas para a chave `1-01K`.
- Verificar qual `collection_id/slug` e qual `color_id` da linha usada na tela atual.
- Instrumentar somente se a coleta inicial nao for suficiente.
