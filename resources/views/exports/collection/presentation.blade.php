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

        @font-face {
            font-family: 'neueplak';
            src: url("{{ public_path('fonts/Neue-Plak-Regular.ttf') }}") format('truetype');
        }

        @if(isset($isPdf) && $isPdf)
        /* PDF: registrar variantes da família 'Neue-Plak' com caminhos absolutos */
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 400;
            src: url("file://{{ public_path('fonts/Neue-Plak-Regular.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 600;
            src: url("file://{{ public_path('fonts/Neue-Plak-SemiBold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 700;
            src: url("file://{{ public_path('fonts/Neue-Plak-Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Neue-Plak';
            font-style: normal;
            font-weight: 900;
            src: url("file://{{ public_path('fonts/Neue-Plak-Black.ttf') }}") format('truetype');
        }
        @endif

        body {
            font-family: 'Neue-Plak', sans-serif;
            margin: 0px;
        }

        .font-fko {
            font-family: 'Neue-Plak', sans-serif;
            font-size: 50px;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    @foreach ($collections as $collection)
        @php
            $image =
                $collection->first()->product->code .
                '_' .
                str_replace('/', '_', $collection->first()->color_code) .
                '.jpg';
            //dd(public_path('images/produtos/' . $image));
            $image = public_path('images/produtos/' . $image);
            $imageMainExists = $image && file_exists($image) && !is_dir($image);
            $imageMainSrc = $imageMainExists ? $image : public_path('images/img-padrao-ua.png');
            //$image = '/images/produtos/' . $image;
        @endphp
        <table cellspacing="2" width="100%" cellpadding="2">
            <tr>
                <td width="70%">
                    <table cellspacing="0" width="100%" cellpadding="0">
                        <tr>
                            <td width="75%">
                                <img src="{{ $imageMainSrc }}" alt="{{ $collection->first()->product->name }}"
                                    style="width: 100%; object-fit: cover; border-radius: 8px 0 0 8px; border-top:1px solid #CCC; border-left:1px solid #CCC; border-bottom:1px solid #CCC;  ">
                            </td>
                            <td width="24.8%">
                                @php
                                    $suffixes = ['_A', '_B', '_C'];
                                    $vista = 1;
                                @endphp

                                @foreach ($suffixes as $suffix)
                                    @php
                                        $imagePath = public_path(
                                            '/images/produtos/' .
                                                $collection->first()->product->code .
                                                '_' .
                                                str_replace('/', '_', $collection->first()->color_code) .
                                                $suffix .
                                                '.jpg',
                                        );
                                        $imageExists = file_exists($imagePath) && !is_dir($imagePath);
                                        $imageSrc = $imageExists ? $imagePath : public_path('images/img-padrao-ua.png');

                                        /* $imagePath =
                                            '/images/produtos/' .
                                            $collection->first()->product->code .
                                            '_' .
                                            str_replace('/', '_', $collection->first()->color_code) .
                                            $suffix .
                                            '.jpg';*/

                                    @endphp
                                    <img src="{{ $imageSrc }}" alt="Tênis"
                                        style="width: 100%; object-fit: cover; border-radius: 0 0 8px 0; border:1px solid #CCC; border-spacing:0;">
                                    @php $vista++; @endphp
                                @endforeach
                            </td>


                        </tr>
                        <tr>
                            <td colspan="2">
                                <table
                                    style="width: 100%; margin: 0 auto;  border-radius: 8px; border:1px solid #CCC; margin-top:5px;">
                                    <tr>
                                        @foreach ($collection as $color)
                                            <!-- Tênis {{ $vista }} -->
                                            <td
                                                style="width: 16.66%; padding: 10px; text-align: center; vertical-align: top;">
                                                <div style="padding: 15px; position: relative;">
                                                    @if ($color->flagProduct)
                                                        <div
                                                            style="position: absolute; top: 10px; left: 10px; background: {{ $color->flagProduct->flag_bg }}; color: {{ $color->flagProduct->flag_color_text_bg }}; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold;">
                                                            {{ $color->flagProduct->flag_title }}
                                                        </div>
                                                    @endif
                                                    <div style="margin-top: 30px; margin-bottom: 15px;">
                                                        @php
                                                            $thumbPath = public_path(
                                                                '/images/produtos/' .
                                                                    $collection->first()->product->code .
                                                                    '_' .
                                                                    str_replace('/', '_', $color->color_code) .
                                                                    '.jpg',
                                                            );
                                                            $thumbExists =
                                                                file_exists($thumbPath) && !is_dir($thumbPath);
                                                            $thumbSrc = $thumbExists
                                                                ? $thumbPath
                                                                : public_path('images/img-padrao-ua.png');
                                                        @endphp
                                                        <img width="100px" src="{{ $thumbSrc }}"
                                                            alt="{{ $color->color_name }}"
                                                            class="width: 100px; height: auto; border-radius: 8px;" />
                                                    </div>
                                                    <div
                                                        style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">
                                                        {{ $color->color_name }}</div>
                                                    <div style="font-size: 12px; color: #666;">
                                                        {{ $color->color_description }}</div>
                                                </div>
                                            </td>
                                        @endforeach

                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="30%" style="border-radius: 8px; border:1px solid #CCC; vertical-align: top;">
                    <!-- Cabeçalho do produto -->
                    <div style="padding:10px;">
                        <div style="font-size: 17px; color: #000; margin-bottom: 5px;">Corrida
                            @if (!$remove_code)
                                <span
                                    style="color: #000; opacity: 0.5;">{{ $collection->first()->product->code }}</span>
                            @endif
                        </div>
                        <h1
                            style="font-family: 'Neue-Plak', sans-serif; font-weight: normal; margin: 0 0 15px 0; line-height: 1.2;">
                            {{ $collection->first()->product->name }}</h1>

                        <table width="100%">
                            <tr>
                                @if (!$remove_price)
                                    <td style="font-size: 12px; margin-bottom: 2px; vertical-align: top;">
                                        <div>
                                            <div
                                                style="font-size: 12px; color: #000; opacity: 0.5;  margin-bottom: 2px;">
                                                PDV</div>
                                            <div style="font-size: 17px; ">R$199,90</div>
                                        </div>

                                    </td>
                                @endif
                                <td style="font-size: 12px;  margin-bottom: 2px;">
                                    <div style="font-size: 12px; color: #000; opacity: 0.5; margin-bottom: 2px;">Peso
                                    </div>
                                    <div style="font-size: 14px; ">241g <span style="font-size: 12px; color: #666;">Ref.
                                            nº40</span></div>
                                    <div style="font-size: 14px; ">150g <span
                                            style="font-size: 12px; color: #000; opacity: 0.5; ">Ref.
                                            nº35</span></div>
                                </td>
                            <tr>
                                <td style="font-size: 12px; margin-bottom: 2px;">
                                    <div>
                                        <div style="color: #000; opacity: 0.5;  margin-bottom: 2px;">Numeração</div>
                                        <div style="font-size: 14px;">34/44</div>
                                    </div>
                                </td>
                                <td style="font-size: 12px; margin-bottom: 2px;">
                                    <div>
                                        <div style="color: #000; opacity: 0.5;  margin-bottom: 2px;">Drop</div>
                                        <div style="font-size: 14px;">8mm</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; margin-bottom: 2px;">
                                    <div>
                                        <div style="color: #000; opacity: 0.5;  margin-bottom: 2px;">Origem</div>
                                        <div style="font-size: 14px;">Nacional</div>
                                    </div>
                                </td>
                                <td style="font-size: 12px; margin-bottom: 2px;">
                                    <div>
                                        <div style="color: #000; opacity: 0.5;  margin-bottom: 2px;">Linha</div>
                                        <div style="font-size: 14px;">-</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; margin-bottom: 2px;">
                                    <div>
                                        <div style="color: #000; opacity: 0.5;  margin-bottom: 2px;">Lançamento</div>
                                        <div style="font-size: 14px;">06/2025</div>
                                    </div>
                                </td>
                                <td style="font-size: 12px; margin-bottom: 2px;">
                                    <div>
                                        <div style="color: #000; opacity: 0.5;  margin-bottom: 2px;">Indicação</div>
                                        <div style="font-size: 14px;">Responsabilidade</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; margin-bottom: 2px;">
                                    <div>
                                        <div style="color: #000; opacity: 0.5;  margin-bottom: 2px;">Pisada</div>
                                        <div style="font-size: 14px;">Neutra</div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>

                    <!-- Descrição -->
                    <div style="padding: 0 10px 10px 10px;">
                        <div style="font-size: 12px; color: #000; opacity: 0.5; margin-bottom: 2px;">Descrição</div>
                        <p style="font-size: 13px; line-height: 1.3; color: #000; margin: 0;">
                            {{ $collection->first()->product->description }}
                        </p>
                    </div>

                    <!-- Tecnologias -->

                </td>
            </tr>
        </table>
    @endforeach
</body>

</html>
