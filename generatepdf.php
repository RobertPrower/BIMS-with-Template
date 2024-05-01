<?php

require(__DIR__."/vendor/autoload.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$html='


';

$options = new Options;
$options->setChroot(__DIR__);

$dompdf = new Dompdf([
  "chroot"=>__DIR__
]);

$dompdf->loadHtmlFile("generate-residence.html");

$dompdf->render();

$dompdf->stream("good-moral.pdf", ["Attachment" =>0]);

?>