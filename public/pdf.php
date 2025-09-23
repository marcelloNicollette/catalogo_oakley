<?php
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('fontDir', __DIR__ . '/storage/fonts');
$options->set('fontCache', __DIR__ . '/storage/fonts');
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);

$fontPath = 'file://' . __DIR__ . '/storage/fonts/LiberationMono-Regular.ttf';

$html = '
    <style>
        @font-face {
            font-family: "neueplak";
            src: url("' . $fontPath . '") format("truetype");
        }
        body {
            font-family: "neueplak";
        }
    </style>
    <p>Teste fonte LiberationMono no DomPDF</p>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

file_put_contents('teste.pdf', $dompdf->output());

echo "PDF gerado, verifique storage/fonts se .json foi criado\n";
