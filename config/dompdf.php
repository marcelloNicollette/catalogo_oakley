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
        'default_font' => 'Neue-Plak',
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
        // Registra com o mesmo nome usado nos templates
        'Neue-Plak' => [
            'R' => 'Neue-Plak-Regular.ttf', // relativo ao custom_font_dir
            'B' => 'Neue-Plak-Bold.ttf',
            'I' => 'Neue-Plak-Regular.ttf',
            'BI' => 'Neue-Plak-Bold.ttf',
        ],
        // Alias para compatibilidade com outros templates
        'neueplak' => [
            'R' => 'Neue-Plak-Regular.ttf',
            'B' => 'Neue-Plak-Bold.ttf',
            'I' => 'Neue-Plak-Regular.ttf',
            'BI' => 'Neue-Plak-Bold.ttf',
        ],
        // Famílias específicas por variação
        'Neue-Plak-Thin' => [
            'R' => 'Neue-Plak-Thin.ttf',
            'B' => 'Neue-Plak-Bold.ttf',
            'I' => 'Neue-Plak-Thin.ttf',
            'BI' => 'Neue-Plak-Bold.ttf',
        ],
        'Neue-Plak-Light' => [
            'R' => 'Neue-Plak-Light.ttf',
            'B' => 'Neue-Plak-Bold.ttf',
            'I' => 'Neue-Plak-Light.ttf',
            'BI' => 'Neue-Plak-Bold.ttf',
        ],
        'Neue-Plak-SemiBold' => [
            'R' => 'Neue-Plak-SemiBold.ttf',
            'B' => 'Neue-Plak-Bold.ttf',
            'I' => 'Neue-Plak-SemiBold.ttf',
            'BI' => 'Neue-Plak-Bold.ttf',
        ],
        'Neue-Plak-Black' => [
            'R' => 'Neue-Plak-Black.ttf',
            'B' => 'Neue-Plak-Bold.ttf',
            'I' => 'Neue-Plak-Black.ttf',
            'BI' => 'Neue-Plak-Bold.ttf',
        ],
    ],

];
