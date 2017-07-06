

<?php
    include("vendor/autoload.php");

    $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
    echo $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);

?>