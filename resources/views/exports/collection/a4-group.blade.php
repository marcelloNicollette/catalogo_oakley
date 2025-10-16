<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - {{ $name }}</title>

    <style>
        @page {
            margin: 0px;
        }

        /* Em modo de prévia HTML (não-PDF), registrar fontes via navegador */
        @if (!isset($isPdf) || $isPdf === false)
            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 400;
                src: url('{{ asset('fonts/Neue-Plak-Regular.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 600;
                src: url('{{ asset('fonts/Neue-Plak-SemiBold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 700;
                src: url('{{ asset('fonts/Neue-Plak-Bold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 900;
                src: url('{{ asset('fonts/Neue-Plak-Black.ttf') }}') format('truetype');
            }
        @endif

        /* Em modo PDF (Dompdf), registrar fontes via caminho absoluto local (file:///) */
        @if (isset($isPdf) && $isPdf === true)
            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 400;
                src: url('file://{{ public_path('fonts/Neue-Plak-Regular.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 600;
                src: url('file://{{ public_path('fonts/Neue-Plak-SemiBold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 700;
                src: url('file://{{ public_path('fonts/Neue-Plak-Bold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Neue-Plak';
                font-style: normal;
                font-weight: 900;
                src: url('file://{{ public_path('fonts/Neue-Plak-Black.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Neue-Plak-Extended';
                font-style: normal;
                font-weight: 900;
                src: url('file://{{ public_path('fonts/Neue-Plak-Extended-ExtraBlack.ttf') }}') format('truetype');
            }
        @endif


        body {
            font-family: 'Roboto', sans-serif;
            margin: 0px;
        }

        .font-neueplak {
            font-family: 'Neue-Plak';
            font-size: 50px;
        }

        .font-fko {
            font-family: 'Neue-Plak';
            font-size: 50px;
        }

        .page-break {
            page-break-after: always;
        }

        .capa {
            text-align: left;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
    @unless ($remove_capa_retranca)
        <!-- CAPA -->
        <div class="capa" style="background: #E31B23; height: 100%;">
            <div style="padding: 5rem;">

                <h1 class="font-neueplak"
                    style="font-size: 130px; color: #fff; font-family: 'Neue-Plak-Extended'; font-weight: 900; margin:0; padding:0; line-height: 80px;">
                    COLEÇÃO
                </h1>
                <h1
                    style="font-size: 130px; color: #fff; font-family: 'Neue-Plak-Extended'; font-weight: 900; margin:0; padding:0; line-height: 80px; text-transform: uppercase;">
                    {{ $collections->first()->collection->name }}
                </h1>

                <div style="position: absolute; bottom: 60px; right: 80px;">
                    <img src="{{ public_path('/images/logo-preto.png') }}" alt="">
                </div>
            </div>

        </div>
    @endunless

    @php
        // Agrupa por categoria para garantir que todos os produtos da mesma categoria fiquem juntos
        $groupedByCategory = $collections->groupBy(function ($c) {
            return $c->product->category->name;
        });
    @endphp

    @foreach ($groupedByCategory as $categoryName => $categoryCollections)
        @unless ($remove_capa_retranca)
            <!-- CATEGORIA -->
            <div class="capa" style="background: #000; height: 100%;">
                <div style="padding: 5rem;">

                    <h1
                        style="font-size: 110px; color: #fff; font-family: 'Neue-Plak-Extended'; font-weight: 900;  margin:0; padding:0; line-height: 80px; text-transform: uppercase;">
                        {{ $categoryName }}
                    </h1>
                    <div style="position: absolute; bottom: 60px; right: 80px;">
                        <img src="{{ public_path('/images/logo-vermelho.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
        @endunless
        @php
            // Dentro da categoria, agrupa por código de produto para não duplicar a tabela
            $productsByCode = $categoryCollections->groupBy(function ($c) {
                return $c->product->code;
            });
        @endphp

        @foreach ($productsByCode as $code => $collectionsByCode)
            @php
                // Usar a primeira coleção do grupo como base para os dados do produto
                $collection = $collectionsByCode->first();
            @endphp



            @php
                $image = $collection->product->code . '_' . str_replace('/', '_', $collection->color_code) . '.jpg';
                //dd(public_path('images/produtos/' . $image));
                $image = public_path('images/produtos/' . $image);
                //$image = '/images/produtos/' . $image;
                $imageExists = $image && file_exists($image) && !is_dir($image);
            @endphp


            @if ($remove_capa_retranca)
                <div style="position: absolute; top: 30px; left: 30px;">
                    <img src="{{ public_path('/images/logo-vermelho.png') }}" alt="">
                </div>
            @endif
            <table cellspacing="2" width="100%" cellpadding="2">
                <tr>
                    <td width="70%">
                        <table cellspacing="0" width="100%" cellpadding="0">
                            <tr>
                                <td width="75%">
                                    <img src="{{ $image }}" alt="{{ $collection->product->name }}"
                                        style="width: 100%; object-fit: cover; border-radius: 8px 0 0 8px; border-top:1px solid #CCC; border-left:1px solid #CCC; border-bottom:1px solid #CCC;  ">
                                </td>
                                <td width="24.8%">
                                    @php
                                        $suffixes = ['_A', '_B', '_C'];
                                        $vista = 1;
                                    @endphp

                                    @foreach ($suffixes as $suffix)
                                        @php
                                            if ($suffix == '_A') {
                                                $rounded = '0 8px 0 0';
                                            } elseif ($suffix == '_B') {
                                                $rounded = '0 0 0 0';
                                            } else {
                                                $rounded = '0 0 8px 0';
                                            }
                                            $imagePath = public_path(
                                                '/images/produtos/' .
                                                    $collection->product->code .
                                                    '_' .
                                                    str_replace('/', '_', $collection->color_code) .
                                                    $suffix .
                                                    '.jpg',
                                            );

                                            $fullImagePath = $imagePath;
                                            $imageExists = file_exists($fullImagePath);
                                            $imageSrc = $imageExists
                                                ? $imagePath
                                                : public_path('images/img-padrao-ua.png');

                                            /* $imagePath =
                                            '/images/produtos/' .
                                            $collection->first()->product->code .
                                            '_' .
                                            str_replace('/', '_', $collection->first()->color_code) .
                                            $suffix .
                                            '.jpg';*/

                                        @endphp
                                        <img src="{{ $imageSrc }}" alt="Tênis"
                                            style="width: 100%; object-fit: cover; border-radius: {{ $rounded }}; border:1px solid #CCC; border-spacing:0;">
                                        @php $vista++; @endphp
                                    @endforeach
                                </td>


                            </tr>
                            <!-- cores do tenis -->
                            <tr>
                                <td colspan="2">
                                    <table
                                        style="width: 100%; margin: 0 auto;  border-radius: 8px; border:1px solid #CCC; margin-top:5px;">
                                        <tr>
                                            @foreach ($collectionsByCode as $colorCollection)
                                                <td
                                                    style="width: auto; padding: 10px 0; text-align: center; vertical-align: top;">
                                                    <div style="padding: 15px 0; position: relative;">
                                                        @if ($colorCollection->flagProduct)
                                                            <div
                                                                style="position: absolute; top: 10px; left: 10px; background: {{ $colorCollection->flagProduct->flag_bg }}; color: {{ $colorCollection->flagProduct->flag_color_text_bg }}; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold;">
                                                                {{ $colorCollection->flagProduct->flag_title }}
                                                            </div>
                                                        @endif
                                                        <div style="margin-top: 30px; margin-bottom: 15px;">
                                                            @php
                                                                $imagePath =
                                                                    'images/produtos/' .
                                                                    $colorCollection->product->code .
                                                                    '_' .
                                                                    str_replace(
                                                                        '/',
                                                                        '_',
                                                                        $colorCollection->color_code,
                                                                    ) .
                                                                    '.jpg';
                                                                $fullImagePath = public_path($imagePath);
                                                                $imageExists = file_exists($fullImagePath);
                                                                $imageSrc = $imageExists
                                                                    ? public_path($imagePath)
                                                                    : public_path('images/img-padrao-oly.png');
                                                            @endphp
                                                            <img width="100px" src="{{ $imageSrc }}"
                                                                alt="{{ $colorCollection->color_name }}"
                                                                class="width: 100px; height: auto; border-radius: 8px;" />
                                                        </div>
                                                        <div
                                                            style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">
                                                            {{ \Illuminate\Support\Str::limit($colorCollection->color_name, 15, '...') }}
                                                        </div>
                                                        <div style="font-size: 12px; color: #666;">
                                                            {{ \Illuminate\Support\Str::limit($colorCollection->color_description, 15, '...') }}
                                                        </div>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- fim cores do tenis -->
                        </table>
                    </td>
                    <td width="30%" style="border-radius: 8px; border:1px solid #CCC; vertical-align: top;">
                        <!-- Cabeçalho do produto -->
                        <div style="padding:10px;">
                            <div style="font-size: 17px; color: #000; margin-bottom: 5px;">
                                {{ $collection->product->category->name }}
                                @if (!$remove_code)
                                    <span style="color: #000; opacity: 0.5;">{{ $collection->product->code }}</span>
                                @endif
                            </div>
                            <h1
                                style="font-family: 'Neue-Plak-Extended'; font-weight: 900; margin: 0 0 10px 0; line-height: 0.5;">
                                {{ $collection->product->name }}</h1>

                            <table width="100%">
                                <tr>
                                    @if (!$remove_price)
                                        <td
                                            style="font-size: 12px; margin-bottom: 2px; vertical-align: top; padding-bottom: 10px;">
                                            <div>
                                                <div
                                                    style="font-size: 12px; color: #000; opacity: 0.5;  margin-bottom: 2px;">
                                                    PDV</div>
                                                <div style="font-size: 17px; ">{{ $collection->product->price }}
                                                </div>
                                            </div>

                                        </td>
                                    @endif

                                    @if ($collection->product->caracteristicasDestaque)
                                        @if ($collection->product->caracteristicasDestaque->first())
                                            @php $caracteristica = $collection->product->caracteristicasDestaque->first() @endphp
                                            <td style="font-size: 12px;  margin-bottom: 2px; padding-bottom: 10px;">
                                                <div
                                                    style="font-size: 12px; color: #000; opacity: 0.5; margin-bottom: 2px;">
                                                    {{ $caracteristica->title }}
                                                </div>
                                                <div style="font-size: 14px; ">{!! nl2br(e($caracteristica->description)) !!}</div>
                                            </td>
                                        @endif
                                    @endif
                                </tr>

                                @if ($collection->product->caracteristicas)
                                    @foreach ($collection->product->caracteristicas->chunk(2) as $caracteristicasChunk)
                                        <tr>
                                            @foreach ($caracteristicasChunk as $caract)
                                                <td style="font-size: 12px; margin-bottom: 2px; padding-bottom: 10px;">
                                                    <div>
                                                        <div style="color: #000; opacity: 0.5; margin-bottom: 2px;">
                                                            {{ $caract->title }}</div>
                                                        <div style="font-size: 14px;">{!! nl2br(e($caract->description)) !!}</div>
                                                    </div>
                                                </td>
                                            @endforeach
                                            @if ($caracteristicasChunk->count() == 1)
                                                <td style="font-size: 12px; margin-bottom: 2px; padding-bottom: 10px;">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif

                                @if ($collection->product->numeracoes)
                                    @foreach ($collection->product->numeracoes as $numeracao)
                                        <tr>
                                            <td style="font-size: 12px; margin-bottom: 2px; padding-bottom: 10px;">
                                                <div>
                                                    <div style="color: #000; opacity: 0.5; margin-bottom: 2px;">
                                                        Numeração</div>
                                                    <div style="font-size: 14px;">{!! nl2br(e($numeracao->numero)) !!}</div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif

                            </table>

                        </div>

                        <!-- Descrição -->
                        <div style="padding: 0 10px 10px 10px;">
                            <div style="font-size: 12px; color: #000; opacity: 0.5; margin-bottom: 2px;">Descrição
                            </div>
                            <p style="font-size: 13px; line-height: 1.3; color: #000; margin: 0;">
                                {{ $collection->product->description }}
                            </p>
                        </div>

                        @unless ($remove_description)
                            <!-- Tecnologias -->
                            <div style="padding: 0 10px 10px 10px; margin-top:20px">
                                <div style="font-size: 12px; color: #000; opacity: 0.5; margin-bottom: 2px;">Tecnologias
                                </div>
                            </div>

                            @if (count($collection->product->technologyItems) > 0)
                                <div style="padding: 0 10px 10px 10px;">

                                    @foreach ($collection->product->technologyItems->chunk(5) as $itemsChunk)
                                        <div style="overflow: hidden;">
                                            @foreach ($itemsChunk as $item)
                                                <div
                                                    style="float: left; width: calc(20% - 12.8px); margin-right: 16px; text-align: center;">
                                                    <div
                                                        style="width: 70px; height: 70px; background-color: black; border-radius: 8px; display: inline-block; position: relative; margin: 0 auto 8px auto;">
                                                        <img src="{{ public_path('/' . $item->icon) }}"
                                                            style="width: 70px; height: 70px; object-fit: contain; border-radius: 10px;"
                                                            alt="{{ $item->name }}" />
                                                    </div>
                                                    <p
                                                        style="font-size: 10px; color: black; opacity: 0.5; text-align: center; line-height: 1.25; margin: 0; min-height:30px;">
                                                        {{ $item->name }}
                                                    </p>
                                                </div>
                                            @endforeach
                                            <div style="clear:both;"></div>
                                        </div>
                                    @endforeach

                                </div>
                            @endif
                        @endunless
                    </td>
                </tr>
            </table>
        @endforeach
    @endforeach
</body>

</html>
