<?php

return [

    'show_warnings' => false,

    'orientation' => 'portrait',

    'defines' => [
        'font_dir' => storage_path('fonts/'), // Caminho para salvar fontes convertidas
        'font_cache' => storage_path('fonts/'),
        'temp_dir' => storage_path('app/temp'),
        'chroot' => base_path(),

        'enable_font_subsetting' => false,
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_font' => 'sans-serif',
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => true,
        'font_height_ratio' => 1.1,
    ],

    // Pasta onde está sua fonte original .ttf ou .otf
    'custom_font_dir' => storage_path('fonts/'),

    // Registro da fonte
    'custom_font_data' => [
        'fkolympikus' => [
            'R' => 'FKOlympikus-Upright.ttf', // Caminho relativo ao custom_font_dir
            'B' => 'FKOlympikus-Bold.ttf',
            'I' => 'FKOlympikus-Italic.ttf',
            'BI' => 'FKOlympikus-BoldItalic.ttf',
            'S' => 'FKOlympikus-SmallCaps.ttf',
        ],
    ],

];
