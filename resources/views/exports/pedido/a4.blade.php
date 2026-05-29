<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - {{ $pedidoTitle }}</title>

    <style>
        @page {
            margin: 22px 22px 18px 22px;
        }

        @if (!isset($isPdf) || $isPdf === false)
            @font-face {
                font-family: 'Avenir Next';
                font-style: normal;
                font-weight: 400;
                src: url('{{ asset('fonts/AvenirNext/AvenirNext-Regular.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Avenir Next';
                font-style: normal;
                font-weight: 600;
                src: url('{{ asset('fonts/AvenirNext/AvenirNext-DemiBold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Avenir Next';
                font-style: normal;
                font-weight: 700;
                src: url('{{ asset('fonts/AvenirNext/AvenirNext-DemiBold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 400;
                src: url('{{ asset('fonts/FONT_MONTSERRAT/Montserrat-Regular.otf') }}') format('opentype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 600;
                src: url('{{ asset('fonts/FONT_MONTSERRAT/Montserrat-SemiBold.otf') }}') format('opentype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 700;
                src: url('{{ asset('fonts/FONT_MONTSERRAT/Montserrat-Bold.otf') }}') format('opentype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 900;
                src: url('{{ asset('fonts/FONT_MONTSERRAT/Montserrat-Black.otf') }}') format('opentype');
            }
        @endif

        @if (isset($isPdf) && $isPdf === true)
            @font-face {
                font-family: 'Avenir Next';
                font-style: normal;
                font-weight: 400;
                src: url('file://{{ public_path('fonts/AvenirNext/AvenirNext-Regular.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Avenir Next';
                font-style: normal;
                font-weight: 600;
                src: url('file://{{ public_path('fonts/AvenirNext/AvenirNext-DemiBold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Avenir Next';
                font-style: normal;
                font-weight: 700;
                src: url('file://{{ public_path('fonts/AvenirNext/AvenirNext-DemiBold.ttf') }}') format('truetype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 400;
                src: url('file://{{ public_path('fonts/FONT_MONTSERRAT/Montserrat-Regular.otf') }}') format('opentype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 600;
                src: url('file://{{ public_path('fonts/FONT_MONTSERRAT/Montserrat-SemiBold.otf') }}') format('opentype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 700;
                src: url('file://{{ public_path('fonts/FONT_MONTSERRAT/Montserrat-Bold.otf') }}') format('opentype');
            }

            @font-face {
                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 900;
                src: url('file://{{ public_path('fonts/FONT_MONTSERRAT/Montserrat-Black.otf') }}') format('opentype');
            }
        @endif

        body {
            font-family: 'Avenir Next', sans-serif;
            color: #000;
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .header td {
            vertical-align: middle;
        }

        .logo {
            width: 120px;
        }

        .title {
            text-align: right;
            font-size: 14px;
            font-weight: 600;
        }

        .list {
            margin-top: 20px;
        }

        .list td {
            padding: 8px 10px;
            border-bottom: 1px solid #e6e6e6;
            vertical-align: middle;
        }

        .list tr:last-child td {
            border-bottom: none;
        }

        .thumb {
            width: 44px;
            height: 44px;
            display: block;
        }

        .prod-name {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            line-height: 1.1;
        }

        .muted {
            color: #777;
            font-size: 9px;
        }

        .col-name {
            width: 40%;
            text-align: left;
        }

        .col-img,
        .col-cat,
        .col-gen,
        .col-code,
        .col-color,
        .col-price {
            width: 10%;
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="header">
        <tr>
            <td>
                @if (!empty($base64Svg_azul))
                    <img class="logo" src="{{ $base64Svg_azul }}" alt="Oakley">
                @endif
            </td>
            <td class="title">{{ $pedidoTitle }}</td>
        </tr>
    </table>

    <table class="list">
        @foreach ($items as $item)
            @php
                $code = $item->product->code ?? '';
                $colorCode = $item->color_code ?? '';
                $imgRel = 'images/produtos/' . $code . '_' . str_replace('/', '_', $colorCode) . '.jpg';
                $imgPath = public_path($imgRel);
                if (!file_exists($imgPath)) {
                    $imgPath = public_path('images/img-padrao-mz.png');
                }

                $categoria = optional($item->product->category)->name ?? '';
                $genero = $item->genero ?? '';
                $codigoProduto = $code;
                $cor = $item->color_name ?? ($item->color_description ?? '');
                $numeracao = optional($item->numeracao)->numero ?? '';
                $priceValue = $item->product->price ?? null;
                $priceText = '';
                if ($priceValue !== null && $priceValue !== '') {
                    $priceText = 'R$' . number_format((float) $priceValue, 2, ',', '.');
                }
            @endphp
            <tr>
                <td class="col-img">
                    <img class="thumb" src="{{ $imgPath }}" alt="">
                </td>
                <td class="col-name">
                    <div class="prod-name">{{ $item->product->name ?? '' }}</div>
                </td>
                <td class="col-cat muted">{{ $categoria }}</td>
                <td class="col-gen muted">{{ $genero }}</td>
                <td class="col-code muted">{{ $codigoProduto }}</td>
                <td class="col-color muted">{{ $cor }}</td>

                <td class="col-price muted">{{ $priceText }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
