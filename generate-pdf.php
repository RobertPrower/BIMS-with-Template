<?php

require_once("fpdf186/fpdf.php");

//Set the Paper Size and Add the page
$pdf = new FPDF ('P', 'mm', "Letter");
$pdf -> AddPage();

//Include the Logos Here
$pdf -> Image('img/BagongPinas.jpeg', 5,10,25,25);

$pdf -> Image('img/CaloocanCityLogo.png', 29,12,23,23);

$pdf -> Image('img/Brgy177.png', 170,12,23,23);

$pdf -> Image('img/watermark.png', -33,5,280,297,'PNG' );


//Header Text Here 
$pdf -> AddFont('OldEnglishTextMT', 'B', 'oldenglishtextmt.php'); 
$pdf -> SetFont('OldEnglishTextMT','B',17);
$text = 'Republic of the Philippines';
$w=$pdf->GetStringWidth($text);
$pdf -> SetX((216-$w)/2);
$pdf -> Cell($w, 8, $text, 0, 1, 'C');

$pdf -> AddFont('Rockwell', 'B', 'rockwell.php'); 
$pdf -> SetFont('Rockwell','B',17);
$text = 'BARANGAY 177, SONA 15, DISTRICT 1';
$w=$pdf->GetStringWidth($text);
$pdf -> SetX((216-$w)/2);
$pdf -> Cell($w, 8, $text, 0, 1, 'C');

$pdf -> AddFont('Cambria', 'B', 'cambria.php'); 
$pdf -> SetFont('Cambria','B',17);
$text = 'TANGGAPAN NG PUNONG BARANGAY';
$w=$pdf->GetStringWidth($text);
$pdf -> SetX((216-$w)/2);
$pdf -> Cell($w, 8, $text, 0, 1, 'C');

//Draw Line for the separation of header
$pdf -> SetLineWidth(0.5);
$pdf -> Line(1,40,220,40);
//Draw Line for the separation of Footer
$pdf -> SetLineWidth(0.5);
$pdf -> Line(1,260,220,260);
//Draw Line for the separation of Official List
$pdf -> SetLineWidth(0.5);
$pdf -> Line(70,40,70,260);

//For the Brgy Officials List
$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',13);
$pdf->SetTextColor(79, 98, 40);
$text = 'DONNA DE GANA-JARITO';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,48);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',10);
$pdf->SetTextColor(79, 98, 40);
$text = 'PUNONG BARANGAY';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,54);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'BARANGAY KAGAWAD';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,64);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'KGD.'.' '. strtoupper('Darwin L. Dela Cruz');
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,76);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',9);
$pdf->SetTextColor(79, 98, 40);
$text = 'KGD. ELOISA MARIE T. ENCARNATION';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,84);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',10);
$pdf->SetTextColor(79, 98, 40);
$text = 'KGD. GINA T. ORTIZ';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,94);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'KGD. FRANCIS S. ACOSTA';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,104);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');

$pdf -> AddFont('Bookman Old Style', 'B', 'BookmanOldStyle.php'); 
$pdf -> SetFont('Bookman Old Style','B',11);
$pdf->SetTextColor(79, 98, 40);
$text = 'KGD. RENATO C. BUSANTE.';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY((70-$w)/2,114);
$pdf -> Cell($w, 8, $text, 0, 0, 'C');


//For the Body

$maxY = $pdf->GetY();

$pdf -> AddFont('Cambria', 'BU', 'cambria.php'); 
$pdf -> SetFont('Cambria','BU',25);
$pdf->SetTextColor(0, 0, 0);
$text = 'CERTIFICATION';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(110 + (135-70-$w)/2, max($maxY, 50));
$pdf -> Cell($w, 1, $text, 0, 1, 'C');

$pdf -> AddFont('Cambria', 'B', 'cambria.php'); 
$pdf -> SetFont('Cambria','B',17);
$text = 'To whom it may concern: ';
$w=$pdf->GetStringWidth($text);
$pdf -> SetXY(80 + (135-70-$w)/2, max($maxY, 80));
$pdf -> Cell($w, 15, $text, 0, 1, 'C');

$fname='Robert';
$mname='Lumauig';
$lname='Salas';
$suffix='Sr';

$pdf -> AddFont('Cambria', '', 'cambria.php'); 
$pdf -> SetFont('Cambria','B',14);
$pdf -> SetX(35 + (80-70)/2);
$text = 'This is to certify';
$pdf -> MultiCell(146, 10, wrapText($pdf,$text,146), 0, 'C');

$pdf -> SetFont('Cambria','B',17);
$pdf -> SetXY(90,95);
$text=$fname.' '.$mname.'.'.' '.$lname.' '. $suffix;
multiLineText($pdf, $text, 146);

$pdf -> SetFont('Cambria','B',14);
$text='is a bonifade';
$pdf -> SetXY(120,110);
multiLineText($pdf, $text, 146);











$pdf -> Cell(59, 10, '',0,1);

$pdf -> Output();

function wrapText($pdf,$text,$maxWidth){

   $textWidth = $pdf->GetStringWidth($text);
   while($textWidth>$maxWidth){
        $text =substr($text, 0, -1);
        $textWidth = $pdf->GetStringWidth($text);

   }
   return $text;
}

function multiLineText($pdf, $text, $maxWidth) {
    $words = explode(' ', $text);
    $lines = array($words[0]);
    $currentLine = 0;
    for ($i = 1; $i < count($words); $i++) {
        $lineSize = $pdf->GetStringWidth($lines[$currentLine] . ' ' . $words[$i]);
        if ($lineSize > $maxWidth) {
            $currentLine++;
            $lines[$currentLine] = $words[$i];
        } else {
            $lines[$currentLine] .= ' ' . $words[$i];
        }
    }

    foreach ($lines as $line) {
        $pdf->MultiCell($maxWidth, 10, $line, 0, 'C');
    }
}


?>