<?php

return [

    'show_warnings' => false,

    'orientation' => 'portrait',

    'defines' => [
        'font_dir' => storage_path('fonts/'), // Caminho para salvar fontes convertidas
        'font_cache' => storage_path('fonts/'),
        'temp_dir' => storage_path('app/temp'),
        'chroot' => base_path(),

        'enable_font_subsetting' => true,
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_font' => 'AktivGrotesk',
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => true,
        'font_height_ratio' => 1.1,
    ],

    // Pasta onde está sua fonte original .ttf ou .otf
    // Use o diretório público onde as fontes existem
    'custom_font_dir' => public_path('fonts/'),

    // Registro da fonte
    'custom_font_data' => [
        'AktivGrotesk' => [
            'R' => 'AktivGrotesk-Regular.ttf',
            'B' => 'AktivGrotesk-Bold.ttf',
            'I' => 'AktivGrotesk-Italic.ttf',
            'BI' => 'AktivGrotesk-BoldItalic.ttf',
        ],
        'Neue-Plak' => [
            'R' => 'AktivGrotesk-Regular.ttf',
            'B' => 'AktivGrotesk-Bold.ttf',
            'I' => 'AktivGrotesk-Italic.ttf',
            'BI' => 'AktivGrotesk-BoldItalic.ttf',
        ],
        'neueplak' => [
            'R' => 'AktivGrotesk-Regular.ttf',
            'B' => 'AktivGrotesk-Bold.ttf',
            'I' => 'AktivGrotesk-Italic.ttf',
            'BI' => 'AktivGrotesk-BoldItalic.ttf',
        ],
        'Neue-Plak-Thin' => [
            'R' => 'AktivGrotesk-Thin.ttf',
            'B' => 'AktivGrotesk-Bold.ttf',
            'I' => 'AktivGrotesk-ThinItalic.ttf',
            'BI' => 'AktivGrotesk-BoldItalic.ttf',
        ],
        'Neue-Plak-Light' => [
            'R' => 'AktivGrotesk-Light.ttf',
            'B' => 'AktivGrotesk-Bold.ttf',
            'I' => 'AktivGrotesk-LightItalic.ttf',
            'BI' => 'AktivGrotesk-BoldItalic.ttf',
        ],
        'Neue-Plak-SemiBold' => [
            'R' => 'AktivGrotesk-Medium.ttf',
            'B' => 'AktivGrotesk-Bold.ttf',
            'I' => 'AktivGrotesk-MediumItalic.ttf',
            'BI' => 'AktivGrotesk-BoldItalic.ttf',
        ],
        'Neue-Plak-Black' => [
            'R' => 'AktivGrotesk-Black.ttf',
            'B' => 'AktivGrotesk-Bold.ttf',
            'I' => 'AktivGrotesk-BlackItalic.ttf',
            'BI' => 'AktivGrotesk-BoldItalic.ttf',
        ],
    ],

];
