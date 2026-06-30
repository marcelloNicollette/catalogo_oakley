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
            border: 1px solid #e6e6e6;
        }

        .list thead th {
            padding: 7px 10px;
            border-bottom: 1px solid #d8d8d8;
            font-size: 9px;
            text-transform: uppercase;
            color: #666;
            font-weight: 700;
            text-align: center;
        }

        .list td {
            padding: 8px 10px;
            border-bottom: 1px solid #e6e6e6;
            vertical-align: middle;
        }

        .list > tbody > tr:last-child > td {
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
            text-align: center;
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

        .grade-inline {
            padding: 2px 0 8px 0;
        }

        .grade-inline-title {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 4px;
        }

        .grade-row tr:last-child {
            padding-top: 0;
            border-bottom: 1px solid #e6e6e6;
        }

        .grade-row td {
            padding-top: 0;
            border-bottom: 1px solid #e6e6e6;
        }

        .grade-row:last-child td {
            border-bottom: none;
        }

        .grade-inline-table {
            width: 100%;
            border-collapse: collapse;
        }

        .grade-inline-table th,
        .grade-inline-table td {
            border: 1px solid #ececec;
            padding: 3px 4px;
            text-align: center;
            font-size: 8px;
            line-height: 1.15;
        }

        .grade-inline-table th {
            background: #f7f7f7;
            font-weight: 700;
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
        @if (!empty($headings))
            <thead>
                <tr>
                    @foreach ($headings as $heading)
                        <th>{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
        @foreach ($items as $item)
            @php
                $code = $item->product->code ?? '';
                $colorCode = $item->color_code ?? '';
                $selectionKey = ($item->product_id ?? '') . '-' . $colorCode;
                $selectionMeta = $selectedMeta[$selectionKey] ?? ['grade_rows' => []];
                $gradeRows = is_array($selectionMeta['grade_rows'] ?? null) ? $selectionMeta['grade_rows'] : [];
                $imgRel = 'images/produtos/' . $code . '_' . str_replace('/', '_', $colorCode) . '_A.jpg';
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
            @if (!empty($gradeRows))
                <tr class="grade-row">
                    <td colspan="{{ !empty($headings) ? count($headings) : 7 }}">
                        <div class="grade-inline">
                            <div class="grade-inline-title">Grades do Pedido</div>
                            <table class="grade-inline-table">
                                <thead>
                                    <tr>
                                        <th>Grade</th>
                                        <th>Qtd</th>
                                        @foreach ($monthColumns as $monthColumn)
                                            <th>{{ $monthColumn['label'] ?? '' }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gradeRows as $gradeRow)
                                        @php
                                            $monthlyQuantities = is_array($gradeRow['monthly_quantities'] ?? null)
                                                ? $gradeRow['monthly_quantities']
                                                : [];
                                        @endphp
                                        <tr>
                                            <td>{{ $gradeRow['grade_code'] ?? '' }}</td>
                                            <td>{{ $gradeRow['quantity'] ?? 0 }}</td>
                                            @foreach ($monthColumns as $monthColumn)
                                                <td>{{ $monthlyQuantities[$monthColumn['code']] ?? 0 }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</body>

</html>
